<?php
$page_name = explode('/', str_replace('account/', '', $_GET["page"]))[0];
if(file_exists("pages/account/".$page_name.".php")) {
    include("pages/account/".$page_name.".php");
} else {
    include("./error/404/404.html");
}
?>
