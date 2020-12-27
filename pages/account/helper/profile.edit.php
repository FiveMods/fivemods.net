<?php 

session_start();

if (empty($_SESSION['user_id'])) {
  header('location: /logout');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    header('location: /account/logout/?url=error');
    exit;
  } else {


    function editProfile() {
      require_once('../../../config.php');

      $servername = $mysql['servername'];
      $username = $mysql['username'];
      $password = $mysql['password'];
      $dbname = $mysql['dbname'];

        $fullName = explode(" ", htmlspecialchars($_POST['fullName']));
        $first_name = $fullName[0];
        $last_name = $fullName[1];
        $email = htmlspecialchars($_POST['email']);
        $description = htmlspecialchars($_POST['desc']);
        $website = htmlspecialchars($_POST['website']);
        $location = htmlspecialchars($_POST['location']);
        $tochange = htmlspecialchars($_POST['id']);

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $sql = "UPDATE user SET first_name='$first_name', last_name='$last_name', email='$email', description='$description', website='$website', locale='$location' WHERE oauth_uid = $tochange";
        
          // Prepare statement
          $stmt = $conn->prepare($sql);
        
          // execute the query
          $stmt->execute();
        
          // echo a message to say the UPDATE succeeded
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
        
        $conn = null;

    }

    if(htmlspecialchars($_POST['call']) == "callFunc") {
        editProfile();
        exit();
        die();
    }

  }

?>