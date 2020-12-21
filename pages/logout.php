<?php
		unset($_SESSION['access_token']);
		unset($_SESSION['dc_access_token']);
		session_destroy();
		header('Location: /account/sign-in/');
		exit();
    die();
?>
