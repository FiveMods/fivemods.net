<?php
include('./include/header-banner.php');

// session_start();

// require "Authenticator.php";
// if ($_SERVER['REQUEST_METHOD'] != "POST") {
//     header("location: /account/logout/?url=error");
//     die();
// }
// $Authenticator = new Authenticator();

// $checkResult = $Authenticator->verifyCode($_SESSION['auth_secret'], $_POST['code'], 2);    // 2 = 2*30sec clock tolerance

// if (!$checkResult) {
//     $_SESSION['failed'] = true;
//     header("location: /account/logout/?url=error");
//     die();
// }

// $_SESSION['control_2FA'] = "1";

?>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 card shadow-lg mt-5 mb-5 p-3">
            <hr>
            <div style="text-align: center;">
                <h1>Authentication Successful</h1>
                <p>Thanks for using our Time-based Two Factor Authentication</p>
            </div>
            <hr>
            <form action="/pages/account/helper/2fa.enable.php" method="post">
                <input type="text" name="id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                <input type="text" name="call" value="callFunc" hidden>
                <button type="submit" class="btn btn-block btn-success" style="text-align: center;">Continue</button>
            </form>
        </div>
    </div>
</div>