<?php
ob_start();
session_start();
require ('openid.php');
require_once("C:/xampp/htdocs/csgolotus/config.php");

function logoutbutton() {
    echo '<div id="loginbutton"><a href="libraries/steamauth/logout.php" id="steambutton"><span>Sign Out</span><div id="icon"><i class="fa fa-sign-out"></i></div></a></div>';
}

function steamlogin($db)
{
try {
    require("settings.php");
    $openid = new LightOpenID($steamauth['domainname']);
    
    $button['small'] = "small";
    $button['large_no'] = "large_noborder";
    $button['large'] = "large_border";
    $button = $button[$steamauth['buttonstyle']];
    
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
    echo '<div id="loginbutton"><a href="?login" id="steambutton"><span>Sign In</span><div id="icon"><i class="fa fa-steam-square"></i></div></a></div>';
}

     elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) { 
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
              
        $_SESSION['steamid'] = $matches[1];
         
        $query = $db->prepare("SELECT * FROM users WHERE STEAMID64=?");
        $query->execute(array($_SESSION['steamid']));
         
        if ($query->rowCount() == 0) {
            $stmt = $db->prepare("INSERT INTO users (STEAMID64) VALUES (?)");
            $stmt->execute(array($_SESSION['steamid']));
        }
        if (isset($steamauth['loginpage'])) {
            header('Location: '.$steamauth['loginpage']);
        }
        } else {
                echo "User is not logged in.\n";
        }

    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}

?>
