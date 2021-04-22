<?php
// Create connection
require_once('config.php');
$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password'], $mysql['dbname']);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$rdc = $CurPageURL;

$currentPage = $_GET['page'];

?>
<style>

.fmrounded {
   border-radius: 17px;
}

</style>
<nav class="navbar navbar-expand-lg navbar-dark f-bg-dark fixed-top">
   <div class="container">
      <a class="navbar-brand mr-4" href="/">
         <img src="https://fivemods.net/static-assets/img/svg/brand/svg/fivemods_brand_text_primary_white_280x100.svg" loading="lazy" alt="fivemods_brand_text_primary_white_280x100_header_normal" width="112px" height="40px">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
         <span class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownLbl" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Community </a>
               <div class="dropdown-menu dropdown-menu-right w-auto shadow p-0" id="navbarDropdown" aria-labelledby="navbarDropdownLbl">
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/partner-program/">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['partner-program']; ?></h5> Join our partner program to benefit.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/famous-creator/">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['famous-creator']; ?></h5> Check the popularist users and mods.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/help-center/">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['help-center']; ?></h5> Any questions, visit the help center.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/user/">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['all-user']; ?></h5> Interested in our community? Visit our users.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/status/">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['status']; ?></h5> Check the FiveM and FiveMods status.
                     </div>
                  </a>
               </div>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownLbl" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $lang['fivem-stuff']; ?> Links </a>
               <div class="dropdown-menu dropdown-menu-right w-auto shadow p-0" id="navbarDropdown" aria-labelledby="navbarDropdownLbl">
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://fivem.net?trace=fivemods.net">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-download'] ?></h5> Download FiveM from the official website.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://github.com/tabarra/txAdmin">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-txadmin'] ?></h5> The official txAdmin GitHub repositories.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://runtime.fivem.net/artifacts/fivem/build_proot_linux/master/?trace=fivemods.net">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-art-lin'] ?></h5> Download the official FiveM linux artifacts.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://runtime.fivem.net/artifacts/fivem/build_server_windows/master/?trace=fivemods.net">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-art-win'] ?></h5> Download the official FiveM windows artifacts.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://keymaster.fivem.net/?trace=fivemods.net">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-keymaster'] ?></h5> Register an official FiveM keymaster.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://www.fivem.net/?trace=fivemods.net">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-website'] ?></h5> The official FiveM website.
                     </div>
                  </a>
                  <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/ref/?rdc=https://discord.com/invite/fivem">
                     <div class="flex-shrink-1 text-center px-2"></div>
                     <div class="pl-0 pr-4">
                        <h5 class="mb-0"><?php echo $lang['fivem-discord'] ?></h5> The official FiveM discord.
                     </div>
                  </a>
               </div>
            </li>
         </span>
         <?php

         if (!empty($_COOKIE['f_val']) && !empty($_COOKIE['f_key'])) {
            echo '<form action="/upload/" method="post"><button type="submit" class="btn btn-outline-primary fmrounded mr-3"><i class="fas fa-cloud-upload-alt mr-1"></i>' . $lang['upload'] . '</button></form>';
         } else {
            echo '<form action="/account/sign-in/" method="post"><button type="submit" class="btn btn-outline-primary fmrounded mr-3"><i class="fas fa-cloud-upload-alt mr-1"></i>' . $lang['upload'] . '</button></form>';
         }

         ?>
         <form id="demo-2" action="/search/" method="GET">
            <div class="ui-widget">
               <input name="query" class="btn btn-outline-primary fmrounded" id="query" type="search" placeholder="Search">
               <label for="query"></label>
               <button type="submit" name="submit-search" hidden></button>
            </div>
         </form>
         <?php

         require_once('./config.php');

         $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

         $getV = $pdo->prepare("SELECT * FROM user WHERE uuid = ?");
         $getV->execute(array($_SESSION['uuid']));
         $res = $getV->fetch();
                  
         if (empty($_COOKIE['f_val']) && empty($_COOKIE['f_key'])) {
            echo '<span class="nav navbar-nav navbar-right">
                  <form action="/account/sign-in/" method="post">
                  <button type="submit" class="btn btn-outline-primary fmrounded"><i class="fas fa-sign-in-alt"></i> ' . $lang['log-in'] . ' <span class="caret"></span></button>
                  </form>
               </span>';
         } else {
            echo '<span class="dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navProfileFM1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img src="https://img-cdn.fivemods.net/unsafe/35x35/filters:format(webp):quality(100):sharpen(0.2,0.5,true)/'.$res['picture'].'" class="img-fluid rounded" alt="'.$res['name'].'-Profile Picture"></img> '.$res['name'].'</a>
            <div class="dropdown-menu dropdown-menu-right w-auto shadow p-0" id="navbarDropdown" aria-labelledby="navProfileFM1">
               <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/account/">
                  <div class="flex-shrink-1 text-center px-2"></div>
                  <div class="pl-0">
                     <h5 class="mb-0"><i class="fas fa-user-cog pr-2"></i> Settings</h5>
                  </div>
               </a>
               <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/user/'.$res['name'].'/">
                  <div class="flex-shrink-1 text-center px-2"></div>
                  <div class="pl-0">
                     <h5 class="mb-0"><i class="far fa-user pr-2"></i> My profile</h5>
                  </div>
               </a>
               <a class="dropdown-item d-flex flex-nowrap align-items-center px-0 py-3" href="/logout/">
                  <div class="flex-shrink-1 text-center px-2"></div>
                  <div class="pl-0">
                     <h5 class="mb-0"><i class="fas fa-sign-out-alt pr-2"></i> Logout</h5>
                  </div>
               </a>
            </div>
         </span>';
         }

         // else {
         //    echo '<form action="/account/" method="post">
         //          <button type="submit" class="btn btn-outline-primary fmrounded"><i class="fas fa-user-edit"></i> ' . $lang['edit-profile'] . ' <span class="caret"></span></button></form>
         //          </form>';
         //    echo '<form action="/account/logout/" method="post" class="pl-1">
         //          <button type="submit" class="btn btn-primary fmrounded"><i class="fas fa-sign-out-alt"></i> ' . $lang['log-out'] . '<span class="caret"></span></button>
         //          <input type="text" name="currentPage" value="' . $currentPage . '" hidden>
         //          </form>';
         // }
         ?>
      </div>
   </div>
   </div>
</nav>