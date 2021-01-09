<?php
$sql = \Providers\SqlProvider::getInstance();

$selectUsername = $sql->prepare("SELECT * FROM user WHERE name = :name");
$selectUsername->execute(array("name" => $_SESSION['user_username']));

if($selectUsername->rowCount() > 0) {
    $username = $_SESSION['user_username'] . "-". randomChars(6);
} else {
    $username = $_SESSION['user_username'];
}
$_SESSION['user_username'] = $username;
$insert = $sql->prepare("UPDATE user SET name = :name WHERE uuid = :uuid");
$insert->execute(array("name" => $username, "uuid" => $_SESSION['user_uuid']));


header("Location: /account/");
exit();


function randomChars($length) {
    $permitted_chars = '0123456789';
    return substr(str_shuffle($permitted_chars), 0, $length);
}

?>