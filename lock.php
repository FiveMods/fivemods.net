<?php 

require_once('./config.php');

$conn = new mysqli($mysql['servername'], $mysql['username'], $mysql['password']);

if (!$conn->connect_error) {
   header('location: /');
}

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler');
else ob_start();

session_start();

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We'll be right back - FiveMods.net</title>
    <meta http-equiv="content-language" content="en" />
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta name="description" content="Searching for FiveM ready scripts, vehicles, mods, maps, peds and more? You've come to the right place. FiveMods.net the palce to get the best resources for your FiveM server." />
    <meta name="robots" content="index, follow" />
    <meta name="department" content="legal" />
    <meta name="audience" content="all" />
    <meta name="author" content="FiveMods" />
    <meta name="publisher" content="FiveMods" />
    <meta name="organisation" content="FiveMods" />
    <meta name="copyright" content="FiveMods" />
    <meta name="generator" content="Atom, Visual Studio Code, PhpStorm, Eclipse (WTP)" />
    <meta name="keywords" content="FiveM, fivem, fivemods, FiveMods, GTA5, GTAV, gta5, gtav, gta, scripts, script, Scripts, Script, Development, Dev, dev, development, offical, usa, america" />
    <meta name="page-topic" content="FiveM ready scripts, vehicles, mods, maps, peds and more." />
    <meta name="page-type" content="Website, Landingpage, Homepage" />
    <meta name="copyrighted-site-verification" content="f9fa2783d3d1da95" />
    <meta name="DC.Language" content="en" />
    <meta name="DC.Creator" content="FiveMods" />
    <meta name="DC.Publisher" content="FiveMods" />
    <meta name="DC.Rights" content="FiveMods" />
    <meta name="DC.Description" content="Searching for FiveM ready scripts, vehicles, mods, maps, peds and more? You've come to the right place." />
    <script src="/cdn-cgi/apps/head/ictDLxICQsFVMPS59T0akYEa1qs.js"></script>
    <link rel="icon" href="https://www.fivemods.net/static-assets/img/svg/brand/svg/fivemods_brand_icon_watermark_primary_1500x1500.svg">

    <meta http-equiv="refresh" content="5">

    <style>
        html,
        body {
            background: url('/static-assets/img/background/icon_bg_dark.png');
            background-repeat: repeat;
            background-size: 75%;
            color: #ff8637;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        
        .full-height {
            height: 100vh;
        }
        
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        
        .position-ref {
            position: relative;
        }
        
        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
        }
        
        .message {
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="center"><img src="https://fivemods.net/static-assets/img/svg/brand/svg/fivemods_brand_text_primary_white_280x100.svg" load="lazy" alt="Brand Logo" style="height: 75px;"></div>
    </div>

    

</body>

</html>