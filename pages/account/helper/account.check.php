<?php
session_start();

include_once('../../../config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$selectUsername = $pdo->prepare("SELECT * FROM user WHERE name = :name");
$selectUsername->execute(array("name" => $_SESSION['user_username']));

if($selectUsername->rowCount() > 0) {
    $username = $_SESSION['user_username'] . "-". randomChars(6);
} else {
    $username = $_SESSION['user_username'];
}
$_SESSION['user_username'] = $username;
$insert = $pdo->prepare("UPDATE user SET name = :name WHERE uuid = :uuid");
$insert->execute(array("name" => $username, "uuid" => $_SESSION['user_uuid']));

$pdo = null;
header("Location: /account/");
exit();
die();


function randomChars($length) {
    $permitted_chars = '0123456789';
    return substr(str_shuffle($permitted_chars), 0, $length);
}

?>