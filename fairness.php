<?php
require_once("config.php");

// generate 2 random 10-digit base-3 strings
// ex: 2220210110
$serverseed = base_convert(rand(29524, 59048), 10, 3);
$clientseed = base_convert(rand(29524, 59048), 10, 3);
$hash = hash("sha256", hash("sha256", $serverseed));

$serverseed_array = array_map('intval', str_split($serverseed));
$clientseed_array = array_map('intval', str_split($clientseed));
$result_array = add_seeds($serverseed_array, $clientseed_array);

echo "Server Seed Hash: " . $hash . "<br />";
echo "Server Seed: " . $serverseed . "<br />";
echo "Client Seed: " . $clientseed . "<br />";
echo "Result: " . implode("", $result_array);

if (isset($_POST["submit"])) {
	emit_game_data(array(['server_seed' => $serverseed], ['client_seed' => $clientseed]), $client);
	echo "<br />Game data send with values: " . $serverseed . "	" . $clientseed . "<br/>";
}

?>
<html>
<body>

<form action="fairness.php" method="post">
<input type="submit" name="submit">
</form>

</body>
</html>


