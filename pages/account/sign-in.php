<?php

include('./include/header-banner.php');

require_once('./pages/account/config.php');

$loginURL = $gClient->createAuthUrl();

$directPage = $_GET['rdc'];
if (!empty($directPage)) {
    header('location: /'.$directPage);
}

if ($_GET['rdC'] == "main") {
    echo '<meta http-equiv="refresh" content="2;url=/" />';
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
                        <?php echo $_SESSION['logoutsuccess']; unset($_SESSION['logoutsuccess']); ?>
                        <form action="?login=1" method="post" class="mt-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <?php

                                    error_reporting(E_ALL);

                                    if ($ip_server == "85.214.73.93") {
                                        $redirect = 'https://pre-live.fivemods.net/pages/account/d-callback.php';
                                    } else {
                                        $redirect = 'http://localhost/pages/account/d-callback.php';
                                    }

                                    define('OAUTH2_CLIENT_ID', '752568669061513327');
                                    define('OAUTH2_CLIENT_SECRET', 'ggATQBY184X-O9YUZDWtgtmHMcldlFgZ');

                                    $authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
                                    $tokenURL = 'https://discordapp.com/api/oauth2/token';
                                    $apiURLBase = 'https://discordapp.com/api/users/@me';

                                    // Start the login process by sending the user to Discord's authorization page
                                    if (get('action') == 'login') {

                                        $params = array(
                                            'client_id' => OAUTH2_CLIENT_ID,
                                            'redirect_uri' => 'http://localhost/pages/account/d-callback.php',
                                            'response_type' => 'code',
                                            'scope' => 'identify email guilds'
                                        );

                                        // Redirect the user to Discord's authorization page
                                        
                                        header('Location: https://discord.com/api/oauth2/authorize?client_id=752568669061513327&redirect_uri=http%3A%2F%2Flocalhost%2Fpages%2Faccount%2Fd-callback.php&response_type=code&scope=identify%20email');

                                        die();
                                    }


                                    // When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
                                    if (get('code')) {

                                        // Exchange the auth code for a token
                                        $token = apiRequest($tokenURL, array(
                                            "grant_type" => "authorization_code",
                                            'client_id' => OAUTH2_CLIENT_ID,
                                            'client_secret' => OAUTH2_CLIENT_SECRET,
                                            'redirect_uri' => 'http://localhost/pages/account/d-callback.php',
                                            'code' => get('code')
                                        ));
                                        $logout_token = $token->access_token;
                                        $_SESSION['dc_access_token'] = $token->access_token;


                                        header('Location: ' . $_SERVER['PHP_SELF']);
                                    }

                                    if (session('dc_access_token')) {
                                        $user = apiRequest($apiURLBase);

                                        header('location: /account/');
                                    } else {
                                        echo '<a href="?action=login" class="btn btn-block btn-discord">
                                     <i class="fab fa-discord"></i> &nbsp; ' . $lang['login-discord'] . '
                                   </a>';
                                    }


                                    if (get('action') == 'logout') {
                                        // This must to logout you, but it didn't worked(

                                        $params = array(
                                            'dc_access_token' => $logout_token
                                        );

                                        // Redirect the user to Discord's revoke page
                                        header('Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
                                        die();
                                    }

                                    function apiRequest($url, $post = FALSE, $headers = array())
                                    {
                                        $ch = curl_init($url);
                                        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                                        $response = curl_exec($ch);


                                        if ($post)
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

                                        $headers[] = 'Accept: application/json';

                                        if (session('dc_access_token'))
                                            $headers[] = 'Authorization: Bearer ' . session('dc_access_token');

                                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                        $response = curl_exec($ch);
                                        return json_decode($response);
                                    }

                                    function get($key, $default = NULL)
                                    {
                                        return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
                                    }

                                    function session($key, $default = NULL)
                                    {
                                        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
                                    }

                                    ?>
                                    <a href="<?php echo $loginURL ?>" class="btn btn-block btn-danger">
                                        <i class="fab fa-google"></i> &nbsp; <?php echo $lang['login-google']; ?>
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