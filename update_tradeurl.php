<?php
require_once("config.php");
include ('libraries/steamauth/userInfo.php'); //To access the $steamprofile array

// TODO: Fix the POST issue not receiving the tradeurl from the html

$steamid64 = $steamprofile['steamid'];
$tradeurl = $_POST["tradeurl"];

update_tradeurl($steamid64, $tradeurl, $db);
?>
