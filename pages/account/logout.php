<?php
	if (!empty($_POST['currentPage'])) {
		$directPage = "?rdc=".$_POST['currentPage'];
		echo $directPage;
	}

	setcookie("f_val", " ", time() - 3600, "/");
	setcookie("f_key", " ", time() - 3600, "/");
	session_destroy();
	session_start();

	if ($_GET['url'] == "timeout") {
		$_SESSION['logoutsuccess'] = '<span class="text-warning">No activity within 1440 seconds; please log in again.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "removal") {
		$_SESSION['logoutsuccess'] = '<span class="text-danger">Your account has been successfully deleted.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "banned") {
		$_SESSION['logoutsuccess'] = '<span class="text-danger">Your account has been banned.
		You can create a ban appeal in our <a href="/discord/">discord</a>.<br>Your current payment income and outcome is frozen.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "error") {
		$_SESSION['logoutsuccess'] = '<span class="text-danger">An error occured. You got logged out.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	} elseif ($_GET['url'] == "invalid") {
		$_SESSION['logoutsuccess'] = '<span class="text-danger">Oops, something went wrong! Please log in again.</span>';
		header('Location: /account/sign-in/'.$directPage);
	} else {
		$_SESSION['logoutsuccess'] = '<span class="text-success">You have been successfully logged out.</span>';
		header('Location: /account/sign-in/'.$directPage);
		exit();
	}
?>
