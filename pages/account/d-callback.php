<?php

// If login request got cancled
if ($_GET['error'] == "access_denied") {
    header('location: /account/logout/');
}
include 'uuid.php';
require_once('../../config.php');

$servername = $mysql['servername'];
$username = $mysql['username'];
$password = $mysql['password'];
$dbname = $mysql['dbname'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', $dcoauthid);
define('OAUTH2_CLIENT_SECRET', $dcoauthsecret);

$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';

session_start();


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if ($_GET['code']) {

    // Exchange the auth code for a token
    $token = apiRequest($tokenURL, array(
        "grant_type" => "authorization_code",
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
        'redirect_uri' => 'https://fivemods.net/pages/account/d-callback.php',
        'code' => get('code')
    ));
    $logout_token = $token->access_token;
    $_SESSION['dc_access_token'] = $token->access_token;


    header('Location: ' . $_SERVER['PHP_SELF']);
}

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SESSION['dc_access_token']) {
    $user = apiRequest($apiURLBase);

    $uid = $user->id;

    $userDB = $pdo->prepare("SELECT * FROM user WHERE oauth_uid = $uid");
    $userDB->execute();

    if($userDB->rowCount() > 0) {
    	$userFetch = $userDB->fetch();

    	$_SESSION['user_id'] = $userFetch['oauth_uid'];
    	$_SESSION['user_username'] = $userFetch['name'];
    	$_SESSION['user_firstname'] = $userFetch['first_name'];
    	$_SESSION['user_lastname'] = $userFetch['last_name'];
    	$_SESSION['user_email'] = $userFetch['email'];
    	$_SESSION['user_description'] = $userFetch['description'];
    	$_SESSION['user_locale'] = $userFetch['locale'];
    	$_SESSION['user_oauth_provider'] = $userFetch['oauth_provider'];
    	$_SESSION['user_premium'] = $userFetch['premium'];
    	$_SESSION['user_website'] = $userFetch['website'];
    	$_SESSION['user_uuid'] = $userFetch['uuid'];
    	$_SESSION['user_sid'] = $userFetch['sid'];
    	$_SESSION['user_iid'] = $userFetch['id'];
    	$_SESSION['user_main_ip'] = $userFetch['main_ip'];
    	$_SESSION['created_at'] = $userFetch['created-at'];
    	$_SESSION['updated_at'] = $userFetch['updated-at'];
    	$_SESSION['user_2fa'] = $userFetch['2fa'];
    	$_SESSION['user_discord'] = $userFetch['discord'];
    	$_SESSION['user_twitter'] = $userFetch['twitter'];
    	$_SESSION['user_youtube'] = $userFetch['youtube'];
    	$_SESSION['user_instagram'] = $userFetch['instagram'];
    	$_SESSION['user_github'] = $userFetch['github'];
    	$_SESSION['user_banner'] = $userFetch['banner'];
    	$_SESSION['user_blocked'] = $userFetch['blocked'];
    	$_SESSION['user_blocked_by'] = $userFetch['blocked_by'];
    	$_SESSION['user_blocked_reason'] = $userFetch['blocked_reason'];
    	$_SESSION['user_permission'] = $userFetch['permission'];

    	header("Location: /account/");
    } else {
      $main_ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    	$v5uuid = UUID::v4();
      $sid = session_id();
    	$permission = 1000;
      $picture = 'https://cdn.discordapp.com/avatars/' . $user->id . "/" . $user->avatar . '.png?size=128';

      $downloadedFileContents = file_get_contents($picture);

      //Check to see if file_get_contents failed.
      if ($downloadedFileContents === false) {
          throw new Exception('Failed to download file at: ' . $picture);
      }

      //The path and filename that you want to save the file to.
      // Change to storage.fivemods.net later on!
      $fileName = '../../../storage-html/profiles/discord/' . $uid . '.png';

      //Save the data using file_put_contents.
      $save = file_put_contents($fileName, $downloadedFileContents);

      //Check to see if it failed to save or not.
      if ($save === false) {
          throw new Exception('Failed to save file to: ', $fileName);
          header('location: /account/logout/?url=error');
      }
    	$fileName = "https://storage.fivemods.net/profiles/discord/".$uid.".png";

      $email = $user->email;

      $_SESSION['user_username'] = $user->username;
      $_SESSION['user_firstname'] = $user->username;
      $_SESSION['user_lastname'] = NULL;
      $_SESSION['user_email'] = $email;
      $_SESSION['user_description'] = "No Description Set.";
      $_SESSION['user_locale'] = "-";
      $_SESSION['user_oauth_provider'] = "Discord Inc.";
      $_SESSION['user_premium'] = "0";
      $_SESSION['user_website'] = NULL;
      $_SESSION['user_uuid'] = $v5uuid;
      $_SESSION['user_sid'] = $sid;
      $_SESSION['user_id'] = $uid;
      $_SESSION['user_main_ip'] = $main_ip;
      $_SESSION['user_2fa'] = "0";
      $_SESSION['user_discord'] = NULL;
      $_SESSION['user_twitter'] = NULL;
      $_SESSION['user_youtube'] = NULL;
      $_SESSION['user_instagram'] = NULL;
      $_SESSION['user_github'] = NULL;
      $_SESSION['user_banner'] = "https://fivemods.net/static-assets/img/banner.png";
      $_SESSION['user_blocked'] = "0";
      $_SESSION['user_blocked_by'] = NULL;
      $_SESSION['user_blocked_reason'] = NULL;
      $_SESSION['user_permission'] = $permission;
      $_SESSION['user_image'] = $fileName;

    	$insertDB = $pdo->prepare("INSERT INTO user (sid, uuid, oauth_uid, oauth_provider, email, picture, locale, description, main_ip) VALUES (:sid, '$v5uuid', :id, 'Discord Inc.', :email, :picture, :locale, :description, :mainip)");
      $insertDB->execute(array('sid' => $sid, 'email' => $email, 'picture' => $fileName, 'description' => "No Description Set.", 'mainip' => $main_ip, 'id' => $uid, 'locale' => "-"));

    	$servernameP = $mysqlPayment['servername'];
      $usernameP = $mysqlPayment['username'];
      $passwordP = $mysqlPayment['password'];
      $dbnameP = $mysqlPayment['dbname'];

      $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);
      $insertUser = $pdoPayment->prepare("INSERT INTO payment_user (oauth_provider, oauth_id, uuid, username, email, country_code) VALUES (:provider, :id, :uuid, :username, :email, :country)");
      $insertUser->execute(array('provider' => "Discord", 'id' => $uid, 'uuid' => $v5uuid, 'username' => $_SESSION['user_username'], 'email' => $email, 'country' => $user->locale));

    	$select = $pdo->prepare("SELECT * FROM user WHERE uuid = :uuid");
      $select->execute(array('uuid' => $v5uuid));

      $selectFetch = $select->fetch();

      $_SESSION['user_iid'] = $selectFetch['id'];
      $_SESSION['created_at'] = $selectFetch['created-at'];
      $_SESSION['updated_at'] = $selectFetch['updated-at'];

    	header("Location: /pages/account/helper/account.check.php");


    }
}

exit();
die();

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
