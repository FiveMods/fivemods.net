<?php 

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    header('location: /');
    exit;
  } else {


    function editAccount() {
      require_once('../../../config.php');

      $servername = $mysql['servername'];
      $username = $mysql['username'];
      $password = $mysql['password'];
      $dbname = $mysql['dbname'];

        $username2 = htmlspecialchars($_POST['username']);
        $banner = htmlspecialchars($_POST['gbanner']);
        $tochange = htmlspecialchars($_POST['id']);


        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $sql = "UPDATE user SET name='$username2', banner='$banner' WHERE oauth_uid = $tochange";
        
          // Prepare statement
          $stmt = $conn->prepare($sql);
        
          // execute the query
          $stmt->execute();
        
          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
          $_SESSION['user_username'] = $username2;
          $_SESSION['user_banner'] = $banner;
          $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully changed! </strong> Your profile got successfully updated. Click <a href="/user/'.$_SESSION['user_username'].'">here</a> to see your changes.
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
        editAccount();
        exit();
        die();
    }

  }

?>