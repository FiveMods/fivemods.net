<?php

require_once "./config.php";

$ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);

$key = $ipQaToken;
$strictness = 1;
$result = json_decode(file_get_contents(sprintf('https://ipqualityscore.com/api/json/ip/%s/%s?strictness=%s', $key, $ip, $strictness)), true);
if ($result !== null) {
    if (isset($result['proxy']) && $result['proxy'] == true) {
        header('location: /error/proxy/?ident=3');
        exit();       
        die();
    }
}
?>