<?php
require_once("config.php");

$show_prices = true;

if (!logged_in()) {
	$show_prices = false;
}

$json_obj = json_decode(file_get_contents("scruffybot_inv.txt"), true);
$descriptions = $json_obj['rgDescriptions'];
$inventory = $json_obj['rgInventory'];
file_put_contents("scruffybot_inv.txt", file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"));

echo "<h2>CSGOLotus Market</h2>";
echo "&#8353; = CSGOLotus Credits<br/>";
echo "$ = U.S. Dollars";

// TODO: to allow cases to be displayed, we must find a common identifier for cases, and exclude them from the $a['actions'][0]['link'] call.
echo "<form action=purchase.php method=POST>";
foreach ($descriptions as $a) {
	$img_url = "http://cdn.steamcommunity.com/economy/image/" . $a['icon_url'];
	$value = "";
	foreach ($inventory as $x) {
		if ($a['classid'] == $x['classid'] && $a['instanceid'] == $x['instanceid']) {
			$value = $x['id'];
		}
	}
	$inspect_url = $a['actions'][0]['link'];
	$url_fragment = explode("%", $inspect_url)[5];
	echo "<input type='checkbox' name='item[]' value=\"" . $a['market_hash_name'] . "/" . $value . "\"><img src=".$img_url." height='64' width='64'/>" . $a['market_hash_name'] . " " . 
	price_check_credits(array($a['market_hash_name'])) . " | " . price_check(array($a['market_hash_name'])) . " | <a href=steam://rungame/730/76561202255233023/+csgo_econ_action_preview%20S76561198180102897A" . $value . $url_fragment .">Inspect In-Game</a><br>";
}

echo "<input type=submit value=Purchase Items>";
echo "</form>";
?>
