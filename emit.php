<?php
require_once('config.php');

//	emit_game_data([['sid' => '76561198043295952', 'tradeurl' => 'https://steamcommunity.com/tradeoffer/new/?partner=83030224&token=iOs-d62d'], ['id' => 'Tec-9 | VariCamo (Field-Tested)', 'amt' => 1], ['id' => 'XM1014 | Blue Spruce (Minimal Wear)', 'amt' => 1]], $client);
//	emit_game_data([['sid' => getSteamID64(), 'tradeurl' => getTradeUrl(getSteamID64())], ['id' => 'Tec-9 | VariCamo (Field-Tested)', 'amt' => 1], ['id' => 'XM1014 | Blue Spruce (Minimal Wear)', 'amt' => 1]], $client);

$selected_items = array('Tec-9 | VariCamo (Field-Tested)', 'XM1014 | Blue Spruce (Minimal Wear)');

emit_game_data(createNetworkData($selected_items, $db), $client);	
?>