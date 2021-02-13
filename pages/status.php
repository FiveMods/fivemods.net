<?php
$page_name = explode('/', str_replace('status/', '', $_GET["page"]))[0];
if(file_exists("pages/status/".$page_name.".php")) {
    include("pages/status/".$page_name.".php");
} else {
    include("./error/404/404.html");
}
?>
