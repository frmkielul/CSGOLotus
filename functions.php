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
function getSteamID64() {
	include("libraries/steamauth/userInfo.php");
	if (isLoggedIn()) {
		return $steamprofile['steamid'];
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
/**
 * @param int $init
 * @param int $amt
 *
 * Addition """""algorithm""""" which rolls over at 3.
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
 * array(['server_seed' => $serverseed], ['client_seed' => $clientseed]);
 * or something like that I don't fucking know
 */
function emit_game_data($gamedata, $client) {
	$client->initialize();
	$client->emit('broadcast', $gamedata);
	$client->close();
}
/**
 * @param array $selected
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