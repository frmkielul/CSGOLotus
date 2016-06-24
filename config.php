<?php
/* Project Dependencies */
require_once("libraries/vendor/autoload.php");
require_once("libraries/steamauth/steamauth.php");
require_once("functions.php");

use GuzzleHttp\Client;
use Steam\Configuration;
use Steam\Runner\GuzzleRunner;
use Steam\Runner\DecodeJsonStringRunner;
use Steam\Steam;
use Steam\Utility\GuzzleUrlBuilder;
use ElephantIO\Client as EClient;
use ElephantIO\Engine\SocketIO\Version1X;

$GLOBALS['creditprefix'] = "&#8353;";

/* SteamAPI Configuration */
$steam = new Steam(new Configuration([
    Configuration::STEAM_KEY => '2725770A29064372233CB9F5636B30D5'
]));
$steam->addRunner(new GuzzleRunner(new Client(), new GuzzleUrlBuilder()));
$steam->addRunner(new DecodeJsonStringRunner());

/* Database Configuration */
$DB_USER = "csgolotus";
$DB_NAME = "csgolotus";
$DB_PASS = "ufUL3e86NqUqjhV";	// TODO: Store this elsewhere for security reasons
$DB_HOST = "localhost";			// TODO: Change password in the future cause its ON FUCKING GITHUB

$db = new PDO("mysql:dbname=$DB_NAME;host=$DB_HOST", $DB_USER, $DB_PASS);

$client = new EClient(new Version1X('http://localhost:8080'));
?>
