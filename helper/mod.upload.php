<?php


require_once('../config.php');
if (isset($_COOKIE['f_key']) || isset($_COOKIE['f_val'])) {

    $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

    $selToken = $pdo->prepare("SELECT * FROM sessions WHERE newid = ?");
    $selToken->execute(array($_COOKIE['f_key']));
    if ($selToken->rowCount() == 0) {
        print_r("NOT_LOGGED_IN");
		exit();
		die();
    } 
} else {
    print_r("NOT_LOGGED_IN");
	exit();
	die();
}

if ($_SERVER ["REQUEST_METHOD"] === "POST") {
    print_r("SUCCESS");
}

function randomChars($length = 6)
{
   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   return substr(str_shuffle($permitted_chars), 0, $length);
}

?>