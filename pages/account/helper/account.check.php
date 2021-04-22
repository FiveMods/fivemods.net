<?php
session_start();

if(!isset($_COOKIE['f_val']) || !isset($_COOKIE['f_key'])) {
	header("location: /account/logout/");
	exit();
	die();
}

include_once('../../../config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

$selToken = $pdo->prepare("SELECT * FROM sessions WHERE newid = ?");
$selToken->execute(array($_COOKIE['f_key']));
$fetch = $selToken->fetch();

$selectUsername = $pdo->prepare("SELECT * FROM user WHERE uuid = ?");
$selectUsername->execute(array($fetch['uuid']));

$selFetch = $selectUsername->fetch();
$username = str_replace(" ", "_", $selFetch['name']);

$nameCheck = $pdo->prepare("SELECT * FROM user WHERE name = ?");
$nameCheck->execute(array($username));

if($nameCheck->rowCount() > 1) {
    $username = $username . "_". randomChars(6);
}

if(strlen($_POST['username']) >= 3 && strlen($_POST['username'] <= 50) && !preg_match('/\W/', $_POST['username'])) {
    echo "valid";
} else {
    $username = "User_". randomChars(6);
}


$insert = $pdo->prepare("UPDATE user SET name = :name WHERE uuid = :uuid");
$insert->execute(array("name" => $username, "uuid" => $fetch['uuid']));

$pdo = null;

header("Location: /account/");
exit();
die();

function randomChars($length) {
    $permitted_chars = '0123456789';
    return substr(str_shuffle($permitted_chars), 0, $length);
}

?>