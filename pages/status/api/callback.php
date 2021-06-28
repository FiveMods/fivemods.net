<?php

require_once '../../../config.php';

$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password'], $mysql['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once './errors.php';

$key = getBearerToken();

$status_array =
      array (
        'fivemods' => 
        array (
          0 => 'main',
          1 => 'updown',
          2 => 'discord',
          3 => 'google',
          4 => 'github',
          5 => 'advertisement',
          6 => 'cookies',
          7 => 'location',
          8 => 'payment',
        ),
        'fivem' => 
        array (
          0 => 'serverlist',
          1 => 'auth',
          2 => 'ingame',
          3 => 'website',
          4 => 'artifacts',
          5 => 'keymaster',
        ),
    );

$fivemods = $_GET['fivemods'];
$fivem = $_GET['fivem'];
$date = date("U");
$array = array();

$stmt = $conn->prepare("SELECT * FROM status_key WHERE apikey = ?");
$stmt->bind_param("s", $key);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $checkkey = $row['apikey'];
        $exdate = $row['expiration_date'];
        $active = $row['active'];
    }
    if ($checkkey != $key || $date > $exdate || $active == 0) {
        http_response_code(400);
        echo $invalidkey;
    } else {
        // Get all status and send it
        if (empty($fivemods) && empty($fivem)) {
            http_response_code(400);
            echo $nostatus;
        }

        if ($fivemods == true) {
            foreach ($status_array['fivemods'] as $key => $status) {
                fivemodsstatus($status);
            }
        }
        if ($fivem == true) {
            foreach ($status_array['fivem'] as $key => $status) {
                fivemstatus($status);
            }
        }

        http_response_code(200);
        $statusarray = json_encode($array);
        echo $statusarray;
        
    }
} else {
    http_response_code(400);
    echo $invalidkey;
}

function fivemodsstatus($fmcheck) {
    
    global $conn, $main, $updown, $discord, $google, $github, $advertisement, $cookies, $location, $payment, $array;

    $stmt = $conn->prepare("SELECT * FROM fm_status WHERE status_name = ?");
    $stmt->bind_param("s", $fmcheck);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($fmcheck == 'main') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $main = $row['status'];
            }
            $array['main'] = $main;
        }
    } elseif ($fmcheck == 'updown') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $updown = $row['status'];
            }
            $array['updown'] = $updown;
        }
    } elseif ($fmcheck == 'discord') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $discord = $row['status'];
            }
            $array['discord'] = $discord;
        }
    } elseif ($fmcheck == 'google') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $google = $row['status'];
            }
            $array['google'] = $google;
        }
    } elseif ($fmcheck == 'github') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $github = $row['status'];
            }
            $array['github'] = $github;
        }
    } elseif ($fmcheck == 'advertisement') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $advertisement = $row['status'];
            }
            $array['advertisement'] = $advertisement;
        }
    } elseif ($fmcheck == 'cookies') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $cookies = $row['status'];
            }
            $array['cookies'] = $cookies;
        }
    } elseif ($fmcheck == 'location') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $location = $row['status'];
            }
            $array['location'] = $location;
        }
    } elseif ($fmcheck == 'payment') {
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $payment = $row['status'];
            }

            $array['payment'] = $payment;
        }
    }
}

function fivemstatus($fcheck) {

    global $serverlist, $auth, $ingame, $website, $artifacts, $keymaster, $array;

    if ($fcheck == 'serverlist') {

        $url = 'https://servers.fivem.net/servers';

        $headers = @get_headers($url); 

        if ($headers && strpos( $headers[0], '200')) {
            $serverlist = 0;
        } elseif ($headers && strpos( $headers[0], '302')) {
            $serverlist = 1;
        } elseif ($headers && strpos( $headers[0], '403')) {
            $serverlist = 5;
        } else {
            $serverlist = 3;
        }
        $array['serverlist'] = $serverlist;

    } elseif ($fcheck == 'auth') {

        $url = 'https://fivem.net';

        $headers = @get_headers($url);
        if ($headers && strpos( $headers[0], '200')) {
            $auth = 0;
        } elseif ($headers && strpos( $headers[0], '302')) {
            $auth = 1;
        } elseif ($headers && strpos( $headers[0], '403')) {
            $auth = 5;
        } else {
            $auth = 3;
        }
        $array['auth'] = $auth;

    } elseif ($fcheck == 'ingame') {

        $url = 'https://fivem.net';

        $headers = @get_headers($url); 
        if ($headers && strpos( $headers[0], '200')) {
            $ingame = 0;
        } elseif ($headers && strpos( $headers[0], '302')) {
            $ingame = 1;
        } elseif ($headers && strpos( $headers[0], '403')) {
            $ingame = 5;
        } else {
            $ingame = 3;
        }
        $array['ingame'] = $ingame;

    } elseif ($fcheck == 'website') {

        $url = 'https://fivem.net';

        $headers = @get_headers($url); 
        if ($headers && strpos( $headers[0], '200')) {
            $website = 0;
        } elseif ($headers && strpos( $headers[0], '302')) {
            $website = 1;
        } elseif ($headers && strpos( $headers[0], '403')) {
            $website = 5;
        } else {
            $website = 3;
        }
        $array['website'] = $website;

    } elseif ($fcheck == 'artifacts') {

        $url = 'https://runtime.fivem.net/artifacts/fivem/';

        $headers = @get_headers($url); 
        if ($headers && strpos( $headers[0], '200')) {
            $artifacts = 0;
        } elseif ($headers && strpos( $headers[0], '302')) {
            $artifacts = 1;
        } elseif ($headers && strpos( $headers[0], '403')) {
            $artifacts = 5;
        } else {
            $artifacts = 3;
        }
        $array['artifacts'] = $artifacts
        ;
    } elseif ($fcheck == 'keymaster') {

        $url = 'https://keymaster.fivem.net';

        $headers = @get_headers($url); 
        if ($headers && strpos( $headers[0], '200')) {
            $keymaster = 0;
        } elseif ($headers && strpos( $headers[0], '302')) {
            $keymaster = 1;
        } elseif ($headers && strpos( $headers[0], '403')) {
            $keymaster = 5;
        } else {
            $keymaster = 3;
        }
        $array['keymaster'] = $keymaster;
    }
    
}


function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

function getBearerToken() {
$headers = getAuthorizationHeader();
// HEADER: Get the access token from the header
if (!empty($headers)) {
    if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        return $matches[1];
    }
}
return null;
}