<?php

$errors = [];

$path = "../localstorage/upload/";

$extensions = ["zip", "7z", "rar", "tar", "tar.gz"];


require_once('../config.php');
if (isset($_COOKIE['f_key']) || isset($_COOKIE['f_val'])) {

    $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

    $selToken = $pdo->prepare("SELECT * FROM sessions WHERE newid = ?");
    $selToken->execute(array($_COOKIE['f_key']));
    if ($selToken->rowCount() == 0) {
        $errors[] = "Not logged in";
    } 
} else {
    $errors[] = "Not logged in";
}

if ($_SERVER ["REQUEST_METHOD"] === "POST") {
	if (isset($_FILES['files'])) {

        if(count($_FILES ["files"]["tmp_name"]) > 1) $errors[] = "Too many files.";
		else {
            $file_name = strtolower(reset(explode('.', $_FILES['files']['name'][0])));
			$file_ext = strtolower(end(explode('.', $_FILES['files']['name'][0])));

			$file = $path . $file_name . "-" . randomChars() . "." . $file_ext;
			
			if (!in_array($file_ext, $extensions)) {
				$errors[] = "Extension not allowed";
			}else if ($_FILES['files']['size'][0] > 2097152) {
				$errors[] = "More than 100mb";
			}
			
			if (empty($errors)) {
				move_uploaded_file($_FILES['files']['tmp_name'][0], $file);
			}
		}
		if ($errors) print_r($errors);
	}
}

function randomChars($length = 6)
{
   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   return substr(str_shuffle($permitted_chars), 0, $length);
}

?>