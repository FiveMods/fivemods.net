<?php
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler');
else ob_start();

ini_set("session.cookie_domain", ".fivemods.net");

session_start();

if (empty($_SESSION['language'])) {
   $_SESSION['language'] = "Auto-EN";
}


if (isset($_GET['kill'])) {
   if ($_GET['kill'] == "session") {
      session_destroy();
      header('location: ./');
   }
}

if ($_SESSION['user_blocked'] == 1) {
   header('location: /account/logout/?url=banned');
}

ob_start("minifier");
function minifier($code)
{
   $search = array(
      '/\>[^\S ]+/s',
      '/[^\S ]+\</s',
      '/(\s)+/s',
      '/<!--(.|\s)*?-->/'
   );
   $replace = array('>', '<', '\\1');
   $code = preg_replace($search, $replace, $code);
   return $code;
}

include('./helper/lang-confg.php');

if (empty($_GET['fm_design']) == "orange") {
   $css_banner  = '/static-assets/img/banner.png';
   $css_search = '#ff8637';
   $brand_down = '/static-assets/img/brand-down.png';
   $brand_side = '/static-assets/img/brand-side.png';
   $favicon = '/static-assets/img/fivemods-favicon.png';
   $css_text = 'text text-gray';
}

require_once('./config.php');

