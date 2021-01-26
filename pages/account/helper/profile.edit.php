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


    function editProfile() {
      require_once('../../../config.php');


        $email = htmlspecialchars($_POST['email']);
        $description = htmlspecialchars($_POST['desc']);
        $website = empty(htmlspecialchars($_POST['website'])) ? NULL : htmlspecialchars($_POST['website']);
        $location = htmlspecialchars($_POST['location']);
        $tochange = htmlspecialchars($_POST['id']);

        try {
          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $stmt = $pdo->prepare("UPDATE user SET email = :email, description = :desc, website = :website, locale = :local WHERE oauth_uid = :uid");
          $stmt->execute(array("email" => $email, "desc" => $description, "website" => $website, "local" => $location, "uid" => $tochange));

          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
          $_SESSION['user_username'] = $first_name ." ". $last_name;
          $_SESSION['user_email'] = $email;
          $_SESSION['user_description'] = $description;
          $_SESSION['user_locale'] = $location;
          $_SESSION['user_website'] = $website;
          $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully changed! </strong> Your profile has been updated.
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
        editProfile();
        exit();
        die();
    }

  }

?>
