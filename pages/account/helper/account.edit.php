<?php
session_start();
require_once('../../../config.php');
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
    if(isset($_POST['username']) || empty($_POST['username'])) {

      if(strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 35) {
        if(!preg_match('/\W/', $_POST['username'])) {

          $stmt = $pdo->prepare("UPDATE user SET name = ? WHERE uuid = ?");
          $stmt->execute(array($_POST['username'], $_SESSION['uuid']));

          print_r("SUCCESS");
        } else {
          print_r("ERR_REGEX");
          exit();
          die();
        }
      } else {
        print_r("ERR_LEN");
        exit();
        die();
      }
    } else {
      print_r("ERR_EMPTY");
      exit();
      die();
    }

}


?>