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
            <li class="nav-item mr-1">
               <a class="nav-link text-white" href="/"><?php echo $lang['home']; ?></a>
            </li>
            <li class="nav-item dropdown has-megamenu">
               <a class="nav-link text-white dropdown-toggle" href="#" data-toggle="dropdown"> <?php echo $lang['categories']; ?> </a>
               <div class="dropdown-menu megamenu <?php echo $darkmode; ?>" role="menu">
                  <div class="row">
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Scripts&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['scripts']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Scripts' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Scripts&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Vehicles&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['vehicles']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Vehicles' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Vehicles&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Weapons&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['weapons']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Weapons' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Weapons&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Peds&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['peds']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Peds' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Peds&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Maps&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['maps']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Maps' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Maps&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Liveries&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['liveries']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Liveries' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Liveries&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <div class="col-md-navbar">
                        <div class="col-megamenu">
                           <h5 class="title"><a href="/search/?query=Misc&cat=1&submit-search=" class="heading-navbar <?php echo $css_text; ?>"><?php echo $lang['misc']; ?></a></h5>
                           <ul class="list-unstyled">
                              <?php
                              $sql = "SELECT * FROM tags WHERE category = 'Misc' ORDER BY tag ASC";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                 while ($row = $result->fetch_assoc()) {
                                    $tag = $row["tag"];
                                    echo '<li><a href="/search/?query=' . urlencode($tag) . '&cat=1&catset=Misc&submit-search=">' . $tag . '</a></li>';
                                 }
                              }
                              ?>
                           </ul>
                        </div>
                     </div>
                     <!-- end Categories -->
                  </div>
                  <!-- end row -->
               </div>
               <!-- End Dropdown Menu -->
            </li>
            <div class="nav-item dropdown show">
               <a class="nav-link text-white dropdown-toggle" style="color:rgba(255, 255, 255, 0.5);" href="#" id="dropdownMenuLinkCommunity" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $lang['community']; ?>
               </a>

               <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkCommunity">
                  <a class="dropdown-item" href="/partner-program/"><?php echo $lang['partner-program']; ?></a>
                  <a class="dropdown-item" href="/famous-creator/"><?php echo $lang['famous-creator']; ?></a>
                  <a class="dropdown-item" href="/help-center/"><?php echo $lang['help-center']; ?></a>
                  <a class="dropdown-item" href="/user/"><?php echo $lang['all-user']; ?></a>
                  <a class="dropdown-item" href="/status/"><?php echo $lang['status']; ?></a>
                  <a class="dropdown-item" href="/affiliate/">Affiliate</a>
               </div>
            </div>
            <!-- <div class="nav-item dropdown show">
                     <a class="nav-link dropdown-toggle" style="color:rgba(255, 255, 255, 0.5);" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <?php echo $lang['other-services']; ?>
                     </a>

                     <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="/title-maker/"><?php echo $lang['title-maker']; ?></a>
                        <a class="dropdown-item" href="/server-list/"><?php echo $lang['server-list']; ?></a>
                        <a class="dropdown-item" href="/server-exchange/"><?php echo $lang['server-exchange']; ?></a>
                        <a class="dropdown-item" href="/server-staff/"><?php echo $lang['server-staff']; ?></a>
                        <a class="dropdown-item" href="/application-program/"><?php echo $lang['application-program']; ?></a>
                        <a class="dropdown-item" href="/unisync/"><s><?php echo $lang['unisync']; ?></s></a>
                     </div>
                  </div> -->
            <div class="nav-item dropdown show">
               <a class="nav-link text-white dropdown-toggle" style="color:rgba(255, 255, 255, 0.5);" href="#" id="dropdownMenuLinkFiveM" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $lang['fivem-stuff']; ?> Links
               </a>

               <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkFiveM">
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://fivem.net"><?php echo $lang['fivem-download'] ?></a>
                  <hr>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://github.com/tabarra/txAdmin"><?php echo $lang['fivem-txadmin'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://runtime.fivem.net/artifacts/fivem/build_proot_linux/master/"><?php echo $lang['fivem-art-lin'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://runtime.fivem.net/artifacts/fivem/build_server_windows/master/"><?php echo $lang['fivem-art-win'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://keymaster.fivem.net/"><?php echo $lang['fivem-keymaster'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://fivem.net"><?php echo $lang['fivem-website'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://discord.com/invite/fivem"><?php echo $lang['fivem-discord'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://docs.fivem.net/docs/"><?php echo $lang['fivem-docs'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://forum.cfx.re/"><?php echo $lang['fivem-forum'] ?></a>
                  <a class="dropdown-item" href="https://fivemods.net/ref/?rdc=https://runtime.fivem.net/fivem-service-agreement-4.pdf"><?php echo $lang['terms-of-service'] ?></a>
               </div>
            </div>
         </span>
         <?php

         if (!empty($_COOKIE['f_val']) && !empty($_COOKIE['f_key'])) {
            echo '<form action="/upload/" method="post"><button type="submit" class="btn btn-outline-primary rounded mr-3"><i class="fas fa-cloud-upload-alt mr-1"></i>' . $lang['upload'] . '</button></form>';
         } else {
            echo '<form action="/account/sign-in/" method="post"><button type="submit" class="btn btn-outline-primary rounded mr-3"><i class="fas fa-cloud-upload-alt mr-1"></i>' . $lang['upload'] . '</button></form>';
         }

         ?>
         <form id="demo-2" action="/search/" method="GET">
            <div class="ui-widget">
               <input name="query" class="btn btn-outline-primary rounded" id="query" type="search" placeholder="Search">
               <label for="query"></label>
               <button type="submit" name="submit-search" hidden></button>
            </div>
         </form>
         <?php

         if (empty($_COOKIE['f_val']) && empty($_COOKIE['f_key'])) {
            echo '<span class="nav navbar-nav navbar-right">
                  <form action="/account/sign-in/" method="post">
                  <button type="submit" class="btn btn-outline-primary rounded"><i class="fas fa-sign-in-alt"></i> ' . $lang['log-in'] .' <span class="caret"></span></button>
                  </form>
               </span>';
         } else {
            echo '<form action="/account/" method="post">
                  <button type="submit" class="btn btn-outline-primary rounded"><i class="fas fa-user-edit"></i> ' . $lang['edit-profile'] . ' <span class="caret"></span></button></form>
                  </form>';
            echo '<form action="/account/logout/" method="post" class="pl-1">
                  <button type="submit" class="btn btn-primary rounded"><i class="fas fa-sign-out-alt"></i> ' . $lang['log-out'] . '<span class="caret"></span></button>
                  <input type="text" name="currentPage" value="' . $currentPage . '" hidden>
                  </form>';
         }
         ?>
      </div>
   </div>
   </div>
</nav>