<?php
session_start();

require "Authenticator.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("location: /account/logout/?url=error");
    die();
}
$Authenticator = new Authenticator();

$checkResult = $Authenticator->verifyCode($_SESSION['auth_secret'], $_POST['code'], 2);    // 2 = 2*30sec clock tolerance

if (!$checkResult) {
    $_SESSION['failed'] = true;
    header("location: /account/logout/?url=error");
    die();
}

$_SESSION['control_2FA'] = "1";

?>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3" style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 100px;">
            <hr>
            <div style="text-align: center;">
                <h1>Authentication Successful</h1>
                <p>Thanks for using our sample Time-based Authenticator</p>
            </div>
            <hr>
            <a href="/account/">
                <p style="text-align: center;">Continue</p>
            </a>
        </div>
    </div>
</div>