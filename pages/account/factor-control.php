<?php

include('./include/header-banner.php');

if (empty($_SESSION['user_id'])) {
    header('location: /logout');
}

session_start();
require "Authenticator.php";

if ($_SESSION['user_2fa'] == "1") {
    header('location: /account/');
}

$sql = "SELECT 2fa_acc FROM user WHERE oauth_uid LIKE $_SESSION[user_id]";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $t2ken = $row['2fa_acc'];
    }
}

if (!isset($_SESSION['failed'])) {
    $_SESSION['failed'] = false;
 }
 
?>
<style>
    .btn-discord {
        background-color: #2f3136;
        color: white;
    }

    .btn-discord:hover {
        background-color: #26272b;
        color: white;
    }

    .bg-221d2e {
        background-color: #221d2e;
    }
</style>
<section class="pt-5 pb-5 bg-221d2e border-bottom border-white">
    <div class="container centered">
        <div class="row justify-content-center header-h100 align-items-center">
            <div class="col-12 col-md-5 text-center">
                <div class="card shadow-lg p-3 mb-5 bg-dark rounded">
                    <article class="card-body">
                        <a href="/">
                            <h4 class="card-title text-center mb-4 mt-1"> <img src="https://fivemods.net/static-assets/img/brand-side.png" height="50" alt=""> </h4>
                        </a>
                        <hr>
                        <form action="/account/check/" method="post" class="mt-4">
                            <div class="form-group">
                                <?php if ($_SESSION['failed']) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Oh snap!</strong> Invalid Code.
                                    </div>
                                    <?php
                                    $_SESSION['failed'] = false;
                                    ?>
                                <?php endif ?>
                                <div style="text-align: center;">
                                    <input type="text" class="form-control" name="code" minlength="6" maxlength="6" placeholder="******" autofocus style="font-size: xx-large;width:200px;border-radius: 0px;text-align: center;display: inline;color: #17141F;letter-spacing: 7px;"><br> <br>
                                    <button type="submit" class="btn btn-md btn-primary" style="width: 200px;border-radius: 0px;">Verify</button>
                                </div>
                            </div>
                            <p class="text-center mt-4 text-muted">
                                <small>Issues with your two-factor? Create a new ticket in our <a href="/discord">discord</a>.</small> <br>
                                <small class="text-success text-center "><?php echo $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']); ?> (<?php echo $city; ?>)</small>
                            </p>
                        </form>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>