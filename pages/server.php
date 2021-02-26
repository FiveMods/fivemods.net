<?php
$page_name = explode('/', str_replace('server/', '', $_GET["page"]))[0];
if(file_exists("pages/server/".$page_name.".php")) {
    include("pages/server/".$page_name.".php");
} else {
    include("./error/404/404.html");
}
?>
