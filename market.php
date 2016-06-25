<?php
require_once("config.php");
$show_submit = true;
if (!logged_in()) {
	$show_submit = false;
	echo "<h3>Not Logged In.</h3>";
}
// file_put_contents("scruffybot_inv.txt", file_get_contents("http://steamcommunity.com/id/thescruffybot/inventory/json/730/2"));


echo "<h2>CSGOLotus Market</h2>";
echo "&#8353; = CSGOLotus Credits<br/>";
echo "$ = U.S. Dollars";

echo "<form action=purchase.php method=POST>";
draw_market();

if ($show_submit) echo "<input type=submit value=Purchase Items>";
echo "</form>";
?>
