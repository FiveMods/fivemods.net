<?php 

session_start();
require "./pages/account/Authenticator.php";


$Authenticator = new Authenticator();
if (!isset($_SESSION['auth_secret'])) {
   $secret = $Authenticator->generateRandomSecret();
   // $secret = "Y7P2VQ5YK6HUKBSW";
//    $_SESSION['auth_secret'] = $secret;
}

echo $secret;

?>