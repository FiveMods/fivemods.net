<?php

include('./include/header-banner.php');

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
<section class="pt-5 pb-5">
   <div class="container">
      <div class="row align-items-center justify-content-around">
         <div class="col-12 col-md-5 mt-4 mt-md-0">
            <div class="card shadow-lg p-3 mb-5 rounded">
               <article class="card-body">
                  <?php echo $_SESSION['logoutsuccess'];
                  unset($_SESSION['logoutsuccess']); ?>
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
                        <input type="text" class="form-control" name="code" minlength="6" maxlength="6" placeholder="******" style="font-size: xx-large;width:200px;border-radius: 0px;text-align: center;display: inline;color: #17141F;letter-spacing: 2px;"><br> <br>
                        <button type="submit" class="btn btn-md btn-primary" style="width: 200px;border-radius: 0px;">Verify</button>

                     </div>

                  </form>
               </article>
            </div>
         </div>
         <div class="col-12 col-md-6">
            <!-- <h2>Nice Heading</h2>
            <p class="text-h3 mt-4 pb-4">A collection of coded HTML and CSS elements to help your build your new website. Clean design, fully responsive and based on Bootstrap 4.</p> -->
            <div class="media">
               <img class="mr-3 img-fluid rounded" src="https://cdn.worldvectorlogo.com/logos/microsoft-authenticator.svg" width="64px" height="64px" alt="Microsoft Authenticator - IMG">
               <div class="media-body">
                  <h5 class="mt-0">Microsoft Authenticator</h5>
                  FiveMods supports the Microsoft Authenticator app.
               </div>
            </div>
            <div class="media mt-4">
               <img class="mr-3 img-fluid rounded" src="https://upload.wikimedia.org/wikipedia/commons/c/cd/FreeOTP.png" width="64px" height="64px" alt="Free OTP - IMG">
               <div class="media-body">
                  <h5 class="mt-0">Free OTP</h5>
                  FiveMods supports the Free OTP app.
               </div>
            </div>
            <div class="media mt-4">
               <img class="mr-3 img-fluid rounded" src="https://pbs.twimg.com/profile_images/1254447460879077377/qDtWdPeZ_400x400.png" width="64px" height="64px" alt="Authy - IMG">
               <div class="media-body">
                  <h5 class="mt-0">Authy</h5>
                  FiveMods supports the Authy app.
               </div>
            </div>
            <div class="media mt-4">
               <img class="mr-3 img-fluid rounded" src="https://cdn.worldvectorlogo.com/logos/google-authenticator-2.svg" width="64px" height="64px" alt="Google Authenticator - IMG">
               <div class="media-body">
                  <h5 class="mt-0">Google Authenticator</h5>
                  FiveMods supports the Google Authenticator app.
               </div>
            </div>
         </div>
      </div>
   </div>
</section>