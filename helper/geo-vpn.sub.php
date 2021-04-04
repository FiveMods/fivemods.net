<?php

require_once "./config.php";

$ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);

$ports = array(8080,80,81,1080,6588,8000,3128,553,554,4480);
    foreach($ports as $port) {
         if (@fsockopen($_SERVER['REMOTE_ADDR'], $port, $errno, $errstr, 30)) {
              die("You are using a proxy!");
         }
     }
?>