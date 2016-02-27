<?php
require_once("config.php");

function isDuplicate($db) {
	$res = $db->query("SELECT STEAMID64 FROM users WHERE STEAMID64='getSteamID64()'");
	if ($res->rowCount() > 0) {
		return true; // duplicate
	} else {
		return false; // no duplicate
	}
}
function register_firsttime($db) {
	if (!isDuplicate($db)) {
		$stmt = $db->prepare("INSERT INTO users(STEAMID64, date_registered) VALUES(?, NOW())");
		$stmt->execute(array(getSteamID64()));
	} else {
		echo "Something bad happened!<br />";
	}
}
/* Query the database WHERE username = ? using secure prepared statements */
function idQuery( $query, $db, $steamid64 ) {
	$stmt = $db->prepare($query);
	$stmt->bindValue(1, $steamid64, PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch();
	
	return $row;
}
function getSteamID64() {
	include("libraries/steamauth/userInfo.php");
	if (isLoggedIn()) {
		return $steamprofile['steamid'];
	} else {
		return "0";
	}
}
function isLoggedIn() {
	if (isset($_SESSION["steamid"])) {
		return true;
	} else {
		return false;
	}
}
function update_tradeurl($steamid64, $tradeurl, $db) {
	$query = $db->prepare("UPDATE users SET trade_url = ? WHERE STEAMID64 = ?");
	$query->execute(array($tradeurl, $steamid64));
}
// query the database and return a user's tradeurl as a string
function getTradeUrl($steamid64, $db) {
	$query = idQuery("SELECT trade_url FROM users WHERE steamid64 = ?", $db, $steamid64);
	return $query["trade_url"];
}
// query the database and return a user's tradeurl as an int
function getCredits($steamid64) {
	$query = idQuery("SELECT credits FROM users WHERE steamid64 = ?", $db, $steamid64);
	return $query["credits"];
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
function emit_game_data($gamedata, $client) {
	$client->initialize();
	$client->emit('broadcast', $gamedata);
	$client->close();
}
function createNetworkData($selected_items, $db) {
	$data = array();
	$data[0]['sid'] = getSteamID64();
	$data[0]['tradeurl'] = getTradeUrl(getSteamID64(), $db);
	
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
 * This is now handled by the Steambot so don't call it.
 */
function pricecheck($selected) {
	// http://backpack.tf/api/IGetMarketPrices/v1/?key=56cd0ca5b98d88be2ef9de16&appid=730
	$bptf_obj = json_decode(file_get_contents("bp_schema.txt"), true);
	$bpitems = $bptf_obj['response']['items'];

	$inv_obj = json_decode(file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"), true);
	$invitems = $inv_obj['rgDescriptions'];
	
	$selected = array();
	$total = 0.00;
	
	foreach ($selected as $a) {
		$total = $total + $bpitems[$a]['value'];
	}
	return '$'.($total/100);
}
?>