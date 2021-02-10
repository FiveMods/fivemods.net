<?php

session_start();

if(!isset($_COOKIE['f_val']) || !isset($_COOKIE['f_key'])) {
	header("location: /account/logout/");
	exit();
	die();
} else {
  require_once('../../../config.php');
  $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

  $acc = $pdo->prepare("SELECT id FROM user WHERE uuid = ?");
  $acc->execute(array($_SESSION['uuid']));
  if($acc->rowCount() > 0) {
     $accvals = $acc->fetch();
     $id = $accvals['id'];
  }
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "Not allowed!";
  header('location: /account/logout/?url=error');
  exit();
} else {


  function delMod($id)
  {

    $mid = htmlspecialchars($_POST['mid']);

    require_once('../../../config.php');

    $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

    $stmt = $pdo->prepare("DELETE FROM mods WHERE m_id = :mid AND m_authorid = :aid");
    $stmt->execute(array("mid" => $_SESSION['mmid'], "aid" => $id));
    $pdo = null;
      echo "Record deleted successfully";
      session_start();
      $_SESSION['success'] = '<div class="alert alert-warning" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully deleted! </strong> Your mod (' . $_SESSION['mmid'] . ') got deleted.
        </div>';
      header('location: /account/');

  }

  if (htmlspecialchars($_POST['call']) == "callFunc") {
    delMod($id);
    exit();
    die();
  }
}
