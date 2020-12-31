<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('max_execution_time', 300);

include('./include/header-banner.php');

require_once('./pages/account/config.php');

$loginURL = $gClient->createAuthUrl();


if ($_GET['rdC'] == "main") {
    echo '<meta http-equiv="refresh" content="2;url=/" />';
}

$_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);

$params = array(
  'client_id' => '48abb0467b4aa1c0fa9f',
  'redirect_uri' => 'https://fivemods.net/pages/account/git-callback.php',
  'scope' => 'user:email',
  'response_type' => 'code',
  'state' => $_SESSION['state'],
);

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
                        <?php echo $_SESSION['logoutsuccess']; unset($_SESSION['logoutsuccess']); ?>
                        <form action="?login=1" method="post" class="mt-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <a href="<?php echo $dcCallback;?>" class="btn btn-block btn-discord">
                                     <i class="fab fa-discord"></i> &nbsp; <?php echo $lang['login-discord']; ?>
                                   </a>
                                    <a href="<?php echo $loginURL ?>" class="btn btn-block btn-danger">
                                        <i class="fab fa-google"></i> &nbsp; <?php echo $lang['login-google']; ?>
                                    </a>
                                    <a href="https://github.com/login/oauth/authorize?<?php echo http_build_query($params);?>" class="btn btn-block btn-secondary">
                                        <i class="fab fa-github"></i> &nbsp;Login with GitHub
                                    </a>
                                </div>
                            </div>
                            <p class="text-center mt-4 text-muted">
                                <small>By creating an account, you accept our <a href="/privacy-policy/">Privacy Policy</a> & <a href="/terms-of-service/">Terms Of Use</a>.</small> <br>
                                <small class="text-success text-center "><?php echo $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']); ?> (<?php echo $city; ?>)</small>
                            </p>
                        </form>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>