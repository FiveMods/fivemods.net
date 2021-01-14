<?php
$page_name = explode('/', str_replace('legal/', '', $_GET["page"]))[0];
if(file_exists("pages/legal/".$page_name.".php")) {
    include("pages/legal/".$page_name.".php");
} else {
    include("./error/404/404.html");
}
?>
