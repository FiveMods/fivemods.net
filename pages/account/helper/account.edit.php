<?php 

session_start();

if (empty($_SESSION['user_id'])) {
  header('location: /logout');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    header('location: /');
    exit();
  } else {


    function editAccount() {
      require_once('../../../config.php');

        $username2 = htmlspecialchars($_POST['username']);
        $banner = htmlspecialchars($_POST['gbanner']);
        $tochange = htmlspecialchars($_POST['id']);

        $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

        $userDB = $pdo->prepare("SELECT * FROM user WHERE name = :username");
        $userDB->execute(array('username' => $username2));

        if($userDB->rowCount() > 0) {

          session_start();
          $_SESSION['success'] = '<div class="alert alert-danger" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Error! </strong> Your selected username is already taken!
        </div>
        ';
          header('location: /account/');
          exit();
          die();
          
        }


        try {
          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

          // set the PDO error mode to exception
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $stmt = $pdo->prepare("UPDATE user SET name = :name, banner = :banner WHERE oauth_uid = :uid");
          $stmt->execute(array("name" => $username2, "banner" => $banner, "uid" => $tochange));
        
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
        }
        
        $pdo = null;
    }

    if(htmlspecialchars($_POST['call']) == "callFunc") {
        editAccount();
        exit();
        die();
    }

  }

?>