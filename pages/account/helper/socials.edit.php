<?php 

session_start();

if(!isset($_COOKIE['f_val']) || !isset($_COOKIE['f_key'])) {
	header("location: /account/logout/");
	exit();
	die();
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

        try {
          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
          $stmt = $pdo->prepare("UPDATE user SET discord=:discord, twitter=:twitter, youtube=:youtube, instagram=:instagram, github=:github WHERE uuid = :uuid");
          $stmt->execute(array('discord' => $discord, 'twitter' => $twitter, 'youtube' => $youtube, 'instagram' => $instagram, 'github' => $github, 'uuid' => $_SESSION['uuid']));
        
          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfully";
          session_start();
          $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully changed! </strong> Your profile got successfully updated.
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
