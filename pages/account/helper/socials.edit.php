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


    function editSocials() {
      require_once('../../../config.php');

      $servername = $mysql['servername'];
      $username = $mysql['username'];
      $password = $mysql['password'];
      $dbname = $mysql['dbname'];

        $discord = htmlspecialchars($_POST['discord']);
        $twitter = htmlspecialchars($_POST['twitter']);
        $youtube = htmlspecialchars($_POST['youtube']);
        $instagram = htmlspecialchars($_POST['instagram']);
        $github = htmlspecialchars($_POST['github']);
        $tochange = htmlspecialchars($_POST['id']);

        try {
          $conn = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $sql = "UPDATE user SET discord=:discord, twitter=:twitter, youtube=:youtube, instagram=:instagram, github=:github WHERE oauth_uid = :oauth";
        
          // Prepare statement
          $stmt = $conn->prepare($sql);
        
          // execute the query
          $stmt->execute(['discord' => $discord, 'twitter' => $twitter, 'youtube' => $youtube,
              'instagram' => $instagram, 'github' => $github, 'oauth' => $tochange]);
        
          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
          $_SESSION['user_discord'] = $discord;
          $_SESSION['user_twitter'] = $twitter;
          $_SESSION['user_youtube'] = $youtube;
          $_SESSION['user_instagram'] = $instagram;
          $_SESSION['user_github'] = $github;
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
        editSocials();
        exit();
        die();
    }

  }

?>