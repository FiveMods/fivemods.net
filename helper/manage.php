<?php
session_start();

require_once('../config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

if(!empty($_COOKIE['f_val']) && !empty($_COOKIE['f_key'])) {
    $manageVals = $pdo->prepare("SELECT id FROM user WHERE uuid = ?");
    $manageVals->execute(array($_SESSION['uuid']));
    if($manageVals->rowCount() > 0) {
       $mvals = $manageVals->fetch();
       $uid = $mvals['id'];
    }
}

$servernameP = $mysqlPayment['servername'];
$usernameP = $mysqlPayment['username'];
$passwordP = $mysqlPayment['password'];
$dbnameP = $mysqlPayment['dbname'];

$pdoPayment = new PDO("mysql:host=$servernameP;dbname=$dbnameP", $usernameP, $passwordP);

if (htmlspecialchars($_POST['contact'])) {
    contact($pdo, $uid);
} elseif (htmlspecialchars($_POST['partner'])) {
    partner($pdo, $uid);
} elseif (htmlspecialchars($_POST['reportmod'])) {
    reportmod($pdo, $uid);
} elseif (htmlspecialchars($_GET['upload'])) {
    uploadMod();
} elseif (htmlspecialchars($_GET['download']) and htmlspecialchars($_GET['o'])) {
    downloadMod($pdo, $pdoPayment);
} elseif (isset($_GET['purchase']) and isset($_GET['o'])) {
    purchaseMod($pdo, $pdoPayment, $uid);
} else {
    header('Location: ../error/400/403');
    exit();
    die();
}

function contact($pdo, $uid)
{
    session_start();

    $category = htmlspecialchars($_POST['category']);
    $header = htmlspecialchars($_POST['header']);
    $description = nl2br(htmlspecialchars($_POST['message']));

    $insert = $pdo->prepare("INSERT INTO contact (userid, category, heading, c_description) VALUES (:userid, :cat, :header, :desc)");
    $insert->execute(array("userid" => $uid, "cat" => $category, "header" => $header, "desc" => $description));

    $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully sent! </strong> We recieved your contact request and will answer it as soon as possible!
        </div>';

    header("Location: /contact/");

    exit();
    die();
}

function partner($pdo, $uid)
{
    session_start();

    $q1 = htmlspecialchars($_POST['q1']);
    $q2 = htmlspecialchars($_POST['q2']);
    $q3 = htmlspecialchars($_POST['q3']);
    $q4 = htmlspecialchars($_POST['q4']);


    $partner = $pdo->prepare("INSERT INTO `partner` (userid, q1, q2, q3, q4) VALUES (:uid, :q1, :q2, :q3, :q4)");
    $partner->execute(array('uid' => $uid, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4));

    $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully sent! </strong> We recieved your partner application and will answer it as soons as possible!
        </div>';

    header("Location: /partner-program/");


    exit();
    die();
}

function reportmod($pdo, $uid)
{
    session_start();

    $modid = htmlspecialchars($_POST['modid']);
    $reason = htmlspecialchars($_POST['reason']);
    $evidence = htmlspecialchars($_POST['evidence']);
    echo $authorid;
    $db = $pdo->prepare("INSERT INTO `reports` (modid, authorid, reason, evidence) VALUES (:mid, :aid, :reason, :evidence)");
    $db->execute(array(":mid" => $modid, ":aid" => $uid, ":reason" => $reason, ":evidence" => $evidence));

    $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully sent! </strong> We recieved the report, our support team will have a look at it shortly!
        </div>';


    header("Location: /product?id=$modid");
    exit();
    die();
}

function randomChars($length)
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, $length);
}

