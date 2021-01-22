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

    $servername = $mysql['servername'];
    $username = $mysql['username'];
    $password = $mysql['password'];
    $dbname = $mysql['dbname'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // sql to delete a record
    $sql = "DELETE FROM mods WHERE m_id='$_SESSION[mmid]' AND m_authorid='$_SESSION[user_iid]'";

    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
      session_start();
      $_SESSION['success'] = '<div class="alert alert-warning" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully deleted! </strong> Your mod (' . $_SESSION['mmid'] . ') got deleted.
        </div>';
      header('location: /account/');
    } else {
      echo "Error deleting record: " . $conn->error;
      echo "X";
      header('location: /account/logout/?url=error');
    }

    $conn->close();
  }

  if (htmlspecialchars($_POST['call']) == "callFunc") {
    delMod();
    exit();
    die();
  }
}
