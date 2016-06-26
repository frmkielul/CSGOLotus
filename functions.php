<?php
require_once("config.php");

function is_duplicate($db) {
	$res = $db->query("SELECT STEAMID64 FROM users WHERE STEAMID64='get_steamid64()'");
	return $res->rowCount() > 0;
}
function register_firsttime($db, $sid) {
	if (!is_duplicate($db)) {
		$stmt = $db->prepare("INSERT INTO users(STEAMID64, date_registered) VALUES(?, NOW())");
		$stmt->execute(array($sid));
	} else {
		echo "Something bad happened!<br />";
	}
}
/* Query the database WHERE username = ? using secure prepared statements */
function id_query( $query, $db, $steamid64 ) {
	$stmt = $db->prepare($query);
	$stmt->bindValue(1, $steamid64, PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch();

	return $row;
}
// Deprecated as of 6/23/16. Use $_SESSION["steamid"] instead
function get_steamid64() {
	include("libraries/steamauth/userInfo.php");
	if (logged_in()) {
		return $steamprofile['steamid'];
	} else {
		return "0";
	}
}
function logged_in() {
	return isset($_SESSION["steamid"]);
}
function update_tradeurl($steamid64, $tradeurl, $db) {
	$query = $db->prepare("UPDATE users SET trade_url = ? WHERE STEAMID64 = ?");
	$query->execute(array($tradeurl, $steamid64));
}
// query the database and return a user's tradeurl as a string
function trade_url($steamid64, $db) {
	$query = id_query("SELECT trade_url FROM users WHERE steamid64 = ?", $db, $steamid64);
	return $query["trade_url"];
}
// query the database and return a user's tradeurl as an int
function credits($steamid64, $db) {
	$query = id_query("SELECT credits FROM users WHERE steamid64 = ?", $db, $steamid64);
	return $query["credits"];
	// return "&#8353;" . id_query("SELECT credits FROM users WHERE steamid64 = ?", $db, $steamid64)["credits"];
}
/**
 * @param int $init
 * @param int $amt
 *
 * Recursive addition """""algorithm""""" which rolls over at 3.
 * Example: 2+1 = 0		0+3 = 0
 */
function add_wrap($init, $amt) {
	if (($init + $amt) > 2) {
		if ($init == 1) {
			return add_wrap(($init-1), 0);
		} else {
			return add_wrap(0, ($amt-1));
		}
	} else {
		return $init+$amt;
	}
}
/**
 * @param array $ss
 * @param array $cs
 *
 * Adds two arrays using the roll-over-at-three function
 */
function add_seeds($ss, $cs)  {
	$result_array = array();
	for ($i = 0; $i < 10; ++$i) {
		$result_array[$i] = add_wrap($ss[$i], $cs[$i]);
		if (count($result_array) == 10) {
			return $result_array;
		}
	}
}
/**
 * @param array $gamedata
 * @param Client $client
 *
 * example array:
 * [
 * ['sid' => '76561198043295952', 'tradeurl' => 'https://steamcommunity.com/tradeoffer/new/?partner=83030224&token=iOs-d62d'],
 * ['id' => 'Tec-9 | VariCamo (Field-Tested)', 'amt' => 1],
 * ['id' => 'XM1014 | Blue Spruce (Minimal Wear)', 'amt' => 1]
 * ]
 */
function emit_data($data, $client) {
	$client->initialize();
	$client->emit('broadcast', $data);
	$client->close();
}
function create_network_data($selected_items, $db) {
	if (!logged_in()) {
		return;
	}
	$data = array();
	$data[0]['sid'] = get_steamid64();
	$data[0]['tradeurl'] = trade_url(get_steamid64(), $db);

	$count = 1;
	foreach ($selected_items as $i) {
		$data[$count]['id'] = $i;
		$data[$count]['amt'] = 1;
		$count++;
	}
	return $data;
}
/**
 * @param array $selected
 */
function price_check($selected) {
	// http://backpack.tf/api/IGetMarketPrices/v1/?key=572ffdc0c4404533f945e852&appid=730
	$bptf_obj = json_decode(file_get_contents("bp_schema.txt"), true);
	$bpitems = $bptf_obj['response']['items'];

	$inv_obj = json_decode(file_get_contents("scruffybot_inv.txt"), true);
	$invitems = $inv_obj['rgDescriptions'];

	$total = 0.00;

	foreach ($selected as $a) {
		$total += $bpitems[$a]['value'];
	}
	return '$' . ($total/100);
}
function price_check_credits($selected) {
	// http://backpack.tf/api/IGetMarketPrices/v1/?key=572ffdc0c4404533f945e852&appid=730
	$bptf_obj = json_decode(file_get_contents("bp_schema.txt"), true);
	$bpitems = $bptf_obj['response']['items'];

	$inv_obj = json_decode(file_get_contents("scruffybot_inv.txt"), true);
	$invitems = $inv_obj['rgDescriptions'];

	$total = 0.00;

	foreach ($selected as $a) {
		$total = $total + $bpitems[$a]['value'];
	}
	return $GLOBALS['creditprefix'] . round((($total/100)/0.03)*100, 0);
}
/* Market Functions */
function item_img_url($item) {
	return "http://cdn.steamcommunity.com/economy/image/" . $item['icon_url'];
}
function build_inspect_link($item, $value) {
	$inspect_url = $item['actions'][0]['link'];
	$url_fragment = explode("%", $inspect_url)[5];
	return "steam://rungame/730/76561202255233023/+csgo_econ_action_preview%20S76561198180102897A" . $value . $url_fragment;
}
function draw_market() {
	$json_obj = json_decode(file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"), true);
	$descriptions = $json_obj['rgDescriptions'];
	$inventory = $json_obj['rgInventory'];
	echo "<table>";
	foreach ($descriptions as $a) {
		// skips any csgo cases
		if ($a["commodity"] == 1) {
			continue;
		}
		$img_url = item_img_url($a);
		$value = "";
		foreach ($inventory as $x) {
			if ($a['classid'] == $x['classid'] && $a['instanceid'] == $x['instanceid']) {
				$value = $x['id'];
			}
		}
		$usd_value = price_check(array($a['market_hash_name']));
		$name = $a['market_hash_name'];
		$lotus_value = price_check_credits(array($a['market_hash_name']));
		$inspect_url = build_inspect_link($a, $value);

		preg_match('#\((.*?)\)#', $name, $match);

		echo "<tr>";
		echo '<p>'.$lotus_value.'</p>';
		echo "<img src=".$img_url." height='100'/>";
		echo '<p>'.$match[1].'</p>';
		echo "<a href=".$inspect_url.">Inspect in Game</a>";
		echo "</tr>";

	}
	echo "</table>";
}
?>