$servername = $mysql['servername'];
$username = $mysql['username'];
$password = $mysql['password'];
$dbname = $mysql['dbname'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>" dir="ltr">

<head>

   <!-- Start cookieyes banner -->
   <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/b2f06fda03f99c6d3075a941.js"></script>
   <!-- End cookieyes banner --> 

   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180288055-1"></script>
   <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
         dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-180288055-1');
   </script>

   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151024992-2"></script>
   <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
         dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-151024992-2');
   </script>

   <!-- Google Tag Manager -->
   <script>
      (function(w, d, s, l, i) {
         w[l] = w[l] || [];
         w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
         });
         var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
         j.async = true;
         j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
         f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-5XZ6BDR');
   </script>
   <!-- End Google Tag Manager -->

   <!-- <script data-ad-client="pub-9727102575141971" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
   <script data-ad-client="ca-pub-9727102575141971" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
   <meta name="google-site-verification" content="y4DUwdQzwqMiFlyNI8b_gGicaNOP-j_ERFP8MVoKLP0" />
   <script data-ad-client="ca-pub-9727102575141971" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
   <script data-ad-client="pub-9727102575141971" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title><?php echo $lang['title']; ?></title>

   <meta http-equiv="content-language" content="en" />
   <meta name="description" content="Searching for FiveM ready scripts, vehicles, mods, maps, peds and more? You've come to the right place. FiveMods.net the place to get the best resources for your FiveM server." />
   <meta name="robots" content="index, follow" />
   <meta name="department" content="legal" />
   <meta name="audience" content="all" />
   <meta name="author" content="FiveMods" />
   <meta name="publisher" content="FiveMods" />
   <meta name="organisation" content="FiveMods" />
   <meta name="copyright" content="FiveMods" />
   <meta name="generator" content="Atom, Visual Studio Code" />
   <meta name="keywords" content="FiveM, fivem, fivemods, FiveMods, GTA5, GTAV, gta5, gtav, gta, scripts, script, Scripts, Script, Development, Dev, dev, development, offical, usa, america, mod, modification, vehicles, planes, boats, model, loading screen, airport, map" />
   <meta name="page-topic" content="FiveM ready scripts, vehicles, mods, maps, peds and more." />
   <meta name="page-type" content="Website, Landingpage, Homepage, Platform" />
   <meta name="copyrighted-site-verification" content="f9fa2783d3d1da95" />
   <meta name='dmca-site-verification' content='MmRJNFlJeTBxbHRDT1k2cndkeko3dz090' />
   <meta name="msapplication-config" content="none">
   <meta name="theme-color" content="#FF8637">
   <meta name="msapplication-navbutton-color" content="#FF8637">
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="#FF8637">

   <meta name="DC.Language" content="en" />
   <meta name="DC.Creator" content="FiveMods" />
   <meta name="DC.Publisher" content="FiveMods" />
   <meta name="DC.Rights" content="FiveMods" />
   <meta name="DC.Description" content="Searching for FiveM ready scripts, vehicles, mods, maps, peds and more? You've come to the right place." />

   <?php 

      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      if (strpos($actual_link, 'product') != FALSE) {        

         $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

         $url = $actual_link;
         $parts = explode('/', $url);
         $urlNumber = $parts[count($parts) - 2];

         $selMod = $pdo->prepare("SELECT * FROM mods WHERE m_id = :mid");
         $selMod->execute(array("mid" => $urlNumber));

         $fetchMod = $selMod->fetch();
         $m_name = $fetchMod['m_name'];
         $m_picture = $fetchMod['m_picture'];
         $m_desc = $fetchMod['m_description'];


         echo '<script>console.log("Mod name: '.$m_name.'");</script>';
         echo '<script>console.log("Mod pic: '.$m_picture.'");</script>';


         echo '
         <meta property="og:type" content="website">
         <meta property="og:url" content="http://fivemods.net/product/'.$urlNumber.'">
         <meta property="og:title" content="FiveMods.net - '.$m_name.'">
         <meta property="og:description" content="FiveMods.net - '.$m_desc.'">
         <meta property="og:site_name" content="FiveMods.net - '.$m_name.'">
         <meta property="og:image" content="'.$m_picture.'">
      
         <meta name="twitter:card" content="summary_large_image">
         <meta name="twitter:site" content="@five_mods">
         <meta name="twitter:title" content="FiveMods.net - '.$m_name.'">
         <meta name="twitter:description" content="FiveMods.net - '.$m_desc.'">
         <meta name="twitter:image" content="'.$m_picture.'">
         ';
      
         echo '<script>console.log("Control numb.: '.$urlNumber.'");</script>';
      }   

   ?>

   <!-- RESP. FOR LINK EMBEDS ON TWITTER AND PROB. DC -->

   <!-- <meta name="msapplication-config" content="none">
   <meta name="theme-color" content="#FF8637">
   <meta name="msapplication-navbutton-color" content="#FF8637">
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="#FF8637">

   <meta property="og:type" content="">
   <meta property="og:url" content="">
   <meta property="og:title" content="">
   <meta property="og:description" content="">
   <meta property="og:site_name" content="FiveMods.net">
   <meta property="og:image" content="">

   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:site" content="@five_mods">
   <meta name="twitter:title" content="">
   <meta name="twitter:description" content="">
   <meta name="twitter:image" content=""> -->

   <!-- RESP. FOR LINK EMBEDS ON TWITTER AND PROB. DC -->

   <meta name="detectify-verification" content="9017bbff64caea301ceb67335deb6a86" />

   <?php
   if (!empty($_COOKIE['fm_design'])) {
      if ($_COOKIE['fm_design'] == "dark") {
         echo '<link rel="stylesheet" id="pagestyle" href="/static-assets/css-dark/style.css">';
         $css_text = 'text text-muted';
         $darkmode = 'bg-dark';
      } elseif ($_COOKIE['fm_design'] == "normal") {
         echo '<link rel="stylesheet" id="pagestyle" href="/static-assets/css/style.css">';
         $css_text = 'text text-muted';
      } elseif (empty($_COOKIE['fm_design'])) {
         echo '<link rel="stylesheet" id="pagestyle" href="/static-assets/css/style.css">';
         $css_text = 'text text-muted';
      }
   } else {
      echo '<link rel="stylesheet" id="pagestyle" href="/static-assets/css/style.css">';
      $css_text = 'text text-muted';
   }
   ?>

   <link rel="icon" href="<?php echo $favicon; ?>">
   <link rel="stylesheet" href="/static-assets/css/style-adj.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />
   <script>
      function swapStyleSheet(sheet) {
         document.getElementById('pagestyle').setAttribute('href', sheet);
      }
   </script>
   <!-- Plugins -->
   <style>
      @media all and (min-width: 992px) {
         .navbar .has-megamenu {
            position: static !important;
         }

         .navbar .megamenu {
            left: 0;
            right: 0;
            width: 100%;
            padding: 20px;
         }

         .navbar .nav-link {
            padding-top: 1rem;
            padding-bottom: 1rem;
         }
      }

      .heading-navbar {
         color: black;
      }

      .col-md-navbar {
         padding-left: 7%;
         padding-right: 7%;
         -webkit-box-flex: 0;
         -ms-flex: 0 0 13%;
         flex: 0 0 13%;
         max-width: 13%
      }

      .carousel-pic {
         width: 120px;
         height: 90px;
      }

      .container-search {
         max-width: 600px;
         margin: 50px auto
      }

      input {
         outline: none;
      }

      input[type=search] {
         -webkit-appearance: textfield;
         -webkit-box-sizing: content-box;
         font-family: inherit;
         font-size: 100%;
      }

      input::-webkit-search-decoration,
      input::-webkit-search-cancel-button {
         display: none;
      }

      input[type=search] {
         background: <?php echo $css_search; ?> url('/static-assets/img/search-16x16.png') no-repeat 9px center;
         padding: 9px 10px 9px 12px;
         -webkit-transition: all .5s;
         -moz-transition: all .5s;
         transition: all .5s;
      }

      input[type=search]:focus {
         width: 130px;
      }


      input:-moz-placeholder {
         color: #999;
      }

      input::-webkit-input-placeholder {
         color: #999;
      }

      /* Demo 2 */
      #demo-2 input[type=search] {
         width: 15px;
         height: 15px;
         padding-left: 10px;
         color: transparent;
         cursor: pointer;
      }

      #demo-2 input[type=search]:focus {
         width: 130px;
         padding-left: 32px;
         color: white;
         cursor: auto;
      }

      #demo-2 input:-moz-placeholder {
         color: transparent;
      }

      #demo-2 input::-webkit-input-placeholder {
         color: transparent;
      }

      .smallButton {
         margin-left: 25px;
      }

      .profile {
         color: black;
      }

      .loader-wrapper {
         width: 100%;
         height: 100%;
         position: absolute;
         top: 0;
         left: 0;
         <?php if ($_COOKIE['fm_design'] == "dark") {
            echo "background-color: #1B1B2F;";
         } else {
            echo "background-color: #fff;";
         } ?>display: flex;
         justify-content: center;
         align-items: center;
      }

      .loader {
         display: inline-block;
         width: 7px;
         height: 7px;
         position: relative;
         <?php if ($_COOKIE['fm_design'] == "normal") {
            echo "border: 4px solid #1B1B2F;";
         } else {
            echo "border: 4px solid #fff;";
         } ?>animation: loader 2s infinite ease;
      }

      .space-16 {
         letter-spacing: 16px;
      }

      .center {
         text-align: center;
      }
   </style>
