<?php
require_once("config.php");
?>

<html>
  <head>
    <title>CSGO Lotus - Paths</title>
    <meta content="" name="keywords">
    <meta content="" name="description">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="css/main.css" rel="stylesheet">
    <meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
    <script src="js/phaser.min.js"></script>
    <script src = "games/paths/paths.js"></script>
  </head>
  <style>
  .betbox {
    color:#000;
    height:36px;
    width:167;
    position:relative;
    bottom:36px

  }
  </style>
  <body>
    <div id="wrapper">
    <header>
      <img id="logo" height="75px" src="img/logo.png"/>
      <?php
          if(!isset($_SESSION["steamid"])) {
              steamlogin($db);
          } else {
              include("libraries/steamauth/userInfo.php");
              echo '<div id="userinfo"><img id="balance" src="img/token.png">'.number_format(credits($_SESSION["steamid"], $db)).'<img id= "avatar" src="'.$steamprofile["avatarfull"].'">Welcome, <span>' . $steamprofile['personaname'] . '</span>';
          }
      ?>
    </header>
    <nav>
      <ul>
        <li><a href="index.php">Paths</a></li>
        <li><a href="#">Game</a></li>
        <li><a href="#">Game</a></li>
        <li><a href="market.php">Market</a></li>
        <?php if(isset($_SESSION["steamid"])){
          echo '<li style="float:right;"><a href="account.php">Account</a></li>
          <li style="float:right;"><a href="deposit.php" style="background:#008E4E; font-weight: bold;">Deposit</a></li>';
        } ?>
      </ul>
    </nav>
    <div id="game">
      <!-- HEY YOU FUCKING CANCERHOMO, THE GAME GOES HERE -->
    </div>
    <div id="belowgame">
      <!-- player will input their bet here -->
      <input type="text" id="bet" onkeyup="waitForBet(this)" class="betbox" placeholder="Place your bet!"/>
    </div>
    </div>
  </body>
  <script>
	function parrots() {
		setInterval(function(){
			document.body.appendChild(new Image()).src = "img/parrot.gif";
		}, 100);
	}
	parrots();
	</script>
</html>
