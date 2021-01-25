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


    function editSocials() {
      require_once('../../../config.php');


        $discord = empty(htmlspecialchars($_POST['discord'])) ? NULL : htmlspecialchars($_POST['discord']);
        $twitter = empty(htmlspecialchars($_POST['twitter'])) ? NULL : htmlspecialchars($_POST['twitter']);
        $youtube = empty(htmlspecialchars($_POST['youtube'])) ? NULL : htmlspecialchars($_POST['youtube']);
        $instagram = empty(htmlspecialchars($_POST['instagram'])) ? NULL : htmlspecialchars($_POST['instagram']);
        $github = empty(htmlspecialchars($_POST['github'])) ? NULL : htmlspecialchars($_POST['github']);
        $tochange = htmlspecialchars($_POST['id']);

        try {
          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $stmt = $pdo->prepare("UPDATE user SET discord=:discord, twitter=:twitter, youtube=:youtube, instagram=:instagram, github=:github WHERE oauth_uid = :oauth");
          $stmt->execute(array('discord' => $discord, 'twitter' => $twitter, 'youtube' => $youtube, 'instagram' => $instagram, 'github' => $github, 'oauth' => $tochange));
        
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

        $pdo = null;

    }

    if(htmlspecialchars($_POST['call']) == "callFunc") {
        editSocials();
        exit();
        die();
    }

  }

?>
