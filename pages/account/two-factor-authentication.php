<?php

include('./include/header-banner.php');

if(!isset($_COOKIE['f_val']) || !isset($_COOKIE['f_key'])) {
	header("location: /account/logout/");
	exit();
	die();
}

session_start();
require "Authenticator.php";

require_once('config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');


$result = $pdo->prepare("SELECT * FROM user WHERE uuid = ?");
$result->execute(array($_SESSION['uuid']));

if ($result->rowCount() > 0) {
   while ($row = $result->fetch()) {
      $t2ken = $row['2fa_acc'];
      $mail = $row['email'];
      $fa2 = $row['2fa'];
   }
}

if (empty($t2ken) || $t2ken == NULL) {

   $Authenticator = new Authenticator();
   if (!isset($_SESSION['auth_secret'])) {
      $secret = $Authenticator->generateRandomSecret();
   }

   echo '<script>console.log("Token:' . $secret . '")</script>';

   $stmt = $pdo->prepare("UPDATE user SET 2fa_acc = :secret WHERE uuid = :uuid");
   $stmt->execute(array("secret" => $secret, "uuid" => $_SESSION['uuid']));

} else {
    echo '<script>console.log("Early exit");</script>';
        $Authenticator = new Authenticator();
        if (!isset($_SESSION['auth_secret'])) {
           $secret = $Authenticator->generateRandomSecret();
           $secret = $t2ken;
           $_SESSION['auth_secret'] = $secret;
        }
}

$qrCodeUrl = $Authenticator->getQR($mail, $_SESSION['auth_secret'], "FiveMods.net");

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

                        <?php 
                        
                        if ($fa2 == "0") {
                           echo '<img style="text-align: center;" class="img-fluid" src="'.$qrCodeUrl.'" alt="Verify this Google Authenticator"><br><br>';
                           echo '<small class="text-muted">Please scan this QR-Code with your favourite authentication app.</small>';
                        } else {
                           echo '<h4>Please enter your two factor authentication code.<h4>';
                        }

                        ?>
                        
                        
                        <input type="text" class="form-control mt-2" name="code" minlength="6" maxlength="6" placeholder="******" autofocus style="font-size: xx-large;width:200px;border-radius: 0px;text-align: center;display: inline;color: #17141F;letter-spacing: 7px;"><br> <br>
                        <button type="submit" class="btn btn-md btn-primary" >Verify Token</button>

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
<?php
   $pdo = null;
?>