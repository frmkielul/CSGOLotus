<?php
require_once("config.php");

if (!logged_in()) {
	echo "Not logged in. Click " . "<a href=index.php>here</a>" . " to return to the homepage.";
	die();	// we dont want people sending scruffybot incomplete data (steamid64 missing)
}

$selected_items = $_POST["item"];
echo "<b>You have selected the following items: </b><br />";
echo "<ul>";
foreach ($selected_items as $a) {
	echo "<li>" . $a . "</li><br />";
}
echo "</ul>";

echo "Your current account balance: " . credits(get_steamid64(), $db) . "<br />";
echo "Your account will be deducted " . price_check_credits($selected_items) . " credits for this transaction.";

echo "<br /><br />";
emit_data(create_network_data($selected_items, $db), $client);	
echo "Your request has been processed and you will receieve a trade offer on Steam.<br />";
?>