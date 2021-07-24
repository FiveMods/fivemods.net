<?php
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler');
else ob_start();

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!empty($_GET['directPage'])) {
   header('location: '.$_GET['directPage'].'?prel=1');
}

if ($_POST['prefCcGiven'] == 1) {
   echo '<script>console.log("prefCcGiven: 1")</script>';
   header('location: /?cc=given&rdcURI=<?php echo $actual_link; ?>?prel=1');
   $cookie_name = "CONSENT";
   $cookie_value = "1";
   setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 365), "/"); // 86400 = 1 day

   header('location: /?prel=1&pri=all');
}

if ($_POST['functional'] == "on") {
   $cookie_name = "functional";
   $cookie_value = "1";
   setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 365), "/"); // 86400 = 1 day
} if ($_POST['statistical'] == "on") {
   $cookie_name = "statistical";
   $cookie_value = "1";
   setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 365), "/"); // 86400 = 1 day
} if ($_POST['thirdparty'] == "on") {
   $cookie_name = "thirdparty";
   $cookie_value = "1";
   setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 365), "/"); // 86400 = 1 day
}

if ($_GET['cc'] == "given") {
   $cookie_name = "CONSENT";
   $cookie_value = "1";
   setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 365), "/"); // 86400 = 1 day

   $rdcURI = $_GET['rdcURI'];
   header('location: ' . $rdcURI. '&pri=all');
}

