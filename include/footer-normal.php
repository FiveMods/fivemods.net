<section class="mb-0 mt-0">
   <div class="footer text-white">
      <div class="bg-dark pt-5 pb-5">
         <div class="container">
            <div class="row border-bottom">
               <div class="col-xs-6 col-sm-3">
                  <span class="text text-primary">
                     <a href="/">
                        <img async=on src="<?php echo $brand_side; ?>" width="163.5px" height="56px" alt="FiveMods Logo">
                     </a>
                  </span>
                  <address class="color-light-20 mt-3">
                     <?php echo $lang['footer-infotext']; ?>
                  </address>
                  <a href="mailto:fivemods.management@gmail.com">fivemods.management@gmail.com</a>
                  <small class="text text-muted">v0.7.46-a.1</small>
               </div>
               <div class="col-xs-6 col-sm-3">
                  <h4 class="my-2"><?php echo $lang['legal']; ?></h4>
                  <ul class="list-unstyled list-light">
                     <li>
                        <a href="/about-us/"><?php echo $lang['about-us']; ?></a>
                     </li>
                     <li>
                        <a href="/contact/"><?php echo $lang['contact']; ?></a>
                     </li>
                     <li>
                        <a href="/privacy-policy/"><?php echo $lang['privacy-policy']; ?></a>
                     </li>
                     <li>
                        <a href="/terms-of-service/"><?php echo $lang['terms-of-service']; ?></a>
                     </li>
                     <li>
                        <a href="/legal-notice/"><?php echo $lang['legal-notice']; ?></a>
                     </li>
                     <li>
                        <a href="/cookie-consent/"><?php echo $lang['cookie-consent']; ?></a>
                     </li>
                     <li>
                        <a href="/status/"><?php echo $lang['status']; ?></a>
                     </li>
                     <li>
                        <a href="/advertisement/"><?php echo $lang['advertisement']; ?></a>
                     </li>
                     <li>
                        <a href="/upload-policy/"><?php echo $lang['upload-policy']; ?></a>
                     </li>
                     <li>
                        <a href="/account-policy/">Account Policy</a>
                     </li>
                     <?php
                     if ($_SESSION['language'] == "DE") {
                        echo '<li>
                              <a href="/impressum/">Impressum</a>
                           </li>';
                     }
                     ?>
                  </ul>
               </div>
               <br style="clear:both" class="hidden-sm-up">
               <div class="col-xs-6 col-sm-3">
                  <h4 class="my-2"><?php echo $lang['categories']; ?></h4>
                  <ul class="list-unstyled list-light">
                     <li>
                        <a href="/search/?query=Scripts&cat=1&submit-search="><?php echo $lang['scripts']; ?></a>
                     </li>
                     <li>
                        <a href="/search/?query=Vehicles&cat=1&submit-search="><?php echo $lang['vehicles']; ?></a>
                     </li>
                     <li>
                        <a href="/search/?query=Weapons&cat=1&submit-search="><?php echo $lang['weapons']; ?></a>
                     </li>
                     <li>
                        <a href="/search/?query=Peds&cat=1&submit-search="><?php echo $lang['peds']; ?></a>
                     </li>
                     <li>
                        <a href="/search/?query=Maps&cat=1&submit-search="><?php echo $lang['maps']; ?></a>
                     </li>
                     <li>
                        <a href="/search/?query=Liveries&cat=1&submit-search="><?php echo $lang['liveries']; ?></a>
                     </li>
                     <li>
                        <a href="/search/?query=Misc&cat=1&submit-search="><?php echo $lang['misc']; ?></a>
                     </li>
                  </ul>
               </div>
               <div class="col-xs-6 col-sm-3">
                  <h4 class="my-2"><?php echo $lang['community']; ?></h4>
                  <ul class="list-unstyled list-light">
                     <li>
                        <a href="/login/"><?php echo $lang['log-in']; ?></a>
                     </li>
                     <?php
                     if (!empty($_SESSION['g_id']) || !empty($_SESSION['dc_id'])) {
                        echo '<li><a href="/upload/"></i>' . $lang['upload'] . '</a></li>';
                     } else {
                        echo '<li><a href="/account/sign-in/">' . $lang['upload'] . '</a></li>';
                     }
                     ?>
                     <li>
                        <a href="/famous-creator/"><?php echo $lang['famous-creator']; ?></a>
                     </li>
                     <li>
                        <a href="/partner-program/"><?php echo $lang['partner-program']; ?></a>
                     </li>
                     <li>
                        <a href="/help-center/"><?php echo $lang['help-center']; ?></a>
                     </li>
                     <li>
                        <div class="dropup">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">Design
                              <span class="caret"></span></a>
                           <ul class="dropdown-menu bg-dark border-light pl-4">
                              <li><a href="#" onclick="swapStyleSheet('/static-assets/css-dark/style.css');document.cookie = 'fm_design=normal; expires=Sat, 31 Dec 1970 00:00:00 GMT';document.cookie = 'fm_design=dark; expires=Sat, 31 Dec 2022 00:00:00 GMT';"><i class="fas fa-moon"></i> Darkmode</a></li>
                              <li><a href="#" onclick="swapStyleSheet('/static-assets/css/style.css');document.cookie = 'fm_design=dark; expires=Sat, 31 Dec 1970 00:00:00 GMT';document.cookie = 'fm_design=normal; expires=Sat, 31 Dec 2022 00:00:00 GMT';"><i class="fas fa-sun"></i> Lightmode</a></li>
                           </ul>
                        </div>
                     </li>
                     <li>
                        <a href="/language/"><?php echo $lang['language']; ?></a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="row f-flex justify-content-between" style="justify-content: space-between;">
               <div class="col-md-8 text-xs-center text-left text-secondary my-1" style="line-height: 90%;">
                  <p class="mt-3 text-white"><?php echo $lang['copyright']; ?><br>
                     <br>
                     <span style="font-size:8px;"><?php echo $lang['footer-subtext']; ?>.
                        FiveM™ is © 2016-2020 by the CitizenFX Collective.
                        FiveM is a registered trademark of ZAP-Hosting GmbH & Co. KG in the European Union and is used under license.
                     </span>
                  <p style="font-size:8px;" class="text text-muted">Session: <?php echo session_id() ?>, Country: <?php echo $_SESSION['language']; ?>, IP: <?php echo $ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']); ?>, Server node-01, URL: <?php echo $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                  </p>
                  </p>
               </div>
               <div class="col-md-4 text-xs-center text-lg-right text-secondary my-1">
                  <div class="btn-container  mt-1 text-md-right text-sm-center">
                     <div class="mb-1 mr-3 align-self-right pt-0 d-inline-block">
                        <a href="//www.dmca.com/Protection/Status.aspx?ID=1f03d338-c77e-44b8-9667-1c4879aa78af" title="DMCA.com Protection Status" class="dmca-badge"> <img async=on src="https://images.dmca.com/Badges/dmca-badge-w100-5x1-08.png?ID=1f03d338-c77e-44b8-9667-1c4879aa78af" width="100px" height="20px" alt="DMCA.com Protection Status" /></a>
                        <a href="/ref?rdc=https://discord.com/invite/AGvh9HX" role="button" class="text-white p-1 m-1 btn btn-rised btn-round btn-icon btn-primary" style="font-size:17px;" title="FiveMods Discord Server">
                           <i class="fab fa-discord fa-lg" aria-hidden="true"></i>
                        </a>
                        <a href="/ref?rdc=https://twitter.com/five_mods" role="button" class="text-white p-1 m-1 btn btn-round btn-rised btn-icon btn-primary" style="font-size:17px;" title="FiveMods Twitter Account">
                           <i class="fab fa-twitter fa-lg" aria-hidden="true"></i>
                        </a>
                        <a href="/ref?rdc=https://www.instagram.com/officialfivemods/" role="button" class="text-white p-1 m-1 btn btn-round btn-rised btn-icon btn-primary" style="font-size:17px;" title="FiveMods Instagram Account">
                           <i class="fab fa-instagram fa-lg" aria-hidden="true"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>