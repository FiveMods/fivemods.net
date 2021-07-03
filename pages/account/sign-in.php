<div class="leftBasedAds" style="left: 0px; position: fixed; text-align: center; top: 20%;margin-left:3%;">


    <!-- Vertical Test -->
    <ins class="adsbygoogle leftBasedAds" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="2716933531" data-ad-format="auto" data-full-width-responsive="true"></ins> <!-- data-ad-format="auto" data-full-width-responsive="true" -->
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<div class="rightBasedAds" style="right: 0px; position: fixed; text-align: center; top: 20%;margin-right:3%;">

    <!-- Vertical Test -->
    <ins class="adsbygoogle rightBasedAds" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="2716933531" data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<?php

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

if(isset($_COOKIE['f_val']) && isset($_COOKIE['f_key'])) {
    $_SESSION['logoutsuccess'] = "<p style=\"color: red\">You are already logged in!</p>";
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

    .separator {
        display: flex;
        align-items: center;
        text-align: center;
    }

    .separator::before,
    .separator::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid lightgray;
    }

    .separator:not(:empty)::before {
        margin-right: .25em;
    }

    .separator:not(:empty)::after {
        margin-left: .25em;
    }
</style>
<section class="pt-5 pb-5">
    <div class="container centered">
        <div class="row justify-content-center header-h100 align-items-center">
            <div class="col-12 col-md-5 text-center">
                <div class="card shadow1 rounded emp-login">
                    <article class="card-body">
                        <a href="/">
                            <h4 class="card-title text-center mb-4 mt-1"> <img src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95)/https://fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" loading="lazy" height="50" alt="fivemods_brand_icon_watermark_primary"> </h4>
                        </a>
                        <div class="separator text-dark"> <?php echo $lang['log-in']; ?> </div>
                        <?php echo $_SESSION['logoutsuccess'];
                        unset($_SESSION['logoutsuccess']); ?>
                        <form action="?login=1" method="post" class="mt-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <?php if (isset($_COOKIE['f_val']) && isset($_COOKIE['f_key'])) : ?>
                                        <a href="#" class="btn btn-block btn-discord disabled">
                                            <i class="fab fa-discord"></i> &nbsp; <?php echo $lang['login-discord']; ?>
                                        </a>
                                        <a href="#" class="btn btn-block btn-danger disabled">
                                            <i class="fab fa-google"></i> &nbsp; <?php echo $lang['login-google']; ?>
                                        </a>
                                        <a href="#" class="btn btn-block btn-secondary disabled">
                                            <i class="fab fa-github"></i> &nbsp;Login with GitHub
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo $dcCallback; ?>" class="btn btn-block btn-discord">
                                            <i class="fab fa-discord"></i> &nbsp; <?php echo $lang['login-discord']; ?>
                                        </a>
                                        <a href="<?php echo $loginURL ?>" class="btn btn-block btn-danger">
                                            <i class="fab fa-google"></i> &nbsp; <?php echo $lang['login-google']; ?>
                                        </a>
                                        <a href="https://github.com/login/oauth/authorize?<?php echo http_build_query($params); ?>" class="btn btn-block btn-secondary">
                                            <i class="fab fa-github"></i> &nbsp; <?php echo $lang['login-github']; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <p class="text-center mt-4 text-muted">
                                <small style="color:gray;">By creating an account, you accept our <a href="/privacy-policy/">Privacy Policy</a> & <a href="/terms-of-service/">Terms Of Use</a>.</small> <br>
                                <small class="text-success text-center "><?php echo $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']); ?></small>
                            </p>
                        </form>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>
