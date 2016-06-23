<?php

$json_obj = json_decode(file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"), true);

echo "<pre>";
echo json_encode($json_obj, JSON_PRETTY_PRINT);
echo "</pre>";

?>