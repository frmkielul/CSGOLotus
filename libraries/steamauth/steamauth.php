<?php
ob_start();
session_start();
require('openid.php');
require_once("C:/xampp/htdocs/csgolotus/config.php");

function logoutbutton()
{
    echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"Logout\" type=\"submit\" /></form>"; //logout button
}

function steamlogin($db)
{
    try {
        require("settings.php");
        $openid = new LightOpenID($steamauth['domainname']);

        $button['small']    = "small";
        $button['large_no'] = "large_noborder";
        $button['large']    = "large_border";
        $button             = $button[$steamauth['buttonstyle']];

        if (!$openid->mode) {
            if (isset($_GET['login'])) {
                $openid->identity = 'http://steamcommunity.com/openid';
                header('Location: ' . $openid->authUrl());
            }
            echo "<a href='?login' class='steambutton'><span>Login with Steam</span><div class='icon'><i class='fa fa-steam-square'></i></div></a>";
        }

        elseif ($openid->mode == 'cancel') {
            echo 'User has canceled authentication!';
        } else {
            if ($openid->validate()) {
                $id  = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);

                $_SESSION['steamid'] = $matches[1];

				// user has successfully logged in from steam
				register_firsttime($db, $matches[1]);

                if (isset($steamauth['loginpage'])) {
                    header('Location: ' . $steamauth['loginpage']);
                }
            } else {
                echo "User is not logged in.\n";
            }

        }
    }
    catch (ErrorException $e) {
        echo $e->getMessage();
    }
}

?>
