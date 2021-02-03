<?php
// Statusvalues:
// 0 = Operational
// 1 = Degraded Performance
// 2 = Partial Outage
// 3 = Major Outage
// 4 = Maintenance
// 5 = Security Mode (Cloudflare)

require_once '../../../config.php';

$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password'], $mysql['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once './errors.php';

$input = file_get_contents('php://input');

$decinput = json_decode($input, TRUE, 512, JSON_BIGINT_AS_STRING);

$key = $decinput['info']['0']['key'];

if (empty($key)) {
    http_response_code(400);
    echo $invalidkey;
    die();
}

$fivemods = $decinput['status']['0']['fivemods']['0'];
$fivem = $decinput['status']['0']['fivem']['0'];
$date = date("U");
$array = array();

$stmt = $conn->prepare("SELECT * FROM status_key WHERE apikey = '$key'");
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

        if (!empty($fivemods)) {
            foreach ($decinput['status']['0']['fivemods'] as $key => $status) {
                fivemodsstatus($status);
            }
        }
        if (!empty($fivem)) {
            foreach ($decinput['status']['0']['fivem'] as $key => $status) {
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

    $stmt = $conn->prepare("SELECT * FROM fm_status WHERE status_name = '$fmcheck'");
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