<?php    

    require('geo-check.var.php');

    if ($_SESSION['selfselect'] == "1") {
        require_once "languages/".$_SESSION['selfselectlang'].".php";
    } else {
        $_SESSION['language'] = $countryCode;

        if ($_SESSION['language'] == "DE-DE") {
            require_once "languages/DE-DE.php";
        } elseif ($_SESSION['language'] == "CH") {
            require_once "languages/DE-CH.php";
        } elseif ($_SESSION['language'] == "TW") {
            require_once "languages/ZH-TW.php";
        } elseif ($_SESSION['language'] == "CN") {
            require_once "languages/ZH-CN.php";
        } elseif ($_SESSION['language'] == "HK") {
            require_once "languages/ZH-HK.php";
        } elseif ($_SESSION['language'] == "GB") {
            require_once "languages/US.php";
        } elseif ($_SESSION['language'] == "PL") {
            require_once "languages/PL.php";
        } elseif ($_SESSION['language'] == "NL") {
            require_once "languages/NL.php";
        } elseif ($_SESSION['language'] == "NO") {
            require_once "languages/NO.php";
        } else {
            require_once "languages/US.php";
        }
    }
    
?>




