<?php 
session_start();

if (empty($_SESSION['user_id'])) {
  header('location: /logout');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    header('location: /');
    exit;
  } else {


    function disable2FA() {
        session_start();
        require_once('../../../config.php');

        $id = $_SESSION['user_id'];

        try {
          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

          // set the PDO error mode to exception
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $stmt = $pdo->prepare("UPDATE user SET 2fa='0', premium='0' WHERE oauth_uid = ?");
          $stmt->execute(array($id));
        
          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
        $_SESSION['user_2fa'] = "0";
        $_SESSION['success'] = '<div class="alert alert-warning" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully changed! </strong> Your profile is no longer secured via a two factor authentication! Your profile will be adjusted accordingly.
      </div>
      ';
        header('location: /account/');
        } catch(PDOException $e) {
          echo "X";
          header('location: /account/');
          // echo $sql . "<br>" . $e->getMessage();
        }

        $pdo = null;

    }

    if(htmlspecialchars($_POST['call']) == "callFunc") {
      echo $_SESSION['2facode'];
      echo "<br>".$_POST['value'];
      if($_SESSION['2facode'] == $_POST['value']) {
        disable2FA();
      } else {
        
        $_SESSION['success'] = '<div class="alert alert-danger" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>An Error occured! </strong> Something went wrong.
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