if (!empty($_COOKIE['CONSENT'])) {
   session_start();
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

// include('./helper/geo-vpn.sub.php');

$favicon = 'https://assets.fivemods.net/static-assets/img/svg/brand/svg/fivemods_brand_icon_watermark_primary_1500x1500.svg';
$css_text = 'text text-gray';

require_once('./config.php');

$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password']);

if ($conn->connect_error) {
   header('location: /lock/');
}

function isMobile()
{
   return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


if (isset($_COOKIE['f_key']) || isset($_COOKIE['f_val'])) {
   if (empty($_COOKIE['f_val']) || empty($_COOKIE['f_key'])) {
      setcookie("f_val", " ", time() - 3600, "/");
      setcookie("f_key", " ", time() - 3600, "/");
      header("Location: /account/logout/?url=invalid");
   }
   echo '<script>console.log("Logged in");</script>';

   $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

   $selToken = $pdo->prepare("SELECT * FROM sessions WHERE newid = ?");
   $selToken->execute(array($_COOKIE['f_key']));
   if ($selToken->rowCount() > 0) {
      $fetch = $selToken->fetch();

      $timestamp = strtotime($fetch['created_at']);
      if ((($timestamp - 5) > $_COOKIE['f_val']) && (($timestamp + 5) < $_COOKIE['f_val'])) {

         setcookie("f_val", " ", time() - 3600, "/");
         setcookie("f_key", " ", time() - 3600, "/");
         header("Location: /account/logout/?url=invalid");
      } else {
         $_SESSION['uuid'] = $fetch['uuid'];
      }
   } else {

      setcookie("f_val", " ", time() - 3600, "/");
      setcookie("f_key", " ", time() - 3600, "/");
      header("Location: /account/logout/?url=invalid");
   }
}

?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($_COOKIE['language_preference'] == "IL") { echo "rtl";} else { echo "ltr"; } ?>">

<head>
   <?php

   if (!empty($_COOKIE['CONSENT']) || $_COOKIE['statistical'] == 1) {
      include('./include/gStatics.html');  
   }

   if ($_GET['pri'] == "all") {
      include('./include/gStatics.html'); 
      echo '<script>console.log("Pri: all");</script>';
      echo '<script async src="https://arc.io/widget.min.js#6GVgVmiV" type="application/javascript"></script>';
      echo '<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>';
   }

   ?>

   <meta name="google-site-verification" content="y4DUwdQzwqMiFlyNI8b_gGicaNOP-j_ERFP8MVoKLP0" />

   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <meta http-equiv="pragma" content="no-cache">
   <meta http-equiv="cache-control" content="no-cache">


   <?php

   if (strpos($actual_link, 'product') != FALSE) {

      $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

      $url = $actual_link;
      $parts = explode('/', $url);

      if (substr($actual_link, -1) == '/') {
         $urlNumber1 = $parts[count($parts) - 2];
      } else {
         $urlNumber1 = $parts[count($parts) - 1];
      }

      $selMod1 = $pdo->prepare("SELECT * FROM mods WHERE m_id = :mid");
      $selMod1->execute(array("mid" => $urlNumber1));

      $fetchMod1 = $selMod1->fetch();
      $m_name = $fetchMod1['m_name'];
      $m_picture = $fetchMod1['m_picture'];
      $m_desc = preg_replace("/\"/", "\'", $fetchMod1['m_description']);

      $imgArray = explode(" ", $m_picture);


      echo '
         <title>' . $m_name . ' - FiveMods</title>
         <meta property="og:type" content="website">
         <meta property="og:url" content="http://fivemods.net/product/' . $urlNumber1 . '">
         <meta property="og:title" content="' . $m_name . '">
         <meta property="og:description" content="' . $m_desc . '">
         <meta property="og:site_name" content="FiveMods">
         <meta property="og:image" content="' . $imgArray[0] . '">
      
         <meta name="twitter:card" content="summary_large_image">
         <meta name="twitter:site" content="@FiveModsNET">
         <meta name="twitter:title" content="' . $m_name . '">
         <meta name="twitter:description" content="' . $m_desc . '">
         <meta name="twitter:image" content="' . $imgArray[0] . '">
         ';

      echo '<script>console.log("Control numb.: ' . $urlNumber1 . '");</script>';
   } elseif (strpos($actual_link, 'status') != FALSE) {

      echo '
         <title>Statuspage - FiveMods</title>
         <meta name="msapplication-config" content="none">
         <meta name="theme-color" content="#FF8637">
         <meta name="msapplication-navbutton-color" content="#FF8637">
         <meta name="apple-mobile-web-app-capable" content="yes">
         <meta name="apple-mobile-web-app-status-bar-style" content="#FF8637">

         <meta property="og:type" content="website">
         <meta property="og:url" content="https://fivemods.net/status/">
         <meta property="og:title" content="FiveM & FiveMods Service Status">
         <meta property="og:description" content="Your page for the current FiveM & FiveMods outages">
         <meta property="og:site_name" content="FiveMods">

         <meta name="twitter:card" content="summary_large_image">
         <meta name="twitter:site" content="@FiveModsNET">
         <meta name="twitter:title" content="FiveM & FiveMods Service Status">
         <meta name="twitter:description" content="Your page for the current FiveM & FiveMods outages">';
   } elseif (strpos($actual_link, 'user') != FALSE) {

      $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

      $url = $actual_link;
      $parts = explode('/', $url);
      if (substr($actual_link, -1) == '/') {
         $urlName = $parts[count($parts) - 2];
      } else {
         $urlName = $parts[count($parts) - 1];
      }

      $selName = $pdo->prepare("SELECT * FROM user WHERE `name` = :uname");
      $selName->execute(array("uname" => $urlName));

      $fetchMod = $selName->fetch();
      $user_username = $fetchMod['name'];
      $user_picture = $fetchMod['picture'];
      $user_description = $fetchMod['description'];

      echo '<script>console.log("Username: ' . $user_username . '");</script>';
      echo '<script>console.log("User desc.: ' . $user_description . '");</script>';
      echo '<script>console.log("User img.: ' . $user_picture . '");</script>';
      echo '<script>console.log("User: ' . $urlName . '");</script>';

      if (empty($user_username)) {
         echo '<title>User - FiveMods</title>';
      } else {

         echo '
         <title>' . $user_username . ' - FiveMods</title>
         <meta name="msapplication-config" content="none">
         <meta name="theme-color" content="#FF8637">
         <meta name="msapplication-navbutton-color" content="#FF8637">
         <meta name="apple-mobile-web-app-capable" content="yes">
         <meta name="apple-mobile-web-app-status-bar-style" content="#FF8637">

         <meta property="og:type" content="website">
         <meta property="og:url" content="https://fivemods.net/user/' . $user_username . '">
         <meta property="og:title" content="' . $user_username . '">
         <meta property="og:description" content="' . $user_description . '">
         <meta property="og:site_name" content="FiveMods">
         <meta property="og:image" content="' . $user_picture . '">

         <meta name="twitter:card" content="summary_large_image">
         <meta name="twitter:site" content="@FiveModsNET">
         <meta name="twitter:title" content="' . $user_username . '">
         <meta name="twitter:description" content="' . $user_description . '">
         <meta name="twitter:image" content="' . $user_picture . '">';
      }
   } else {
      echo '<meta property="og:image" content="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png">';
      echo '<title>' . $lang['title'] . '</title>';
   }

   require_once('./lib/spec_meta.php');

   ?>  

   <meta name="robots" content="index, follow" />
   <meta name="department" content="legal" />
   <meta name="audience" content="all" />
   <meta name="author" content="FiveMods" />
   <meta name="publisher" content="FiveMods" />
   <meta name="organisation" content="FiveMods" />
   <meta name="copyright" content="Copyright (c) 2020-2021 FiveMods" />
   <meta name="generator" content="Atom, Visual Studio Code" />
   <meta name="coverage" content="Worldwide">

   <meta name="reply-to" content="contact@fivemods.net">

   <meta name="msapplication-config" content="none" />
   <meta name="theme-color" content="#FF8637" />
   <meta name="msapplication-navbutton-color" content="#FF8637" />
   <meta name="apple-mobile-web-app-capable" content="yes" />
   <meta name="apple-mobile-web-app-status-bar-style" content="#FF8637" />

   <meta name="stage" content="live" />
   <meta name="version" content="v1.2.6.5-stable" />

   <meta name="DC.Language" content="en" />
   <meta name="DC.Creator" content="FiveMods" />
   <meta name="DC.Publisher" content="FiveMods" />
   <meta name="DC.Rights" content="FiveMods" />

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
      echo '<link rel="stylesheet" id="pagestyle" href="/static-assets/css/style.css?v=' . time() . '">';
      $css_text = 'text text-muted';
   }
   ?>

   <link rel="icon" href="<?php echo $favicon; ?>">

   <link rel="apple-touch-icon" href="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="57x57" href="https://img-cdn.fivemods.net/unsafe/57x57/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="72x72" href="https://img-cdn.fivemods.net/unsafe/72x72/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="76x76" href="https://img-cdn.fivemods.net/unsafe/76x76/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="114x114" href="https://img-cdn.fivemods.net/unsafe/114x114/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="120x120" href="https://img-cdn.fivemods.net/unsafe/120x120/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="144x144" href="https://img-cdn.fivemods.net/unsafe/144x144/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="152x152" href="https://img-cdn.fivemods.net/unsafe/152x152/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />
   <link rel="apple-touch-icon" sizes="180x180" href="https://img-cdn.fivemods.net/unsafe/180x180/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/svg/brand/png/fivemods_brand_icon_watermark_primary.png" />

   <link rel="stylesheet" href="https://assets.fivemods.net/static-assets/css/style-adj.css">
   <link rel="stylesheet" href="https://assets.fivemods.net/static-assets/css/logo-animation.css">
   <link rel="stylesheet" href="https://assets.fivemods.net/static-assets/css/index.css">

   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

   <script type="text/javascript">
      var infolinks_pid = 3332544;
      var infolinks_wsid = 0;
   </script>
   

   <script type="text/javascript">
      window._mNHandle = window._mNHandle || {};
      window._mNHandle.queue = window._mNHandle.queue || [];
      medianet_versionId = "3121199";
   </script>
   <script src="https://contextual.media.net/dmedianet.js?cid=8CUTWJ28J" async="async"></script>

   <script>
      function swapStyleSheet(sheet) {
         document.getElementById('pagestyle').setAttribute('href', sheet);
      }
   </script>
   <script>
      $("#loader").show();
      $("#cload").hide();
      $(document).ready(function() {
         $("#loader").hide();
         console.log("Content: loaded");
      });
   </script>
</head>

<body class="bg">
<div id="684841532">
        <script type="text/javascript">
            try {
                window._mNHandle.queue.push(function (){
                    window._mNDetails.loadTag("684841532", "160x600", "684841532");
                });
            }
            catch (error) {}
        </script>
    </div>
   <?php

   if ($_GET['prel'] == 0) {
      if (!$_SESSION['preLoad'] || empty($_SESSION['preLoad'])) {
         echo '<div id="preloader">
         <svg width="280" height="100" viewBox="0 0 280 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="fivemods">
               <path id="mods" d="M147.168 73L147.104 43.304L132.384 67.88H128.672L113.952 43.688V73H106.016V28.2H112.864L130.656 57.896L148.128 28.2H154.976L155.04 73H147.168ZM181.733 73.448C178.277 73.448 175.162 72.7013 172.389 71.208C169.616 69.7147 167.44 67.6453 165.861 65C164.325 62.312 163.557 59.2827 163.557 55.912C163.557 52.5413 164.325 49.5333 165.861 46.888C167.44 44.2427 169.616 42.1733 172.389 40.68C175.162 39.1867 178.277 38.44 181.733 38.44C185.232 38.44 188.368 39.1867 191.141 40.68C193.914 42.1733 196.069 44.2427 197.605 46.888C199.184 49.5333 199.973 52.5413 199.973 55.912C199.973 59.2827 199.184 62.312 197.605 65C196.069 67.6453 193.914 69.7147 191.141 71.208C188.368 72.7013 185.232 73.448 181.733 73.448ZM181.733 66.6C184.677 66.6 187.109 65.6187 189.029 63.656C190.949 61.6933 191.909 59.112 191.909 55.912C191.909 52.712 190.949 50.1307 189.029 48.168C187.109 46.2053 184.677 45.224 181.733 45.224C178.789 45.224 176.357 46.2053 174.437 48.168C172.56 50.1307 171.621 52.712 171.621 55.912C171.621 59.112 172.56 61.6933 174.437 63.656C176.357 65.6187 178.789 66.6 181.733 66.6ZM241.095 25.512V73H233.415V68.584C232.092 70.2053 230.45 71.4213 228.487 72.232C226.567 73.0427 224.434 73.448 222.087 73.448C218.802 73.448 215.836 72.7227 213.191 71.272C210.588 69.8213 208.54 67.7733 207.047 65.128C205.554 62.44 204.807 59.368 204.807 55.912C204.807 52.456 205.554 49.4053 207.047 46.76C208.54 44.1147 210.588 42.0667 213.191 40.616C215.836 39.1653 218.802 38.44 222.087 38.44C224.348 38.44 226.418 38.824 228.295 39.592C230.172 40.36 231.772 41.512 233.095 43.048V25.512H241.095ZM223.047 66.6C224.967 66.6 226.695 66.1733 228.231 65.32C229.767 64.424 230.983 63.1653 231.879 61.544C232.775 59.9227 233.223 58.0453 233.223 55.912C233.223 53.7787 232.775 51.9013 231.879 50.28C230.983 48.6587 229.767 47.4213 228.231 46.568C226.695 45.672 224.967 45.224 223.047 45.224C221.127 45.224 219.399 45.672 217.863 46.568C216.327 47.4213 215.111 48.6587 214.215 50.28C213.319 51.9013 212.871 53.7787 212.871 55.912C212.871 58.0453 213.319 59.9227 214.215 61.544C215.111 63.1653 216.327 64.424 217.863 65.32C219.399 66.1733 221.127 66.6 223.047 66.6ZM262.121 73.448C259.347 73.448 256.638 73.0853 253.993 72.36C251.347 71.6347 249.235 70.7173 247.657 69.608L250.729 63.528C252.265 64.552 254.099 65.384 256.233 66.024C258.409 66.6213 260.542 66.92 262.633 66.92C267.411 66.92 269.801 65.6613 269.801 63.144C269.801 61.9493 269.182 61.1173 267.945 60.648C266.75 60.1787 264.809 59.7307 262.121 59.304C259.305 58.8773 257.001 58.3867 255.209 57.832C253.459 57.2773 251.923 56.3173 250.601 54.952C249.321 53.544 248.681 51.6027 248.681 49.128C248.681 45.8853 250.025 43.304 252.713 41.384C255.443 39.4213 259.113 38.44 263.721 38.44C266.067 38.44 268.414 38.7173 270.761 39.272C273.107 39.784 275.027 40.488 276.521 41.384L273.449 47.464C270.547 45.7573 267.283 44.904 263.657 44.904C261.31 44.904 259.518 45.2667 258.281 45.992C257.086 46.6747 256.489 47.592 256.489 48.744C256.489 50.024 257.129 50.9413 258.409 51.496C259.731 52.008 261.758 52.4987 264.489 52.968C267.219 53.3947 269.459 53.8853 271.209 54.44C272.958 54.9947 274.451 55.9333 275.689 57.256C276.969 58.5787 277.609 60.456 277.609 62.888C277.609 66.088 276.222 68.648 273.449 70.568C270.675 72.488 266.899 73.448 262.121 73.448Z" fill="white" />
               <g id="five">
                  <path id="Polygon 1" d="M49 0.57735C49.6188 0.220084 50.3812 0.220085 51 0.57735L92.3013 24.4227C92.9201 24.7799 93.3013 25.4402 93.3013 26.1547V73.8453C93.3013 74.5598 92.9201 75.2201 92.3013 75.5774L51 99.4227C50.3812 99.7799 49.6188 99.7799 49 99.4226L7.69873 75.5773C7.07993 75.2201 6.69873 74.5598 6.69873 73.8453V26.1547C6.69873 25.4402 7.07993 24.7799 7.69873 24.4226L49 0.57735Z" fill="url(#paint0_linear)" />
                  <g id="5" filter="url(#filter0_d)">
                     <path d="M47.832 45.544C54.1467 45.544 58.8187 46.7813 61.848 49.256C64.8773 51.688 66.392 55.016 66.392 59.24C66.392 61.928 65.7307 64.36 64.408 66.536C63.0853 68.712 61.1013 70.44 58.456 71.72C55.8107 73 52.5467 73.64 48.664 73.64C45.464 73.64 42.3707 73.192 39.384 72.296C36.3973 71.3573 33.88 70.0773 31.832 68.456L35.352 61.992C37.016 63.3573 39 64.4453 41.304 65.256C43.6507 66.024 46.0613 66.408 48.536 66.408C51.48 66.408 53.784 65.8107 55.448 64.616C57.1547 63.3787 58.008 61.6933 58.008 59.56C58.008 57.256 57.0907 55.528 55.256 54.376C53.464 53.1813 50.3707 52.584 45.976 52.584H35.16L37.464 28.2H63.768V35.176H44.504L43.544 45.544H47.832Z" fill="white" />
                  </g>
               </g>
            </g>
            <defs>
               <filter id="filter0_d" x="27.832" y="26.2" width="42.56" height="53.44" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix" />
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                  <feOffset dy="2" />
                  <feGaussianBlur stdDeviation="2" />
                  <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
               </filter>
               <linearGradient id="paint0_linear" x1="50" y1="0" x2="50" y2="100" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#E57C0B" />
                  <stop offset="1" stop-color="#E94057" />
               </linearGradient>
            </defs>
         </svg>
      </div>';
      }
   }

   $_SESSION['preLoad'] = True;

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
   } elseif (strpos($_GET['page'], "imprint") !== FALSE) {
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

   <main>
      <div id="cload">
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
      </div>
   </main>

   <?php

   if (strpos($_GET['page'], "upload-policy") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "legal-notice") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "privacy-policy") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "terms-of-service") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "cookie-consent") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "imprint") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "account-policy") !== FALSE) {
      include('./include/footer-legal.php');
   } elseif (strpos($_GET['page'], "payment-agreement") !== FALSE) {
      include('./include/footer-legal.php');
   } else {
      include('./include/footer-normal.php');
   }

   # Include cookie modal now from other file
   include('./include/cModal.html');
   include('./include/cModalManage.html');

   ?>
   <!-- ========== END FOOTER ========== -->

   <!-- jQuery is required -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous"></script>

   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

   <script type="text/javascript">
      $(document).ready(function() {
         $('#cCO').modal('<?php

         if (strpos($_GET['page'], "terms-of-service") !== FALSE && $_GET['cc'] == "hide") {
            echo 'hide';
         } elseif (strpos($_GET['page'], "privacy-policy") !== FALSE && $_GET['cc'] == "hide") {
            echo 'hide';
         } elseif (strpos($_GET['page'], "cookie-consent") !== FALSE && $_GET['cc'] == "hide") {
            echo 'hide';
         } elseif (!empty($_COOKIE['CONSENT'])) {
            echo 'hide';
         } elseif ($_GET['cc'] == "manage") {
            echo 'hide';
         } else {
            echo 'show';
         }

         ?>');
      });
   </script>
   <?php

   if ($_GET['cc'] == "manage") {
      echo '<script>
      $(document).ready(function(){
         jQuery.noConflict(); 
         $(\'#cCM\').modal(\'show\'); 
      });
   </script>';
   }

   ?>
   <script type="text/javascript">
      $(document).ready(function() {
         $('#preloader').delay(2500).fadeOut('slow');
      });
   </script>
   <script type="text/javascript">
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

      function openSearch() {
         document.getElementById("myOverlay").style.display = "block";
      }

      function closeSearch() {
         document.getElementById("myOverlay").style.display = "none";
      }
   </script>
   <script type="text/javascript">
      // add padding top to show content behind navbar
      $('body').css('padding-top', $('.navbar').outerHeight() + 'px');
   </script>
   <!-- Matomo -->
<script type="text/javascript">
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(['setLinkClasses', "matomo_download"]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.fivemods.net/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '2']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.fivemods.net/matomo.php?idsite=2&amp;rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Matomo Code -->

</body>

</html>
