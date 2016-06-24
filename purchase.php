<?php
require_once("config.php");

if (!logged_in()) {
	echo "Not logged in. Click " . "<a href=index.php>here</a>" . " to return to the homepage.";
	die();	// we dont want people sending scruffybot incomplete data (steamid64 missing)
}
$market_hash_names = array();
$asset_ids = array();
foreach ($_POST["item"] as $x) {
	array_push($market_hash_names, explode("/", $x)[0]);
	array_push($asset_ids, explode("/", $x)[1]);
}
emit_data(create_network_data($asset_ids, $db), $client);
$_SESSION["market_hash_names"] = $market_hash_names;
header("Location: confirmation.php");
?>
