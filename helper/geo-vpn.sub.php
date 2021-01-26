<?php

require_once "./config.php";

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