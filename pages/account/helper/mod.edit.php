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


    function editMod() {

        $modName = htmlspecialchars($_POST['modName']);
        $modDesc = nl2br($_POST['modDesc']);
        $modCategory = htmlspecialchars($_POST['modCategory']);
        $tags = htmlspecialchars($_POST['tags']);
        $requiredMod = htmlspecialchars($_POST['requiredMod']);
        $mid = htmlspecialchars($_POST['id']);

        try {
        require_once('../../../config.php');

          $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $pdo->prepare("UPDATE mods SET m_name = :mname, m_category = :mcat, m_description = :desc, m_tags = :tags, m_requiredmod = :req WHERE m_id = :mid");
          $stmt->execute(array("mname" => $modName, "mcat" => $modCategory, "desc" => $modDesc, "tags" => $tags, "req" => $requiredMod, "mid" => $mid));

          // echo a message to say the UPDATE succeeded
          echo $stmt->rowCount() . " records UPDATED successfull";
          session_start();
          $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>Successfully changed! </strong> Your mod got updated.
        </div>';
        header('location: /account/');
        } catch(PDOException $e) {
          echo "X";
          header('location: /account/');
        }

        $pdo = null;
    }

    if(htmlspecialchars($_POST['call']) == "callFunc") {
        editMod();
        exit();
        die();
    }

  }
