<?php

session_start();

if (empty($_SESSION['user_id'])) {
  header('location: /logout');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "Not allowed!";
  header('location: /account/logout/?url=error');
  exit();
} else {


  function delMod()
  {

    $mid = htmlspecialchars($_POST['mid']);

    require_once('../../../config.php');

    $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

    $stmt = $pdo->prepare("DELETE FROM mods WHERE m_id = :mid AND m_authorid = :aid");
    $stmt->execute(array("mid" => $_SESSION['mmid'], "aid" => $_SESSION['user_iid']));
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
    delMod();
    exit();
    die();
  }
}
