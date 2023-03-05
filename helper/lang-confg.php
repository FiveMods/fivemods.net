<?php    

    require('geo-check.var.php');

    if ($_SESSION['selfselect'] == "1") {
        require_once "languages/".$_SESSION['selfselectlang'].".php";
    } else {
        $_SESSION['language'] = $countryCode;

        if ($_SESSION['language'] == "DE-DE" || $_COOKIE['language_preference'] == "DE-DE") {
            require_once "languages/DE-DE.php";
        } elseif ($_SESSION['language'] == "CH" || $_COOKIE['language_preference'] == "CH") {
            require_once "languages/DE-CH.php";
        } elseif ($_SESSION['language'] == "TW" || $_COOKIE['language_preference'] == "TW") {
            require_once "languages/ZH-TW.php";
        } elseif ($_SESSION['language'] == "CN" || $_COOKIE['language_preference'] == "CN") {
            require_once "languages/ZH-CN.php";
        } elseif ($_SESSION['language'] == "HK" || $_COOKIE['language_preference'] == "HK") {
            require_once "languages/ZH-HK.php";
        } elseif ($_SESSION['language'] == "GB" || $_COOKIE['language_preference'] == "GB") {
            require_once "languages/US.php";
        } elseif ($_SESSION['language'] == "PL" || $_COOKIE['language_preference'] == "PL") {
            require_once "languages/PL.php";
        } elseif ($_SESSION['language'] == "NL" || $_COOKIE['language_preference'] == "NL") {
            require_once "languages/NL.php";
        } elseif ($_SESSION['language'] == "NO" || $_COOKIE['language_preference'] == "NO") {
            require_once "languages/NO.php";
        } else {
            require_once "languages/US.php";
        }
    }
    
?>




