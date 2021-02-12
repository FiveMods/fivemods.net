<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300);

require_once 'config.php';

include 'uuid.php';

if (isset($_SESSION['access_token']))
	$gClient->setAccessToken($_SESSION['access_token']);
else if (isset($_GET['code'])) {
	$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
	$_SESSION['access_token'] = $token;
	header('Location: /account/');
} else {
	header('Location: /sign-in/');
	exit();
}

$oAuth = new Google_Service_Oauth2($gClient);
$userData = $oAuth->userinfo_v2_me->get();


$uid = $userData['id'];


require_once('../../config.php');

$servername = $mysql['servername'];
$username = $mysql['username'];
$password = $mysql['password'];
$dbname = $mysql['dbname'];

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userDB = $pdo->prepare("SELECT * FROM user WHERE oauth_uid = $uid");
$userDB->execute();

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
	$givenname = $userData['givenName'];
	$name = $userData['name'];
	$email = $userData['email'];
	$picture = $userData['picture'];

	if(empty($name)) $uname = $givenname; else $uname = $name;
	$main_ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
	$v5uuid = UUID::v4();
  $sid = session_id();
	$permission = 1000;


	$downloadedFileContents = file_get_contents($picture);

  //Check to see if file_get_contents failed.
  if ($downloadedFileContents === false) {
      throw new Exception('Failed to download file at: ' . $picture);
  }

  //The path and filename that you want to save the file to.
  // Change to storage.fivemods.net later on!
  $fileName = '../../../storage-html/profiles/google/' . $uid . '.png';

  //Save the data using file_put_contents.
  $save = file_put_contents($fileName, $downloadedFileContents);

  //Check to see if it failed to save or not.
  if ($save === false) {
      throw new Exception('Failed to save file to: ', $fileName);
      header('location: /account/logout/?url=error');
  }
	$fileName = "https://storage.fivemods.net/profiles/google/".$uid.".png";


	//
  // Login Code
  //

  $sessionKey = randomChars();

  setcookie("f_key", $sessionKey, time() + 3600 * 24 * 30, "/");
  setcookie("f_val", time (), time() + 3600 * 24 * 30, "/");
  echo time();

  $sessionInsert = $pdo->prepare("INSERT INTO sessions (uuid, newid) VALUES (?, ?)");
  $sessionInsert->execute(array($v5uuid, $sessionKey));

	$insertDB = $pdo->prepare("INSERT INTO user (name, sid, uuid, oauth_uid, oauth_provider, email, picture, locale, description, main_ip) VALUES (:name, :sid, '$v5uuid', :id, 'Google LLC.', :email, :picture, :locale, :description, :mainip)");
  $insertDB->execute(array('name' => $uname,'sid' => $sid, 'email' => $email, 'picture' => $fileName, 'description' => "No Description Set.", 'mainip' => $main_ip, 'id' => $uid, 'locale' => "-"));

	$servernameP = $mysqlPayment['servername'];
  $usernameP = $mysqlPayment['username'];
  $passwordP = $mysqlPayment['password'];
  $dbnameP = $mysqlPayment['dbname'];

  $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);
  $insertUser = $pdoPayment->prepare("INSERT INTO payment_user (oauth_provider, oauth_id, uuid, username, email, country_code) VALUES (:provider, :id, :uuid, :username, :email, :country)");
  $insertUser->execute(array('provider' => "Google", 'id' => $uid, 'uuid' => $v5uuid, 'username' => $uname, 'email' => $email, 'country' => $userData['locale']));

	header("Location: /pages/account/helper/account.check.php");
}
function randomChars($length = 25)
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  return substr(str_shuffle($permitted_chars), 0, $length);
}
exit();
die();

$pdo = null;
$pdoPayment = null;
?>