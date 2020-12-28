<?php
    session_start();
    require_once('../config.php');

    $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

    
    require_once('../config.php');
        
    $servernameP = $mysqlPayment['servername'];
    $usernameP = $mysqlPayment['username'];
    $passwordP = $mysqlPayment['password'];
    $dbnameP = $mysqlPayment['dbname'];

    $pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);

    if(htmlspecialchars($_POST['contact'])) {
        contact($pdo);
    } elseif (htmlspecialchars($_POST['partner'])) {
        partner($pdo);
    } elseif(htmlspecialchars($_POST['reportmod'])) {
        reportmod($pdo);
    } elseif(htmlspecialchars($_GET['rate'])) {
        rate($pdo);
    } elseif (htmlspecialchars($_POST['reportuser'])) {
        reportuser();
    } elseif (htmlspecialchars($_GET['upload'])) {
        uploadMod();
    } elseif (htmlspecialchars($_GET['download']) and htmlspecialchars($_GET['o'])) {
        downloadMod($pdo, $pdoPayment);
    } else {
        header('Location: ../error/400/403');
        exit();
        die();
    }

    function contact($pdo) {
        session_start();

        $userid = $_SESSION['user_iid'];
        $category = htmlspecialchars($_POST['category']);
        $header = htmlspecialchars($_POST['header']);
        $description = nl2br(htmlspecialchars($_POST['message']));
        
        $insert = $pdo->prepare("INSERT INTO contact (userid, category, heading, c_description) VALUES (:userid, :cat, :header, :desc)");
        $insert->execute(array("userid" => $userid, "cat" => $category, "header" => $header, "desc" => $description));

        $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully sent! </strong> We recieved your contact request and will answer it as soon as possible!
        </div>';

        header("Location: /contact/");

        exit();
        die();
    }

    function partner($pdo) {
        session_start();

        $userid = $_SESSION['user_iid'];
        $q1 = htmlspecialchars($_POST['q1']);
        $q2 = htmlspecialchars($_POST['q2']);
        $q3 = htmlspecialchars($_POST['q3']);
        $q4 = htmlspecialchars($_POST['q4']);

        $pdo->prepare("INSERT INTO `partner` (userid, q1, q2, q3, q4) VALUES ('$userid', :q1, :q2, :q3, :q4)");
        $pdo->execute(array('q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4));

        $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully sent! </strong> We recieved your partner application and will answer it as soons as possible!
        </div>';

        header("Location: /partner-program");


        exit();
        die();
    }

    function reportmod($pdo) {
        session_start();

        $authorid = $_SESSION['user_iid'];
        $modid = htmlspecialchars($_POST['modid']);
        $reason = htmlspecialchars($_POST['reason']);
        $evidence = htmlspecialchars($_POST['evidence']);
        echo $authorid;
        $db = $pdo->prepare("INSERT INTO `reports` (modid, authorid, reason, evidence) VALUES (:mid, :aid, :reason, :evidence)");
        $db->execute(array(":mid" => $modid, ":aid" => $authorid, ":reason" => $reason, ":evidence" => $evidence));

        $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully sent! </strong> We recieved the report, our support team will have a look at it shortly!
        </div>';


        header("Location: /product?id=$modid");
        exit();
        die();
    }

    function reportuser() {
        session_start();
        require_once('../config.php');

        $servername = $mysql['servername'];
        $username = $mysql['username'];
        $password = $mysql['password'];
        $dbname = $mysql['dbname'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $authorid = htmlspecialchars($_POST['authorid']);
        $modid = htmlspecialchars($_POST['modid']);
        $reason = htmlspecialchars($_POST['reason']);
        $evidence = htmlspecialchars($_POST['evidence']);

        $sql = "INSERT INTO `reports` (modid, authorid, reason, evidence) VALUES ('$modid', '$authorid', '$reason', '$evidence')";
        $conn->query($sql);
        echo '<meta http-equiv="refresh" content="0; URL=/product?id='. $modid .'">';
        exit();
        die();
    }

    function reportprofile() {
        session_start();
        require_once('../config.php');

        $servername = $mysql['servername'];
        $username = $mysql['username'];
        $password = $mysql['password'];
        $dbname = $mysql['dbname'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $authorid = htmlspecialchars($_POST['authorid']);
        $modid = htmlspecialchars($_POST['modid']);
        $reason = htmlspecialchars($_POST['reason']);
        $evidence = htmlspecialchars($_POST['evidence']);

        $sql = "INSERT INTO `reports` (modid, authorid, reason, evidence) VALUES ('$modid', '$authorid', '$reason', '$evidence')";
        $conn->query($sql);
        header("location: /product/?id=".$modid);
        exit();
        die();
    }

    function rate($pdo) {
        session_start();

        $cookieArray = explode("_", $_GET['id']);

        $nameID = $cookieArray[0];
        $rating = $cookieArray[1];

        $changeRating = $pdo->prepare("SELECT m_rating FROM mods WHERE m_id = :id");
        $changeRating->execute(array('id' => $nameID));
        while($row = $changeRating->fetch()) {
            $m_rating = $row['m_rating'];
            if(!empty($m_rating)) {
            $newRating = $m_rating . " " . $rating;
            } else {
            $newRating = $rating;
            }
            $change = $pdo->prepare("UPDATE mods SET m_rating = :rating WHERE m_id = :id");
            $change->execute(array('rating' => $newRating, 'id' => $nameID));

            $log = $pdo->prepare("INSERT INTO rate (mod_id, user_id) VALUES (:mod, :id)");
            $log->execute(array('mod' => $nameID, 'id' => $_GET['userid']));
            header("Location: /product/$nameID");
            $_SESSION['rated'] = $rating;
            exit();
            die();
        }
    }
    function uploadMod() {
        header("location: /upload/");
    }
    function randomChars($length) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $length);
    }

    function downloadMod($pdo, $pdoPayment) {
        session_start();

        

        $mod = $_GET['download'];
        $download = $pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM mods LEFT JOIN user ON mods.m_authorid = user.id WHERE m_id = :id");
        $download->execute(array('id' => $mod));
        while($row = $download->fetch()) {
            $downloads = $row['m_downloads'];
            
            $_SESSION['lastDownload'] = "5000";
            if($_SESSION['lastDownload'] != $mod) {
                $newDownloads = $downloads + 1;
                $newDownloadSet = $pdo->prepare("UPDATE mods SET m_downloads = :downloads WHERE m_id = :id");
                $newDownloadSet->execute(array("downloads" => $newDownloads, "id" => $mod));
                
                $selectBalance = $pdoPayment->prepare("SELECT balance FROM payment_user WHERE uuid = :uuid");
                $selectBalance->execute(array("uuid" => $row['uuid']));

                $fetchBalance = $selectBalance->fetch();
                $balance = floatval($fetchBalance['balance']);

                if($row['premium'] == 1) 
                    $newBalance = $balance + 0.002;
                else
                    $newBalance = $balance + 0.001;

                $updateBalance = $pdoPayment->prepare("UPDATE payment_user SET balance = :balance WHERE uuid = :uuid");
                $updateBalance->execute(array('balance' => $newBalance, 'uuid' => $row['uuid']));

                $_SESSION['downloadMod'] = $newDownloads;
            } else {
                $_SESSION['downloadMod'] = $downloads;
            }
            $_SESSION['lastDownload'] = $mod;
        }

        
        
        switch ($_GET['o']) {
            case 'product':
                header("Location: /product/$mod");
                break;
            case 'index':
                header("Location: /");
                break;
            case 'user':
                $user = $_GET['username'];
                header("Location: /user/$user");
            default:
                header("Location: /");
                break;
        }
        exit();
        die();
    }
