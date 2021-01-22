<?php 
if (!isset($_GET['uid']) && !isset($_GET['uname'])) {
   include('./include/user-userlist.php');
} else {
   include('./include/user-userview.php');
}
?>