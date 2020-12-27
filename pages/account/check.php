<?php
include('./include/header-banner.php');

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
$_SESSION['on2fa'] = FALSE;
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 card shadow-lg mt-5 mb-5 p-3">
            <hr>
            <div style="text-align: center;">
                <h1>Authentication successful</h1>
                <?php 
                
                if ($_SESSION['user_2fa'] == "0") {
                    echo '<p>To enable the two factor function in the future please click the button below.</p>';
                }
                ?>
                
            </div>
            <hr>
            <?php
            
            if ($_SESSION['user_2fa'] == "0") {
                echo '<form action="/pages/account/helper/2fa.enable.php" method="post">
                <input type="text" name="call" value="callFunc" hidden>
                <button type="submit" class="btn btn-block btn-success" style="text-align: center;">Continue & Enable</button>
            </form>';
            } else {
                echo '<meta http-equiv="refresh" content="2;url=/account/" />';
            }
            

            ?>
            
        </div>
    </div>
</div>