function downloadMod($pdo, $pdoPayment)
{
    session_start();

    $ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);;
    $mod = $_GET['download'];

    $getDownloads = $pdo->prepare("SELECT * FROM downloads WHERE ip = ?");
    $getDownloads->execute(array($ip));

    if($getDownloads->rowCount() > 0) 
    {
        $fetch = $getDownloads->fetchAll();
        foreach ($fetch as $modA) {
            if(strtotime($modA['created_at']) > (60 * 1)) {
                if($modA['download_id'] == $mod) {
                    $_SESSION['downloadMod'] = $mod;
                    $_SESSION['lastDownload'] = $mod;
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
            }
        }
    }

    $download = $pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM mods LEFT JOIN user ON mods.m_authorid = user.id WHERE m_id = :id");
    $download->execute(array('id' => $mod));
    while ($row = $download->fetch()) {
        $downloads = $row['m_downloads'];

        if($row['m_blocked'] == 1 || $row['m_approved'] == -1) {
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

        if ($_SESSION['lastDownload'] != $mod) {
            $newDownloads = $downloads + 1;
            $newDownloadSet = $pdo->prepare("UPDATE mods SET m_downloads = :downloads WHERE m_id = :id");
            $newDownloadSet->execute(array("downloads" => $newDownloads, "id" => $mod));

            $selectBalance = $pdoPayment->prepare("SELECT balance FROM payment_user WHERE uuid = :uuid");
            $selectBalance->execute(array("uuid" => $row['uuid']));

            $fetchBalance = $selectBalance->fetch();
            $balance = floatval($fetchBalance['balance']);

            if ($row['premium'] == 1)
                $newBalance = $balance + 0.002;
            else
                $newBalance = $balance + 0.001;

            $updateBalance = $pdoPayment->prepare("UPDATE payment_user SET balance = :balance WHERE uuid = :uuid");
            $updateBalance->execute(array('balance' => $newBalance, 'uuid' => $row['uuid']));

            $totalDownloads = $row['totaldownloads'] + 1;

            $update = $pdo->prepare("UPDATE user SET totaldownloads = $totalDownloads WHERE uuid = :uuid");
            $update->execute(array('uuid' => $row['uuid']));

            $downloadLog = $pdo->prepare("INSERT INTO downloads (`user_uuid`, `download_id`, `ip`) VALUES (?, ?, ?)");
            $downloadLog->execute(array($_SESSION['uuid'], $mod, $ip));

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

/*
function purchaseMod($pdo, $pdoPayment, $uid)
{
    echo "<h1>CURRENTLY DISABLED</h1>";
    
    session_start();

    $fivemodsuuid = "5b3107fd-3dfe-43ae-b8f6-028560184861";

    if (empty($uid)) {
        header('location: /account/');
        die();
    } else {
        $ch = curl_init();
        $token = $apiToken;
        $userid = $uid;

        curl_setopt($ch, CURLOPT_URL, "http://85.214.166.192:8081");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "action=reqBalance&token=$token&uid=$userid");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $mod = $_GET['purchase'];
        $download = $pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM mods LEFT JOIN user ON mods.m_authorid = user.id WHERE m_id = :id");
        $download->execute(array('id' => $mod));
        while ($row = $download->fetch()) {
            $downloads = $row['m_downloads'];
            $costs = $row['m_price'];


            // User has no money or not enough

            if ($response < $costs) {
                $_SESSION['nomoney'] = TRUE;
                header('location: /payment/deposit/');
                exit();
                die();
            } else {

                if ($_SESSION['lastDownload'] != $mod) {
                    $newDownloads = $downloads + 1;
                    $newDownloadSet = $pdo->prepare("UPDATE mods SET m_downloads = :downloads WHERE m_id = :id");
                    $newDownloadSet->execute(array("downloads" => $newDownloads, "id" => $mod));

                    // Selling user

                    $selectBalance = $pdoPayment->prepare("SELECT balance FROM payment_user WHERE uuid = :uuid");
                    $selectBalance->execute(array("uuid" => $row['uuid']));

                    $fetchBalance = $selectBalance->fetch();
                    $balance = floatval($fetchBalance['balance']);

                    // Purchasing user

                    $selectBalanceBuy = $pdoPayment->prepare("SELECT balance FROM payment_user WHERE uuid = :uuid");
                    $selectBalanceBuy->execute(array("uuid" => $_SESSION['uuid']));

                    $fetchBalanceBuy = $selectBalanceBuy->fetch();
                    $balanceBuy = floatval($fetchBalanceBuy['balance']);

                    // FiveMods user

                    $selectBalanceFM = $pdoPayment->prepare("SELECT balance FROM payment_user WHERE uuid = :uuid");
                    $selectBalanceFM->execute(array("uuid" => $fivemodsuuid));

                    $fetchBalanceFM = $selectBalanceFM->fetch();
                    $balanceFM = floatval($fetchBalanceFM['balance']);

                    $selectMod = $pdoPayment->prepare("SELECT p_id FROM product_log WHERE u_uuid = :uuid");
                    $selectMod->execute(array("uuid" => $_SESSION['uuid']));

                    $fetchMod = $selectMod->fetch();
                    $selMod = floatval($fetchMod['p_id']);


                    // Additional security check

                    if ($response != $balanceBuy) {
                        header('location: /account/logout/?url=error');
                        exit();
                        die();
                    }

                    $costsA = (70 / 100) * $costs;
                    $costsB = (30 / 100) * $costs;

                    if ($selMod == $mod) {

                        if ($row['premium'] == 1) {
                            $newBalance = $balance + 0.002;
                        } else {
                            $newBalance = $balance + 0.001;
                        }

                        $updateBalance = $pdoPayment->prepare("UPDATE payment_user SET balance = :balance WHERE uuid = :uuid");
                        $updateBalance->execute(array('balance' => $newBalance, 'uuid' => $row['uuid']));

                        $_SESSION['downloadMod'] = $newDownloads;
                    } else {
                        if ($row['premium'] == 1) {
                            $newBalance = $balance + $costsA + 0.002;
                            $newBalanceBuy = $balanceBuy - $costs;
                        } else {
                            $newBalance = $balance + $costsA + 0.001;
                            $newBalanceBuy = $balanceBuy - $costs;
                        }

                        $updateBalance = $pdoPayment->prepare("UPDATE payment_user SET balance = :balance WHERE uuid = :uuid");
                        $updateBalance->execute(array('balance' => $newBalance, 'uuid' => $row['uuid']));

                        $updateBalanceBuy = $pdoPayment->prepare("UPDATE payment_user SET balance = :balance WHERE uuid = :uuid");
                        $updateBalanceBuy->execute(array('balance' => $newBalanceBuy, 'uuid' => $_SESSION['uuid']));

                        $newBalanceFM = $balanceFM + $costsB;

                        $updateBalanceFM = $pdoPayment->prepare("UPDATE payment_user SET balance = :balance WHERE uuid = :uuid");
                        $updateBalanceFM->execute(array('balance' => $newBalanceFM, 'uuid' => $fivemodsuuid));

                        // Add entry to product log

                        $insertProdLog = $pdoPayment->prepare("INSERT INTO product_log (u_uuid, p_id, price) VALUES (?, ?, ?)");
                        $insertProdLog->execute(array($_SESSION['uuid'], $mod, $costs));

                        $_SESSION['downloadMod'] = $newDownloads;
                    }
                } else {
                    $_SESSION['downloadMod'] = $downloads;
                }
                $_SESSION['lastDownload'] = $mod;
            }
        }

        switch ($_GET['o']) {
            case 'product':
                session_start();
                $_SESSION['successpurchased'] = TRUE;
                header("Location: /product/$mod");
                break;
            case 'index':
                session_start();
                $_SESSION['successpurchased'] = TRUE;
                header("Location: /");
                break;
            case 'user':
                session_start();
                $_SESSION['successpurchased'] = TRUE;
                $user = $_GET['username'];
                header("Location: /user/$user");
            default:
                session_start();
                $_SESSION['successpurchased'] = TRUE;
                header("Location: /");
                break;
        }

        exit();
        die();
    }
    
}
*/