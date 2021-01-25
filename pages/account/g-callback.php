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


	$_SESSION['user_username'] = $uname;
  $_SESSION['user_firstname'] = $givenname;
  $_SESSION['user_lastname'] = NULL;
  $_SESSION['user_email'] = $email;
  $_SESSION['user_description'] = "No Description Set.";
  $_SESSION['user_locale'] = "-";
  $_SESSION['user_oauth_provider'] = "Google LLC.";
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

	$insertDB = $pdo->prepare("INSERT INTO user (sid, uuid, oauth_uid, oauth_provider, email, picture, locale, description, main_ip) VALUES (:sid, '$v5uuid', :id, 'Google LLC.', :email, :picture, :locale, :description, :mainip)");
  $insertDB->execute(array('sid' => $sid, 'email' => $email, 'picture' => $fileName, 'description' => "No Description Set.", 'mainip' => $main_ip, 'id' => $uid, 'locale' => "-"));

	$servernameP = $mysqlPayment['servername'];
  $usernameP = $mysqlPayment['username'];
  $passwordP = $mysqlPayment['password'];
  $dbnameP = $mysqlPayment['dbname'];

  $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);
  $insertUser = $pdoPayment->prepare("INSERT INTO payment_user (oauth_provider, oauth_id, uuid, username, email, country_code) VALUES (:provider, :id, :uuid, :username, :email, :country)");
  $insertUser->execute(array('provider' => "Google", 'id' => $uid, 'uuid' => $v5uuid, 'username' => $uname, 'email' => $email, 'country' => $userData['locale']));

	$select = $pdo->prepare("SELECT * FROM user WHERE uuid = :uuid");
  $select->execute(array('uuid' => $v5uuid));

  $selectFetch = $select->fetch();

  $_SESSION['user_iid'] = $selectFetch['id'];
  $_SESSION['created_at'] = $selectFetch['created-at'];
  $_SESSION['updated_at'] = $selectFetch['updated-at'];

	header("Location: /pages/account/helper/account.check.php");
}
exit();
die();

$pdo = null;
$pdoPayment = null;
?>