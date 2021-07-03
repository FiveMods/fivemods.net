<?php
session_start();

require_once('../config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

if (isset($_COOKIE['f_key']) || isset($_COOKIE['f_val'])) {

    $selToken = $pdo->prepare("SELECT * FROM sessions WHERE newid = ?");
    $selToken->execute(array($_COOKIE['f_key']));
    if ($selToken->rowCount() == 0) {
        print_r("NOT_LOGGED_IN");
        exit();
        die();
    } else {
        $manageVals = $pdo->prepare("SELECT id FROM user WHERE uuid = ?");
        $manageVals->execute(array($_SESSION['uuid']));
        $user = $manageVals->fetch();
    }
} else {
    print_r("NOT_LOGGED_IN");
    exit();
    die();
}
if((int)isset($_POST['rate']) && (int)isset($_POST['mid'])) {
    $select = $pdo->prepare("SELECT * FROM rate WHERE `mod_id` = ? AND `user_id` = ?");
    $select->execute(array($_POST['mid'], $user['id']));
    if($select->rowCount() > 0) {
        print_r("ERR_ALREADY_RATED");
        exit();
        die();
    } else {
        if($_POST['rate'] != 0 && $_POST['rate'] <= 5) {
            $modCheck = $pdo->prepare("SELECT * FROM mods WHERE m_id = ?");
            $modCheck->execute(array($_POST['mid']));
            if($modCheck->rowCount() > 0) {
                $fetch = $modCheck->fetch();
                
                $insertRate = $pdo->prepare("INSERT INTO rate (mod_id, user_id) VALUES (?, ?)");
                $insertRate->execute(array($_POST['mid'], $user['id']));

                if(!empty($fetch['m_rating']))
                    $newRate = $fetch['m_rating'] . " " . $_POST['rate'];
                else 
                    $newRate = $_POST['rate'];

                $insertMod = $pdo->prepare("UPDATE mods SET m_rating = ? WHERE m_id = ?");
                $insertMod->execute(array($newRate, $_POST['mid']));

                print_r("SUCCESS");
                exit();
                die();

            } else {
                print_r("ERR_EMPTY");
                exit();
                die();
            }
        } else {
            print_r("ERR_EMPTY");
            exit();
            die();
        }
    }
}
else
{
    print_r("ERR_EMPTY");
    exit();
    die();
}

?>