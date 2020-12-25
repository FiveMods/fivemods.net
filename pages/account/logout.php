<?php
if (!empty($_POST['currentPage'])) {
	$directPage = "?rdc=".$_POST['currentPage'];
	echo $directPage;
}

	if ($_GET['url'] == "timeout") {
		unset($_SESSION['access_token']);
		unset($_SESSION['dc_access_token']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_id']);
		unset($_SESSION['control_2FA']);
		session_destroy();
		session_start();
		$_SESSION['logoutsuccess'] = '<span class="text-warning">No activity within 1440 seconds; please log in again.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "removal") {
		unset($_SESSION['access_token']);
		unset($_SESSION['dc_access_token']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_id']);
		unset($_SESSION['control_2FA']);
		session_destroy();
		session_start();
		$_SESSION['logoutsuccess'] = '<span class="text-danger">Your account has been successfully deleted.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "banned") {
		unset($_SESSION['access_token']);
		unset($_SESSION['dc_access_token']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_id']);
		unset($_SESSION['control_2FA']);
		session_destroy();
		session_start();
		$_SESSION['logoutsuccess'] = '<span class="text-danger">Your account has been banned.
		You can create a ban appeal in our <a href="/discord/">discord</a>.<br>Your current payment income and outcome is frozen.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "error") {
		unset($_SESSION['access_token']);
		unset($_SESSION['dc_access_token']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_id']);
		unset($_SESSION['control_2FA']);
		session_destroy();
		session_start();
		$_SESSION['logoutsuccess'] = '<span class="text-danger">An error occured. You got logged out.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} else {
		unset($_SESSION['access_token']);
		unset($_SESSION['dc_access_token']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_id']);
		unset($_SESSION['control_2FA']);
		session_destroy();
		session_start();
		$_SESSION['logoutsuccess'] = '<span class="text-success">You have been successfully logged out.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	}
?>
