<?php

require_once '../../../config.php';

$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password'], $mysql['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once './errors.php';

$key = getBearerToken();

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
                
            $stmt = $conn->prepare("SELECT * FROM fm_status");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            $total = 0;

            $array['main'] = $data[0]['status'];
            $array['updown'] = $data[1]['status'];
            $array['discord'] = $data[2]['status'];
            $array['google'] = $data[3]['status'];
            $array['github'] = $data[4]['status'];
            $array['advertisement'] = $data[5]['status'];
            $array['cookies'] = $data[6]['status'];
            $array['location'] = $data[7]['status'];
            $array['payment'] = $data[8]['status'];

        }

        if ($fivem == true) {
            fivemstatus();
        }

        http_response_code(200);
        $statusarray = json_encode($array);
        echo $statusarray;
        
    }
} else {
    http_response_code(400);
    echo $invalidkey;
}

function fivemstatus() {

    global $serverlist, $auth, $ingame, $website, $artifacts, $keymaster, $array;


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
    $array['artifacts'] = $artifacts;

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