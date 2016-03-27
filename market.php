<?php
require_once("config.php");

if (!logged_in()) {
	echo "Not logged in. Click " . "<a href=index.php>here</a>" . " to return to the homepage.";
	die();	// prevent any unnecessary calls to price_check and price_check_credits which slow down the page a lot.
}

$json_obj = json_decode(file_get_contents("scruffybot_inv.txt"), true);
$items = $json_obj['rgDescriptions'];

echo "<h2>CSGOLotus Market</h2>";
echo "&#8353; = CSGOLotus Credits<br/>";
echo "$ = U.S. Dollars";

echo "<form action=purchase.php method=POST>";
foreach ($items as $a) {
	$img_url = "http://cdn.steamcommunity.com/economy/image/" . $a['icon_url'];
	echo "<input type='checkbox' name='item[]' value=\"" . $a['market_hash_name'] . "\"><img src=".$img_url." height='64' width='64'/>" . $a['market_hash_name'] . " " . price_check_credits(array($a['market_hash_name'])) . " | " . price_check(array($a['market_hash_name'])) . "<br>";
	
	//echo "<input type='checkbox' name='item' value=\"" . $a['market_hash_name'] . "\"><br />";
}
echo "<input type=submit value=Purchase Items>";
echo "</form>";
?>
