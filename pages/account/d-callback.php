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
ini_set('max_execution_time', 300); 

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', $dcoauthid);
define('OAUTH2_CLIENT_SECRET', $dcoauthsecret);

$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';

session_start();


if (isset($_GET['code'])) {

    $token = apiRequest($tokenURL, array(
        "grant_type" => "authorization_code",
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
        'redirect_uri' => $dcRedirect,
        'code' => $_GET['code']
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

    $userDB = $pdo->prepare("SELECT * FROM user WHERE oauth_uid = ?");
    $userDB->execute(array($uid));

    if($userDB->rowCount() > 0) {
    	$userFetch = $userDB->fetch();

      //
      // Login Code
      //

      $sessionKey = randomChars();

      setcookie("f_key", $sessionKey, time() + 3600 * 24 * 30, "/");
      setcookie("f_val", time (), time() + 3600 * 24 * 30, "/");
      echo time();

      $sessionInsert = $pdo->prepare("INSERT INTO sessions (uuid, newid) VALUES (?, ?)");
      $sessionInsert->execute(array($userFetch['uuid'], $sessionKey));

    	header("Location: /account/");
    } else {
      $main_ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    	$v5uuid = UUID::v4();
      $sid = session_id();
    	$permission = 1000;
      $picture = 'https://cdn.discordapp.com/avatars/' . $user->id . "/" . $user->avatar . '.png?size=128';

      $downloadedFileContents = file_get_contents($picture);

      if ($downloadedFileContents === false) {
          throw new Exception('Failed to download file at: ' . $picture);
      }

      $fileName = '../../../storage-html/profiles/discord/' . $uid . '.png';
      $save = file_put_contents($fileName, $downloadedFileContents);

      if ($save === false) {
          throw new Exception('Failed to save file to: ', $fileName);
          header('location: /account/logout/?url=error');
      }
    	$fileName = "https://storage.fivemods.net/profiles/discord/".$uid.".png";

      $email = $user->email;

    	$insertDB = $pdo->prepare("INSERT INTO user (sid, uuid, oauth_uid, oauth_provider, email, picture, locale, description, main_ip) VALUES (:sid, '$v5uuid', :id, 'Discord Inc.', :email, :picture, :locale, :description, :mainip)");
      $insertDB->execute(array('sid' => $sid, 'email' => $email, 'picture' => $fileName, 'description' => "No Description Set.", 'mainip' => $main_ip, 'id' => $uid, 'locale' => "-"));

    	$servernameP = $mysqlPayment['servername'];
      $usernameP = $mysqlPayment['username'];
      $passwordP = $mysqlPayment['password'];
      $dbnameP = $mysqlPayment['dbname'];

      $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);
      $insertUser = $pdoPayment->prepare("INSERT INTO payment_user (oauth_provider, oauth_id, uuid, username, email, country_code) VALUES (:provider, :id, :uuid, :username, :email, :country)");
      $insertUser->execute(array('provider' => "Discord", 'id' => $uid, 'uuid' => $v5uuid, 'username' => $_SESSION['user_username'], 'email' => $email, 'country' => $user->locale));

      //
      // Login Code
      //
      $sessionKey = randomChars();

      setcookie("f_key", $sessionKey, time() + 3600 * 24 * 30, "/");
      setcookie("f_val", time (), time() + 3600 * 24 * 30, "/");
      echo time();

      $sessionInsert = $pdo->prepare("INSERT INTO sessions (uuid, newid) VALUES (?, ?)");
      $sessionInsert->execute(array($v5uuid, $sessionKey));

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


  if ($post) curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if (isset($_SESSION['dc_access_token'])) $headers[] = 'Authorization: Bearer ' . $_SESSION['dc_access_token'];

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}
function randomChars($length = 25)
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  return substr(str_shuffle($permitted_chars), 0, $length);
}
$pdo = null;
$pdoPayment = null;
?>
