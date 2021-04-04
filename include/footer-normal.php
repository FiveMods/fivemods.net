<section class="mb-0 mt-5">
   <div class="footer text-white">
      <div class="pt-5 pb-5 f-bg-dark">
         <div class="container">
            <div class="row">
               <div class="col-xs-6 col-sm-3">
                  <a href="#">
                     <img src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(100)/https://www.fivemods.net/static-assets/img/brand-side.png" height="40px" alt="">
                  </a>
                  <hr style="background-color:#605f62;margin-right:25%;margin-top:10%;">
                  <address class="color-light-20 mt-4">
                     <a href="mailto://contact@fivemods.net" style="color:lightgray;">contact@fivemods.net</a>
                  </address>
                  <small style="color:#605f62;">live production <a href="/ref?rdc=https://github.com/FiveMods/fivemods.net/releases/tag/v1.1.05-a.1">v1.1.0.5-a.1</a></small>
               </div>
               <div class="col-xs-6 col-sm-3">
                  <h4 class="my-2"><?php echo $lang['about-us']; ?></h4>
                  <ul class="list-unstyled list-light">
                     <?php 
                     
                     if ($_SESSION['language'] == "DE" || $_SESSION['language'] == "DE-DE" || $_SESSION['language'] == "de-DE") {
                        echo '<li>
                        <a href="/impressum/">Impressum</a>
                     </li>';
                     }

                     ?>
                     <li>
                        <a href="/legal/"><?php echo $lang['legal-notice']; ?></a>
                     </li>
                     <li>
                        <a href="/status/"><?php echo $lang['status']; ?></a>
                     </li>
                     <li>
                        <a href="/advertisement/"><?php echo $lang['advertisement']; ?></a>
                     </li>
                     <li>
                        <a href="/help-center/"><?php echo $lang['help-center']; ?></a>
                     </li>
                     <li>
                        <a href="/about-us/"><?php echo $lang['about-us']; ?></a>
                     </li>
                  </ul>
               </div>
               <br style="clear:both" class="hidden-sm-up">
               <div class="col-xs-6 col-sm-3">
                  <h4 class="my-2"><?php echo $lang['categories']; ?></h4>
                  <ul class="list-unstyled list-light">
                     <li>
                        <a href="#"><?php echo $lang['scripts']; ?></a>
                     </li>
                     <li>
                        <a href="#"><?php echo $lang['vehicles']; ?></a>
                     </li>
                     <li>
                        <a href="#"><?php echo $lang['weapons']; ?></a>
                     </li>
                     <li>
                        <a href="#"><?php echo $lang['peds']; ?></a>
                     </li>
                     <li>
                        <a href="#"><?php echo $lang['maps']; ?></a>
                     </li>
                     <li>
                        <a href="#"><?php echo $lang['liveries']; ?></a>
                     </li>
                     <li>
                        <a href="#"><?php echo $lang['misc']; ?></a>
                     </li>
                  </ul>
               </div>
               <div class="col-xs-6 col-sm-3">
                  <h4 class="my-2"><?php echo $lang['community']; ?></h4>
                  <ul class="list-unstyled list-light">
                     <li>
                        <a href="/account/sign-in/"><?php echo $lang['log-in']; ?></a>
                     </li>
                     <li>
                        <a href="/user/"><?php echo $lang['all-user']; ?></a>
                     </li>
                     <li>
                        <a href="/affiliate/">Affiliate</a>
                     </li>
                     <li>
                        <a href="/partner-program/"><?php echo $lang['partner-program']; ?></a>
                     </li>
                     <li>
                        <a href="/famous-creator/"><?php echo $lang['famous-creator']; ?></a>
                     </li>
                  </ul>
               </div>
            </div>
            <hr style="background-color:#605f62;">
            <div class="row f-flex justify-content-between" style="justify-content: space-between;">
               <div class="col-md-8 text-xs-center  text-left text-secondary my-1">
                  <p class="mt-2  text-white"><?php echo $lang['copyright']; ?></p>
                  <small class="fst"><?php echo $lang['footer-subtext']; ?>. FiveM&#174; is &copy; 2016-<?php echo date("Y"); ?> by Cfx.re. <br> FiveMods.net distances itself from fivemods.de and its activities! </small>
               </div>
               <div class="col-md-4 text-xs-center text-lg-right text-secondary my-1">
                  <div class="btn-container  mt-1 text-md-right text-sm-center">
                     <div class="mb-1 mr-3 align-self-right pt-0 d-inline-block">
                        <a href="/discord/" role="button" title="Discord" class="text-white rounded m-2">
                           <i class="fab fa-discord fa-lg color-light" aria-hidden="true"></i>
                        </a>
                        <a href="/ref?rdc=https://twitter.com/FiveModsNET" title="Twitter" role="button" class="text-white rounded m-2">
                           <i class="fab fa-twitter fa-lg color-light" aria-hidden="true"></i>
                        </a>
                        <a class="dropdown-toggle text-white mr-2" title="Language select" id="languages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-<?php 
                        

                        if (strpos($_COOKIE['language_preference'], "ZH-") !== FALSE) {
                           $lowercaseLang = strtolower($_COOKIE['language_preference']);
                           if ($lowercaseLang == "zh-tw") {
                              echo 'tw';
                           } elseif ($lowercaseLang == "zh-cn") {
                              echo 'cn';
                           } elseif ($lowercaseLang == "zh-hk") {
                              echo 'hk';
                           }
                        } elseif (strpos($_COOKIE['language_preference'], "DE-") !== FALSE) {
                           $lowercaseLang = strtolower($_COOKIE['language_preference']);
                           if ($lowercaseLang == "de-de") {
                              echo 'de';
                           } elseif ($lowercaseLang == "de-ch") {
                              echo 'ch';
                           }
                        } elseif (!empty($_COOKIE['language_preference'])) {
                           echo strtolower($_COOKIE['language_preference']);
                        } else {
                           echo 'us';
                        }

                        ?>"> </span></a>
                        <div class="dropdown-menu" aria-labelledby="languages">
                           <a class="dropdown-item" href="/language/?is=DE&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['de-de']; ?>"><span class="flag-icon flag-icon-de"> </span> <?php echo $lang['de-de']; ?></a>
                           <a class="dropdown-item" href="/language/?is=CH&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['de-ch']; ?>"><span class="flag-icon flag-icon-ch"> </span> <?php echo $lang['de-ch']; ?></a>
                           <a class="dropdown-item" href="/language/?is=NL&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['nl-nl']; ?>"><span class="flag-icon flag-icon-nl"> </span> <?php echo $lang['nl-nl']; ?></a>
                           <a class="dropdown-item" href="/language/?is=GB&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['en-gb']; ?>"><span class="flag-icon flag-icon-gb"> </span> <?php echo $lang['en-gb']; ?></a>
                           <a class="dropdown-item" href="/language/?is=NO&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['no-no']; ?>"><span class="flag-icon flag-icon-no"> </span> <?php echo $lang['no-no']; ?></a>
                           <a class="dropdown-item" href="/language/?is=PL&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['pl-pl']; ?>"><span class="flag-icon flag-icon-pl"> </span> <?php echo $lang['pl-pl']; ?></a>
                           <a class="dropdown-item" href="/language/?is=US&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['en-us']; ?>"><span class="flag-icon flag-icon-us"> </span> <?php echo $lang['en-us']; ?></a>
                           <a class="dropdown-item" href="/language/?is=CN&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['cn-cn']; ?>"><span class="flag-icon flag-icon-cn"> </span> <?php echo $lang['cn-cn']; ?></a>
                           <a class="dropdown-item" href="/language/?is=HK&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['hk-hk']; ?>"><span class="flag-icon flag-icon-hk"> </span> <?php echo $lang['hk-hk']; ?></a>
                           <a class="dropdown-item" href="/language/?is=TW&callbackURI=<?php echo $_SERVER['REQUEST_URI'] . "&sID=" . $_COOKIE['PHPSESSID'] . "&cSl=" . strtolower($_SESSION['selfselectlang']) . "-" . $_SESSION['selfselectlang']; ?>" title="<?php echo $lang['tw-tw']; ?>"><span class="flag-icon flag-icon-tw"> </span> <?php echo $lang['tw-tw']; ?></a>
                        </div>
                        <div class="vr" style="color:#605f62;background-color:#605f62;"></div>
                        <span title="FiveMods.net is secured via TLS/SSL encryption." style="font-size: 20px;" class="text-success rounded m-2 ml-2">
                           <i class="fab fa-expeditedssl color-light" aria-hidden="true"></i>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
