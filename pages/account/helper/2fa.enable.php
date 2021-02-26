<?php 
session_start();

if(!isset($_COOKIE['f_val']) || !isset($_COOKIE['f_key'])) {
	header("location: /account/logout/");
	exit();
	die();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    header('location: /');
    exit();
    die();
  } else {


    function enable2FA() {
        session_start();
        require_once('../../../config.php');
        
        try {
          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $stmt = $pdo->prepare("UPDATE user SET 2fa='1' WHERE uuid = ?");
          $stmt->execute(array($_SESSION['uuid']));
        
          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
        $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully changed! </strong> Your profile is now secured via a two factor authentication.
      </div>
      ';
        header('location: /account/');
        } catch(PDOException $e) {
          echo "X";
          header('location: /account/');
        }

        $pdo = null;

    }

    if(htmlspecialchars($_POST['call']) == "callFunc") {
      echo $_SESSION['2facode'];
      echo "<br>".$_POST['value'];
      if($_SESSION['2facode'] == $_POST['value']) {
        enable2FA();
      } else {
        
        $_SESSION['success'] = '<div class="alert alert-danger" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>An Error occured! </strong> The token you provided was invalid or the time ran out.
      </div>
      ';
      header("Location: /account/");
      }
      unset($_SESSION['2facode']);
      exit();
      die();
    } else {
      header("Location: /account/");
    }

  }
