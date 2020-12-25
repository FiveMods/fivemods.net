<?php

// If login request got cancled
if ($_GET['error'] == "access_denied") {
    header('location: /account/logout/');
}

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

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', $dcoauthid);
define('OAUTH2_CLIENT_SECRET', $dcoauthsecret);

$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';

session_start();

// Start the login process by sending the user to Discord's authorization page
if (get('action') == 'login') {

    $params = array(
        'client_id' => OAUTH2_CLIENT_ID,
        'redirect_uri' => 'http://localhost/pages/account/d-callback.php',
        'response_type' => 'code',
        'scope' => 'identify guilds email'
    );

    // Redirect the user to Discord's authorization page
    header('Location: '.$dcCallback);
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

    $_SESSION['dc_id'] = $user->id;
    $_SESSION['dc_dis'] = $user->discriminator;
    $_SESSION['dc_name'] = $user->username;
    $_SESSION['dc_img'] = 'https://cdn.discordapp.com/avatars/' . $user->id . "/" . $user->avatar . '.png?size=128';
    $_SESSION['dc_avatar'] = '<img src="https://cdn.discordapp.com/avatars/' . $user->id . "/" . $user->avatar . '.png?size=128" alt="User Avatar" class="user-avatar-md rounded-circle"></img>';
    $_SESSION['dc_mail'] = $user->email;
    $_SESSION['dc_avatar'] = $user->avatar;

    $_SESSION['dc_name'] = str_replace(' ', '_', $_SESSION['dc_name']);
    // $_SESSION['user_username'] = str_replace(" ", "", $user->username);
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_image'] = 'https://cdn.discordapp.com/avatars/' . $user->id . "/" . $user->avatar . '.png?size=128';
}


if (get('action') == 'logout') {
    // This must to logout you, but it didn't worked(

    $params = array(
        'dc_access_token' => $logout_token
    );

    // Redirect the user to Discord's revoke page
    header('location: /account/logout/');
    exit();
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

    $url = 'https://cdn.discordapp.com/avatars/' . $_SESSION['user_id'] . "/" . $_SESSION['dc_avatar'] . '.png?size=128';
    echo '<img src="' . 'https://cdn.discordapp.com/avatars/' . $_SESSION['user_id'] . "/" . $_SESSION['dc_avatar'] . '.png?size=128' . '">';

    //Download the file using file_get_contents.
    $downloadedFileContents = file_get_contents($url);

    //Check to see if file_get_contents failed.
    if ($downloadedFileContents === false) {
        throw new Exception('Failed to download file at: ' . $url);
    }

    //The path and filename that you want to save the file to.
    // Change to storage.fivemods.net later on!
    $fileName = '../../localstorage/discord/' . $_SESSION['user_id'] . '.png';
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

    // insert a row
    $sid = session_id();
    $uuid = $v5uuid;
    $oauth_uid = $user->id;
    $oauth_provider = "Discord Inc.";
    // $name = $_SESSION['user_username'];
    $first_name = $_SESSION['dc_name'];
    $last_name = "";
    $email = $user->email;
    $password = '************';
    $picture = $fileName;
    $gender = "-";
    $locale = "-";
    $description = "No description set.";
    $permission = "1000";
    $main_ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
    $stmt->execute();

    $servernameP = $mysqlPayment['servername'];
    $usernameP = $mysqlPayment['username'];
    $passwordP = $mysqlPayment['password'];
    $dbnameP = $mysqlPayment['dbname'];

    $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);
    $pdoPayment->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $insertUser = $pdoPayment->prepare("INSERT INTO payment_user (oauth_provider, oauth_id, uuid, username, email, country_code) VALUES (:provider, :id, :uuid, :username, :email, :country)");
    $insertUser->execute(array('provider' => $oauth_provider, 'id' => $oauth_uid, 'uuid' => $v5uuid, 'username' => $first_name, 'email' => $email, 'country' => $locale));

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
  		$fileName = '../../localstorage/discord/' . $_SESSION['user_id'] . '.png';
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
?>
