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


  function reqRev()
  {

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
    $sql = "UPDATE mods SET m_approved='1' WHERE m_id='$_SESSION[mmid]'";

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
      session_start();
      $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully requested! </strong> Your mod (' . $_SESSION['mmid'] . ') is now in our review queue and will get reviewed again.
        </div>';
      header('location: /account/');
    } else {
      echo "Error deleting record: " . $conn->error;
      echo "X";
      header('location: /account/logout/?url=error');
      die();
    }

    $conn->close();
  }

  if (htmlspecialchars($_POST['call']) == "callFunc") {
    reqRev();
    exit();
    die();
  }
}
