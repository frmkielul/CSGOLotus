<html>
  <head>
    <title>CSGO Lotus - Paths</title>
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="css/paths_css.css" rel="stylesheet">
  </head>
  <body>
    <header>
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
    </header>
  </body>
</html>
