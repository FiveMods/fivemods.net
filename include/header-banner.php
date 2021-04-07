<?php
require_once "./config.php";
$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

$headerVals = $pdo->prepare("SELECT banner FROM user WHERE uuid = ?");
$headerVals->execute(array($_SESSION['uuid']));
if($headerVals->rowCount() > 0) {
   $hvals = $headerVals->fetch();
   $banner = $hvals['banner'];
} else {
   $banner = $css_banner;
}
?>

<style>
.fill {
    min-height: 7vh;
    transform: scale(1,1);
    overflow: hidden;
    background-size: cover;
    background-position: center;
    background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
}
</style>
<section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-light blinker fill">
    <div class="container-fluid">
       <div class="row  justify-content-center align-items-center d-flex text-center h-100">
          <div class="col-12 col-md-8 h-50">
          </div>
       </div>
    </div>
 </section>