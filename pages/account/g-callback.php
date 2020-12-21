<?php
require_once 'config.php';

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

$_SESSION['g_id'] = $userData['id'];
$_SESSION['g_email'] = $userData['email'];
$_SESSION['g_gender'] = $userData['gender'];
$_SESSION['g_picture'] = $userData['picture'];
$_SESSION['g_familyName'] = $userData['familyName'];
$_SESSION['g_givenName'] = $userData['givenName'];

$_SESSION['user_id'] = $_SESSION['g_id'];
$_SESSION['user_email'] = $_SESSION['g_email'];
$_SESSION['user_image'] = $_SESSION['g_picture'];

require_once('../../config.php');

$servername = $mysql['servername'];
$username = $mysql['username'];
$password = $mysql['password'];
$dbname = $mysql['dbname'];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

try {

    require_once('../../config.php');

    $servername = $mysql['servername'];
    $username = $mysql['username'];
    $password = $mysql['password'];
    $dbname = $mysql['dbname'];

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO user (sid, uuid, oauth_uid, oauth_provider, first_name, last_name, email, password, picture, gender, locale, description, permission, main_ip)
    VALUES (:sid, :uuid, :oauth_uid, :oauth_provider, :first_name, :last_name, :email, :password, :picture, :gender, :locale, :description, :permission, :main_ip)");
    $stmt->bindParam(':sid', $sid);
    $stmt->bindParam(':uuid', $uuid);
    $stmt->bindParam(':oauth_uid', $oauth_uid);
    $stmt->bindParam(':oauth_provider', $oauth_provider);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':picture', $picture);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':locale', $locale);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':permission', $permission);
    $stmt->bindParam(':main_ip', $main_ip);

    $url = $_SESSION['user_image'];
    echo '<img src="'.$_SESSION['user_image'].'">';

    //Download the file using file_get_contents.
    $downloadedFileContents = file_get_contents($url);

    //Check to see if file_get_contents failed.
    if ($downloadedFileContents === false) {
        throw new Exception('Failed to download file at: ' . $url);
    }

    //The path and filename that you want to save the file to.
    // Change to storage.fivemods.net later on!
    $fileName = '../../localstorage/google/' . $_SESSION['user_id'] . '.png';
    echo $fileName;

    //Save the data using file_put_contents.
    $save = file_put_contents($fileName, $downloadedFileContents);

    //Check to see if it failed to save or not.
    if ($save === false) {
        throw new Exception('Failed to save file to: ', $fileName);
        header('location: /account/logout/?url=error');
    }

    // Usage
    include 'uuid.php';

    // Pseudo-random UUID
    $v5uuid = UUID::v4();


	if (empty($_SESSION['g_gender']) == TRUE) {
		$gender = "-";
	} else {
		$gender = $_SESSION['g_gender'];
	}

    // insert a row
    $sid = session_id();
    $uuid = $v5uuid;
    $oauth_uid = $_SESSION['user_id'];
    $oauth_provider = "Google LLC.";
    // $name = $_SESSION['user_username'];
    $first_name = $_SESSION['g_givenName'];
    $last_name = $_SESSION['g_familyName'];
    $email = $_SESSION['user_email'];
    $password = '************';
    $picture = $fileName;
    $locale = "-";
    $description = "No description set.";
    $permission = "1000";
    $main_ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $stmt->execute();

    echo "New records created successfully";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    if (strpos("1062 Duplicate entry", $e->getMessage()) !== TRUE) {

  		$sid = session_id();

        require_once('../../config.php');

        $servername = $mysql['servername'];
        $username = $mysql['username'];
        $password = $mysql['password'];
        $dbname = $mysql['dbname'];

  		// Create connection
  		$conn = new mysqli($servername, $username, $password, $dbname);
  		// Check connection
  		if ($conn->connect_error) {
  			die("Connection failed: " . $conn->connect_error);
  		}

  		$url = $_SESSION['user_image'];
  		echo '<img src="' . $_SESSION['user_image'] . '">';

  		//Download the file using file_get_contents.
  		$downloadedFileContents = file_get_contents($url);

  		//Check to see if file_get_contents failed.
  		if ($downloadedFileContents === false) {
  			throw new Exception('Failed to download file at: ' . $url);
  		}

  		//The path and filename that you want to save the file to.
  		// Change to storage.fivemods.net later on!
  		$fileName = '../../localstorage/google/' . $_SESSION['user_id'] . '.png';
  		echo $fileName;

  		//Save the data using file_put_contents.
  		$save = file_put_contents($fileName, $downloadedFileContents);

  		//Check to see if it failed to save or not.
  		if ($save === false) {
  			throw new Exception('Failed to save file to: ', $fileName);
  		}

  		$sql = "UPDATE user SET sid='$sid', first_name='$first_name', last_name='$last_name', email='$email', picture='$fileName' WHERE uuid = '$_SESSION[user_uuid]'";

  		if ($conn->query($sql) === TRUE) {
  			echo "Record updated successfully";
  		} else {
  			echo "Error updating record: " . $conn->error;
  		}
  	}
}

$sql = "SELECT * FROM user WHERE oauth_uid = '$_SESSION[user_id]'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($r = $result->fetch_assoc()) {

        $_SESSION['user_username'] = $r['name'];
        $_SESSION['user_firstname'] = $r['first_name'];
        $_SESSION['user_lastname'] = $r['last_name'];
        $_SESSION['user_description'] = $r['description'];
        $_SESSION['user_locale'] = $r['locale'];
        $_SESSION['user_oauth_provider'] = $r['oauth_provider'];
        $_SESSION['user_premium'] = $r['premium'];
        $_SESSION['user_website'] = $r['website'];
        $_SESSION['user_uuid'] = $r['uuid'];
        $_SESSION['user_sid'] = $r['sid'];
        $_SESSION['user_iid'] = $r['id'];
        $_SESSION['user_main_ip'] = $r['main_ip'];
        $_SESSION['created_at'] = $r['created-at'];
        $_SESSION['updated_at'] = $r['updated-at'];
        $_SESSION['user_2fa'] = $r['2fa'];
        $_SESSION['user_discord'] = $r['discord'];
		$_SESSION['user_twitter'] = $r['twitter'];
		$_SESSION['user_youtube'] = $r['youtube'];
		$_SESSION['user_instagram'] = $r['instagram'];
        $_SESSION['user_github'] = $r['github'];
        $_SESSION['user_banner'] = $r['banner'];
        $_SESSION['user_blocked'] = $r['blocked'];
        $_SESSION['user_blocked_by'] = $r['blocked_by'];
        $_SESSION['user_blocked_reason'] = $r['blocked_reason'];
        $_SESSION['user_permission'] = $r['permission'];
    }
} else {
    echo "0 results";
}

$conn = null;

header('Location: /account/');
exit();
die();
