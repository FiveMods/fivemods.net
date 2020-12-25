<?php
$page_name = explode('/', str_replace('payment/', '', $_GET["page"]))[0];
if(file_exists("pages/payment/".$page_name.".php")) {
    include("pages/payment/".$page_name.".php");
} else {
    include("./error/404/404.html");
}
?>
