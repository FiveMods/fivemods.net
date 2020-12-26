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


    function enable2FA() {
        session_start();
        require_once('../../../config.php');

        $servername = $mysql['servername'];
        $username = $mysql['username'];
        $password = $mysql['password'];
        $dbname = $mysql['dbname'];

        $id = $_SESSION['user_id'];

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $sql = "UPDATE user SET 2fa='1' WHERE oauth_uid = $id";
        
          // Prepare statement
          $stmt = $conn->prepare($sql);
        
          // execute the query
          $stmt->execute();
        
          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
        $_SESSION['user_2fa'] = "1";
        $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully changed! </strong> Your profile is now secured via 2FA.
      </div>
      ';
        header('location: /account/');
        } catch(PDOException $e) {
          echo "X";
          header('location: /account/');
          // echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

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
