<?php
require_once("config.php");

echo "<b>You have selected the following items: </b><br />";
echo "<ul>";

foreach ($_SESSION["market_hash_names"] as $a) {
	echo "<li>" . $a . "</li><br />";
}
echo "</ul>";

echo "Your current account balance: " . credits(get_steamid64(), $db) . "<br />";
echo "Your account will be deducted " . price_check_credits($_SESSION["market_hash_names"]) . " credits for this transaction.";

echo "<br /><br />";
echo "Your request has been processed and you will receieve a trade offer on Steam.<br />";
echo "Click " . "<a href=market.php>here</a>" . " to return to the market.";
$_SESSION["market_hash_names"] = array();
?>
