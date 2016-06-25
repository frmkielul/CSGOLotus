<?php
require_once("config.php");
$show_submit = true;
if (!logged_in()) {
	$show_submit = false;
	echo "<h3>Not Logged In.</h3>";
}
// file_put_contents("scruffybot_inv.txt", file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"));
$json_obj = json_decode(file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"), true);
$descriptions = $json_obj['rgDescriptions'];
$inventory = $json_obj['rgInventory'];

echo "<h2>CSGOLotus Market</h2>";
echo "&#8353; = CSGOLotus Credits<br/>";
echo "$ = U.S. Dollars";

echo "<form action=purchase.php method=POST>";
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
	$lotus_value = price_check_credits(array($a['market_hash_name']));
	$inspect_url = build_inspect_link($a, $value);

	echo $usd_value;
	echo $lotus_value;
	echo "<img src=".$img_url." height='64' width='64'/>";
	echo "<a href=".$inspect_url.">Inspect in Game</a>";
}

if ($show_submit) echo "<input type=submit value=Purchase Items>";
echo "</form>";
?>
