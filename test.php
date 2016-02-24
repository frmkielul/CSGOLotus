<?php
	require_once('config.php');

	// emit_game_data(['steamid64' => "01234567890123456789", 'items'=>array('itemone'=>'a','itemtwo'=>'b')], $client);
	// emit_game_data(['items'=>array('itemone'=>'a','itemtwo'=>'b')], $client);
	emit_game_data([['id' => 'a'], ['id' => 'b'], ['id' => 'c'], ['id' => 'd']], $client);
?>