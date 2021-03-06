<?php

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
<html lang="en" dir="ltr">

<head>
    <script src="/cdn-cgi/apps/head/wHhLuPTmd1Xk-g7DC7gCWvIJ040.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" id="pagestyle" href="https://assets.fivemods.net/static-assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="icon" href="https://assets.fivemods.net/static-assets/img/svg/brand/svg/fivemods_brand_icon_watermark_primary_1500x1500.svg">
    <link rel="apple-touch-icon" href="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="https://img-cdn.fivemods.net/unsafe/57x57/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="https://img-cdn.fivemods.net/unsafe/72x72/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="https://img-cdn.fivemods.net/unsafe/76x76/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="https://img-cdn.fivemods.net/unsafe/114x114/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="https://img-cdn.fivemods.net/unsafe/120x120/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="https://img-cdn.fivemods.net/unsafe/144x144/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="https://img-cdn.fivemods.net/unsafe/152x152/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="https://img-cdn.fivemods.net/unsafe/180x180/filters:format(webp):quality(95)/https://assets.fivemods.net/static-assets/img/apple-touch-icon/apple-touch-icon-180x180.png" />
    <title>We will be right back - FiveMods</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="We'll be right back - FiveMods">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://assets.fivemods.net/">
    <meta property="og:title" content="We'll be right back - FiveMods">
    <meta property="og:description" content="We'll be right back - FiveMods">
    <meta property="og:site_name" content="We'll be right back - FiveMods">
    <meta property="og:image" content="https://assets.fivemods.net/static-assets/img/svg/error/fivemods_error_401.svg">
    <meta name="theme-color" content="#ff8637">
    <meta name="msapplication-navbutton-color" content="#ff8637">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#ff8637">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body::-webkit-scrollbar {
            width: .5rem;
        }

        body::-webkit-scrollbar-track {
            background: #17141f;
        }

        body::-webkit-scrollbar-thumb {
            background: linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%);
        }

        :root {
            --v-fivemods-brand-color: #ff8637;
            --v-global-light-bg-color: #f9f9f9;
        }

        .f-bg-dark {
            background: url('https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(100)/https://assets.fivemods.net/static-assets/img/background/icon_bg_dark_darkest.png');
            background-repeat: repeat;
            background-size: 75%;
        }

        .bg {
            background: url('https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(100)/https://assets.fivemods.net/static-assets/img/background/icon_bg_multi_lighter.png');
            background-repeat: repeat;
            background-size: 75%;
        }

        .sign-in-bg {
            background: url('https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(100)/https://assets.fivemods.net/static-assets/img/bg-4.png');
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
        }

        .emp-login {
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.8);
            /* opacity: 0.6; */
        }

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid gray;
        }

        .separator:not(:empty)::before {
            margin-right: .25em;
        }

        .separator:not(:empty)::after {
            margin-left: .25em;
        }

        .btn-discord {
            background-color: #2f3136;
            color: white;
        }

        .btn-discord:hover {
            background-color: #26272b;
            color: white;
        }

        .invalid-feedback.feedback-icon {
            position: absolute;
            width: auto;
            bottom: 30px;
            right: 10px;
            margin-top: 0;
        }

        .valid-feedback.feedback-icon {
            position: absolute;
            width: auto;
            bottom: 10px;
            right: 10px;
            margin-top: 0;
        }

        .fmAdH3 {
            font-size: 1.5em;
            margin: .8em 0 .3em;
            font-weight: bold;
            display: block;
            margin-block-start: 0.67em;
            margin-block-end: 0.67em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .fmAdjP {
            font-size: 14px;
            color: #1d222b;
        }

        .fmAdjCH {
            background-color: var(--v-global-light-bg-color);
            padding: 16px 18px;
        }

        .fmAdjCTBrand {
            color: var(--v-fivemods-brand-color);
            font-size: .875em;
            text-transform: uppercase;
            font-weight: 600;
            margin: 0;
        }

        .fmAdjCT {
            color: black;
            font-size: .875em;
            text-transform: uppercase;
            font-weight: 600;
            margin: 0;
        }

        .fmAdjCD {
            border-left: 2px solid var(--v-fivemods-brand-color);
            padding-left: 13px;
            margin-bottom: 1.4em;
        }

        .fmAdjH3 {
            display: inline;
            font-size: inherit;
            margin: .8em 0 .3em;
            font-weight: bold;
        }

        .em0_8 {
            margin-left: 0.8em;
        }

        .em2_5 {
            margin-left: 2.5em;
        }

        .fmAdjHSP {
            overflow: hidden;
            background-color: #fff;
            position: fixed;
            top: 0;
            width: 100%;
        }

        .fmAdjAB {
            color: #188fff;
        }

        #more1 {
            display: none;
        }

        #more2 {
            display: none;
        }

        .fmAdjBt {
            max-width: 95%;
            width: 135px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: distribute;
            justify-content: space-around;
            background: #FFFFFF;
            -webkit-box-shadow: 0 2px 15px 0 rgb(172 172 172 / 50%);
            box-shadow: 0 2px 15px 0 rgb(172 172 172 / 50%);
            margin: 0 auto;
            border: 1px solid #188fff;
            font-size: 14px;
            border-radius: 1.5em;
            font-weight: 400;
            color: #188fff;
        }

        .fmAdjMBtn {
            border: none;
            color: #188fff;
            background-color: white;
        }

        .fmAdjMBtn:hover {
            text-decoration: underline;
        }

        a {
            color: #188fff;
        }

        a:hover {
            color: #188fff;
        }
    </style>
</head>

<body>
    <main>
        <section class="align-items-bottom d-flex" style="min-height: 100vh; background-size: cover;">
            <div class="col-md-3"> </div>
            <div class="col-md-6 mt-2 mb-2 p-4">
                <div>
                    <div class="fmAdjHSP mb-4 pt-4" id="fmHSt"> <a class="navbar-brand mb-3" href="/"> <img src="https://assets.fivemods.net/static-assets/img/svg/brand/svg/fivemods_brand_text_primary_gradient_281x100.svg" alt="FiveMods 403 Error Logo" style="height: 40px;"> </a> </div>
                    <h3 class="fmAdH3 mt-5 pt-4">We will be right back</h3>
                    <p class="fmAdjP">The page or resource you are trying to access is currently experiencing a disruption or attack. Please refer to our system administrator if you think this is an error. Reach out via <a href="mailto:contact@fivemods.net">contact@fivemods.net</span></a>. This page will refresh every 5 seconds. <br><br> If you wish to check the current status, please click <a href="https://status.fivemods.net" rel="noreferrer noopener">here</a>. 
                    </p>

                </div>
            </div>
            <div class="col-md-3"> </div>
        </section>
    </main>
</body>

</html>