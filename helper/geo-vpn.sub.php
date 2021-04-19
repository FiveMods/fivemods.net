<?php
function proxy_detect($null)
{
     $proxyports = array(80, 8080, 6588, 8000, 3128, 3127, 3124, 1080, 553, 554);
     for ($i = 0; $i <= count($proxyports); $i++) {
          if (@fsockopen($_SERVER['REMOTE_ADDR'], $proxyports[$i], $errstr, $errno, 0.5)) {
               $sockport = true;
          }
     }
     if (
          $_SERVER['HTTP_FORWARDED']
          || $_SERVER['HTTP_X_FORWARDED_FOR']
          || $_SERVER['HTTP_CLIENT_IP']
          || $_SERVER['HTTP_VIA']
          || $_SERVER['HTTP_XROXY_CONNECTION']
          || $_SERVER['HTTP_PROXY_CONNECTION']
          || $sockport == true
     ) {
          return true;
     } else {
          return false;
     }
}

if (proxy_detect($null) == false) {
     echo '<script>console.log("Proxy: false");</script>';
} else {
     echo '<script>console.log("Proxy: detected ('.$ip.')");</script>';
}
?>