</head>

<body>
   <!-- Google Tag Manager (noscript) -->
   <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5XZ6BDR" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
   <!-- End Google Tag Manager (noscript) -->
   <?php

   if (strpos($_GET['page'], "upload-policy") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "legal-notice") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "privacy-policy") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "terms-of-service") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "cookie-consent") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "impressum") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "account-policy") !== FALSE) {
      include('./include/header-legal.php');
   } elseif (strpos($_GET['page'], "payment-agreement") !== FALSE) {
      include('./include/header-legal.php');
   } elseif ($_SESSION['on2fa'] == TRUE) {
      include('./include/header-2fa.php');
   } else {
      include('./include/header-normal.php');
   }

   // Control to check in console which language got selected
   echo '<script> console.log("Language: ' . $_SESSION['language'] . '") </script>';
   ?>
   <!-- ========== END HEADER ========== -->

   <!-- ========== MAIN CONTENT ========== -->
   <?php
   if (isset($_GET['page'])) {
      $page_names = explode('/', $_GET["page"]);
      if (file_exists("pages/" . $page_names[0] . ".php")) {
         include("pages/" . $page_names[0] . ".php");
      } else if ($page_names[0] == "error-pages" and isset($page_names[1])) {
         if (file_exists("error/400/" . $page_names[1] . ".html")) {
            http_response_code($page_names[1]);
            include("error/400/" . $page_names[1] . ".html");
         } else {
            include("error/400/404.html");
         }
      } else {
         include("error/400/404.html");
      }
   } else {
      include("pages/.php");
   }
   ?>
   <!-- ========== END MAIN CONTENT ========== -->

   <div class="text-center pt-3 pb-2">
      <a href="https://www.netcup.de" target="_blank"><img src="https://www.netcup.de/static/assets/images/promotion/netcup-setC-728x90.png" width="728" height="90" alt="netcup.de" /></a>
   </div>

   <!-- ========== FOOTER ========== -->
   <?php include('./include/footer-normal.php'); ?>
   <!-- ========== END FOOTER ========== -->

   <!-- jQuery is required -->
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous"></script>

   <script>
      /* Author: AdGlare Ad Server (https://www.adglare.com) */
      function hasAdblock() {
         var t = document.createElement('div');
         t.innerHTML = '&nbsp;', t.className = 'adsbox pub_300x250 pub_300x250m pub_728x90 text-ad textAd text_ad text_ads text-ads adglare-ad-server text-ad-links';
         var e = !(t.style = 'width: 1px !important; height: 1px !important; position: absolute !important; left: -10000px !important; top: -1000px !important;');
         try {
            document.body.appendChild(t);
            var a = document.getElementsByClassName('adsbox')[0];
            if (0 !== a.offsetHeight && 0 !== a.clientHeight || (e = !0), void 0 !== window.getComputedStyle) {
               var d = window.getComputedStyle(a, null);
               !d || 'none' != d.getPropertyValue('display') && 'hidden' != d.getPropertyValue('visibility') || (e = !0)
            }
            document.body.removeChild(t)
         } catch (a) {}
         return e
      }

      if (hasAdblock() === true) {
         console.log("Adblock: " + hasAdblock());
         $('#mach').show();
      } else {
         console.log("Adblock: " + hasAdblock());
      }
   </script>
   <script>
      function openSearch() {
         document.getElementById("myOverlay").style.display = "block";
      }

      function closeSearch() {
         document.getElementById("myOverlay").style.display = "none";
      }
   </script>
   <script>
      // add padding top to show content behind navbar
      $('body').css('padding-top', $('.navbar').outerHeight() + 'px');
   </script>
   <!--
   <script>
      const charactersList = document.getElementById('charactersList');
      const searchBar = document.getElementById('searchBar');
      let hpCharacters = [];
      
      searchBar.addEventListener('keyup', (e) => {
         const searchString = e.target.value.toLowerCase();

         const filteredCharacters = hpCharacters.filter((character) => {
            return (
               character.name.toLowerCase().includes(searchString) ||
               character.house.toLowerCase().includes(searchString)
            );
         });
         displayCharacters(filteredCharacters);
      });
      
      const loadCharacters = async () => {
         try {
            const res = await fetch('https://hp-api.herokuapp.com/api/characters');
            hpCharacters = await res.json();
            displayCharacters(hpCharacters);
         } catch (err) {
            console.error(err);
         }
      };

      const displayCharacters = (characters) => {
         const htmlString = characters
            .map((character) => {
               return `
                     <li class="character">
                        <h2>${character.name}</h2>
                        <p>House: ${character.house}</p>
                        <img src="${character.image}"></img>
                     </li>
               `;
            })
            .join('');
         charactersList.innerHTML = htmlString;
      };

      loadCharacters();
   </script>
-->
</body>

</html>