<?php
require_once("config.php");

$json_obj = json_decode(file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"), true);
$items = $json_obj['rgDescriptions'];

/*print "<pre>";
print_r($items);
print "</pre>";*/

echo "<form>";
foreach ($items as $a) {
	$img_url = "http://cdn.steamcommunity.com/economy/image/" . $a['icon_url'];
	echo "<input type='checkbox' name='item' value=" . $a['market_hash_name'] . "><img src=".$img_url." height='64' width='64'/><br>";
}
echo "</form>";

/*
	TODO: Show a nice 9 by X table with the image of each skin and the cost in credits below it
*/
?>
