<?php
$json_obj = json_decode(file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"), true);
echo "<pre>";
print_r($json_obj);
echo "</pre>";
?>
