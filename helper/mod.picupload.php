<?php
session_start();

$status = [];

$path = "/var/www/fivemods/storage-html/uploads/pics/";

$extensions = ["png", "jpg", "webp", "jpeg", "PNG", "JPG", "WEBP", "JPEG"];


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

	if(!isset($_POST['id'])) {
		print_r("ERR_NO_ID");
		exit();
		die();
	}
	if (isset($_FILES['files'])) {
		$errors = [];
		$all_files = count ($_FILES ["files"]["tmp_name"]);

		for ($i = 0; $i < $all_files; $i++) {
			$file_name = $_FILES['files']['name'][$i];
			$file_tmp = $_FILES['files']['tmp_name'][$i];
			$file_size = $_FILES['files']['size'][$i];
			$file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));

			$file = $path . $file_name;
			
			if($all_files > 10) {
				$errors[] = 'ERR_TOO_MANY';
			}

			if (!in_array($file_ext, $extensions)) {
				$errors[] = 'ERR_EXT';
			}

			if ($file_size > 100000000) {
				$errors[] = 'ERR_BIG';
			}
		}
		if(empty($errors)) {
			for ($i = 0; $i < $all_files; $i++) {
				$file_name = $_FILES['files']['name'][$i];
				$file_tmp = $_FILES['files']['tmp_name'][$i];
				$file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));

				$file = $path . $_POST['id'] . "-" . randomChars() . "." . $file_ext;

				move_uploaded_file($file_tmp, $file);
			}
		}
		
		if ($errors) print_r($errors[0]);
		else print_r("SUCCESS");
	}
}

function randomChars($length = 16)
{
   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   return substr(str_shuffle($permitted_chars), 0, $length);
}

?>