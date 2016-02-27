<?php
require_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSGO Lotus - Easy, Fun, Provably Fair Skin Gambling</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="css/mainstyle.css" rel="stylesheet">
</head>
<body>
    <div class="container">
    <div class="row header">
      <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 navbar-brand-col">
      <img src="img/logo.png"/>
      </div>
      <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xl-4 balance">
      Balance and Shit
      </div>
      <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1">
            <?php
                if(!isset($_SESSION["steamid"])) {
                    steamlogin($db);
                } else {
                    include("libraries/steamauth/userInfo.php");
                    echo '<div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">ACCOUNT</h4>
                          </div>
                          <div class="modal-body">
                           <img src="'.$steamprofile["avatarmedium"].'"class="img-rounded">
                            <form action=update_tradeurl.php class="form-inline" id="tlink">
                              <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">Trade Link</label>
                                <div class="input-group">
                                  <div class="input-group-addon">Trade Link</div>
                                  <input type="text" class="form-control" id="exampleInputAmount" name="tradeurl" placeholder="trade url">
                                </div>
                              </div>
                              <button type="submit" class="btn btn-success btn-sm">Update</button>
                            </form>
                            <p>Get your own URL <a href="http://steamcommunity.com/profiles/'.$steamprofile['steamid'].'/tradeoffers/privacy" target="_blank">here</a></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>';
                    echo '<div id="userinfo">Welcome, <span>' . $steamprofile['personaname'] . '</span><div id="icon" data-toggle="modal" data-target="#settings"><a href="#"><i class="fa fa-cog"></i></a></div></div>';
                }
            ?>
      </div>
    </div>
    </div>
</body>
</html>
<!--
168		                 !#########       #
169	               !########!          ##!
170	            !########!               ###
171	         !##########                  ####
172	       ######### #####     Scruffix    ######
173	        !###!      !####!              ######
174	          !           #####            ######!
175	                        !####!         #######
176	                           #####       #######
177	                             !####!   #######!
178	                                ####!########
179	             ##                   ##########
180	           ,######!          !#############
181	         ,#### ########################!####!
182	       ,####'     ##################!'    #####
183	     ,####'            #######              !####!
184	    ####'                                      #####
185	    ~##                                          ##~
186	-->