<?php

function detectLang() {
    include('./geo-check.var.php');

    if ($countryCode == "DE") {
        $cookie_name = "FM_lang";
        $cookie_value = "John Doe";
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
        header('location: ?lang=de-DE');
    } else {
        header('location: ?lang=en-US');
    }

}

?>