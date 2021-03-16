<?php
session_start();

require_once '../../../config.php';

if (empty($_SESSION['uuid'])) {
   // header('location: /logout');
   echo 'e<br>';
} else {
    echo $_SESSION['uuid'] . ' <- is the uuid<br>';
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    //header('location: /');
    exit();
} else {

    $conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password'], $mysql['dbname']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM status_key WHERE uuid = :uuid AND active = 1");
    $stmt->execute(array('uuid' => $_SESSION['uuid']));
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $api_key = $row['apikey'];
            $stmt = $conn->prepare("UPDATE status_key SET active = 0 WHERE apikey = :apikey");
            $stmt->execute(array('apikey' => $api_key));
        }
    }

    

    $inp_exp = htmlspecialchars($_POST['key-exp']);
    $date = date("U");
    $key_exp = $inp_exp + $date;
    $userid = htmlspecialchars($_POST['id']);
    $api_key = rand_string(20);
    $active = 1;

    $stmt = $conn->prepare("INSERT INTO status_key (uuid, apikey, expiration_date, active) VALUES (:uuid, :apikey, :keyexp, :active)");
    $stmt->execute(array('uuid' => $_SESSION['uuid'], 'apikey' => $api_key, 'keyexp' => $key_exp, 'active' => $active));

    $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully requested! </strong> Please read the documentation on how to use it.
    </div>
    ';
    header('location: /account/');

}

function rand_string($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 

?>
