<?php
require_once("config.php");
include ('libraries/steamauth/userInfo.php'); //To access the $steamprofile array

// TODO: Fix the POST issue not receiving the tradeurl from the html
// No data is received in the POST, so the problem must be in Pedro's cancerous HTML.

$steamid64 = $steamprofile['steamid'];
$tradeurl = $_POST["tradeurl"];

var_dump($_POST);

update_tradeurl($steamid64, $tradeurl, $db);
?>
