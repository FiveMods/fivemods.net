<?php

if (empty($_SESSION['user_id'])) {
   header('location: /logout');
}

session_start();
require "Authenticator.php";


$Authenticator = new Authenticator();
if (!isset($_SESSION['auth_secret'])) {
   $secret = $Authenticator->generateRandomSecret();
   $_SESSION['auth_secret'] = $secret;
}


$qrCodeUrl = $Authenticator->getQR('FiveMods', $_SESSION['auth_secret']);


if (!isset($_SESSION['failed'])) {
   $_SESSION['failed'] = false;
}

?>
<div class="container">
   <div class="row">
      <div class="col-md-6 offset-md-3 mb-5" style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 125px;">
         <h1>Two-Factor Authentication</h1>
         <hr>
         <form action="/pages/account/check.php" method="post">
            <div style="text-align: center;">
               <?php if ($_SESSION['failed']) : ?>
                  <div class="alert alert-danger" role="alert">
                     <strong>Oh snap!</strong> Invalid Code.
                  </div>
                  <?php
                  $_SESSION['failed'] = false;
                  ?>
               <?php endif ?>

               <img style="text-align: center;;" class="img-fluid" src="<?php echo $qrCodeUrl ?>" alt="Verify this Google Authenticator"><br><br>
               <input type="text" class="form-control" name="code" placeholder="******" style="font-size: xx-large;width:200px;border-radius: 0px;text-align: center;display: inline;color: #0275d8;"><br> <br>
               <button type="submit" class="btn btn-md btn-primary" style="width: 200px;border-radius: 0px;">Verify</button>

            </div>

         </form>
      </div>
   </div>
</div>