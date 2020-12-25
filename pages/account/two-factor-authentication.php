<?php

if (empty($_SESSION['user_id'])) {
   header('location: /logout');
}

session_start();
require "Authenticator.php";

$sql = "SELECT 2fa_acc FROM user WHERE oauth_uid LIKE $_SESSION[user_id]";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   // output data of each row
   while ($row = $result->fetch_assoc()) {
      $t2ken = $row['2fa_acc'];
   }
}

if (empty($t2ken) || $t2ken == NULL) {

   $Authenticator = new Authenticator();
   if (!isset($_SESSION['auth_secret'])) {
      $secret = $Authenticator->generateRandomSecret();
      // $secret = "Y7P2VQ5YK6HUKBSW";
      // $secret = $t2ken;
      // $_SESSION['auth_secret'] = $secret;
   }

   echo '<script>console.log("Token:' . $secret . '")</script>';

   $iiid = $_SESSION['user_id'];

   $sql = "UPDATE user SET 2fa_acc='$secret' WHERE oauth_uid='$iiid'";

   if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
      echo '<script>console.log("Updated");</script>';
   } else {
      echo '<script>console.log("Error: ' . $sql . "<br>" . $conn->error . '");</script>';
      echo '<script>console.log("SQL error");</script>';
   }
} else {
   echo '<script>console.log("Early exit");</script>';
   $Authenticator = new Authenticator();
   if (!isset($_SESSION['auth_secret'])) {
      $secret = $Authenticator->generateRandomSecret();
      $secret = $t2ken;
      $_SESSION['auth_secret'] = $secret;
   }
}


$qrCodeUrl = $Authenticator->getQR($_SESSION['user_email'], $_SESSION['auth_secret'], "FiveMods.net");


if (!isset($_SESSION['failed'])) {
   $_SESSION['failed'] = false;
}

?>
<div class="container">
   <div class="row">
      <div class="col-md-6 offset-md-3 mb-5" style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 125px;">
         <h1>Two-Factor Authentication</h1>
         <hr>
         <form action="/account/check/" method="post">
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