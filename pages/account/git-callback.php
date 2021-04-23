<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300);

require_once 'config.php';
require_once '../../helper/geo.class.php';


$geoplugin = new geoPlugin();

$geoplugin->locate();

include 'uuid.php';

// Pseudo-random UUID


require_once('../../config.php');

$servername = $mysql['servername'];
$username = $mysql['username'];
$password = $mysql['password'];
$dbname = $mysql['dbname'];

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('OAUTH2_CLIENT_ID', '48abb0467b4aa1c0fa9f');
define('OAUTH2_CLIENT_SECRET', $gitSecret);
define('APP_NAME', "FiveMods Account");

$authorizeURL = 'https://github.com/login/oauth/authorize';
$tokenURL = 'https://github.com/login/oauth/access_token';
$apiURLBase = 'https://api.github.com/';

session_start();

// When Github redirects the user back here, there will be a "code" and "state" parameter in the query string
if(isset($_GET['code'])) {
  // Verify the state matches our stored state
  if(!isset($_GET['state']) || $_SESSION['state'] != $_GET['state']) {
    header('Location: ' . $_SERVER['PHP_SELF']);
    die();
  }

  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => 'https://fivemods.net/pages/account/git-callback.php',
    'state' => $_SESSION['state'],
    'code' => $_GET['code'],
  ));
  $_SESSION['access_token'] = $token->access_token;
  header('Location: ' . $_SERVER['PHP_SELF']);
}

if($_SESSION['access_token']) {
    $user = apiRequest($apiURLBase . 'user');

    $userDB = $pdo->prepare("SELECT * FROM user WHERE oauth_uid = ?");
    $userDB->execute(array($user->id));

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
      echo "hier";

        $email = apiRequest($apiURLBase . 'user/emails');

        if(empty($user->bio)) $description = "No description set."; else $description = $user->bio;
        if(empty($user->twitter_username)) $twitter = NULL; else $twitter = $user->twitter_username;
        if(empty($geoplugin->countryCode)) $location = '-'; else $location = $geoplugin->countryCode;

        $v5uuid = UUID::v4();
        $sid = session_id();
        $permission = "1000";
        $main_ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
        $email = $email[0]->email;


        $downloadedFileContents = file_get_contents($user->avatar_url);

        //Check to see if file_get_contents failed.
        if ($downloadedFileContents === false) {
            throw new Exception('Failed to download file at: ' . $user->avatar_url);
        }

        //The path and filename that you want to save the file to.
        // Change to storage.fivemods.net later on!
        $fileName = '../../../storage-html/profiles/github/' . $user->id . '.png';


        //Save the data using file_put_contents.
        $save = file_put_contents($fileName, $downloadedFileContents);

        //Check to see if it failed to save or not.
        if ($save === false) {
            throw new Exception('Failed to save file to: ', $fileName);
            header('location: /account/logout/?url=error');
        }

        $fileName = "https://storage.fivemods.net/profiles/github/".$user->id.".png";


        //
        // Login Code
        //

        $sessionKey = randomChars();

        setcookie("f_key", $sessionKey, time() + 3600 * 24 * 30, "/");
        setcookie("f_val", time (), time() + 3600 * 24 * 30, "/");
        echo time();

        $sessionInsert = $pdo->prepare("INSERT INTO sessions (uuid, newid) VALUES (?, ?)");
        $sessionInsert->execute(array($v5uuid, $sessionKey));

        $insertDB = $pdo->prepare("INSERT INTO user (name, sid, uuid, oauth_uid, oauth_provider, email, picture, locale, description, twitter, github, main_ip) VALUES (:name, :sid, '$v5uuid', :id, 'GitHub', :email, :picture, :locale, :description, :twitter, :github, :mainip)");
        $insertDB->execute(array('name' => $user->login,'sid' => $sid, 'email' => $email, 'picture' => $fileName, 'description' => $description, 'twitter' => $twitter, 'github' => $user->login, 'mainip' => $main_ip, 'id' => $user->id, 'locale' => $location));

        $servernameP = $mysqlPayment['servername'];
        $usernameP = $mysqlPayment['username'];
        $passwordP = $mysqlPayment['password'];
        $dbnameP = $mysqlPayment['dbname'];

        $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);
        $insertUser = $pdoPayment->prepare("INSERT INTO payment_user (oauth_provider, oauth_id, uuid, username, email, country_code) VALUES (:provider, :id, :uuid, :username, :email, :country)");
        $insertUser->execute(array('provider' => "GitHub", 'id' => $user->id, 'uuid' => $v5uuid, 'username' => $user->login, 'email' => $email, 'country' => $location));

        
        $_SESSION['username'] = $user->login;

        header("Location: /pages/account/helper/account.check.php");
    }
}
exit();
die();


function apiRequest($url, $post=FALSE, $headers=array()) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $headers[] = 'Accept: application/json';
  if(isset($_SESSION['access_token']))
    $headers[] = 'Authorization: Bearer ' . $_SESSION['access_token'];
    $headers[] = 'User-Agent:' . APP_NAME;
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
