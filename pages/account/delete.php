<?php
include('./include/header-banner.php');
require_once('./config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
	header('location: /account/logout/');
	exit();
}

?>
<style>
.center {
   text-align: center;
}
</style>
<?php 

function startsWith( $haystack, $needle ) {
   $length = strlen( $needle );
   return substr( $haystack, 0, $length ) === $needle;
}

session_start(); 

if ($_GET['r'] == 1) {
     // Generate delete token
     function generateRandomString($length = 24) {
      return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_', ceil($length/strlen($x)) )),1,$length);
   }

   $token = htmlspecialchars(generateRandomString());

   $cookie_name = "rm-rfv";
   $cookie_value = $token;
   setcookie($cookie_name, $cookie_value, time() + (60 * 2), "/"); // 86400 = 1 day

   if($_SESSION['user_oauth_provider'] == 'Discord Inc' && empty($_COOKIE['rm-rfv']) || $_SESSION['user_oauth_provider'] == 'Discord Inc.' && empty($_COOKIE['rm-rfv'])) {

      $userid = $_SESSION['user_id'];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"http://85.214.166.192:8081");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "action=deleteAccount&userid=$userid&token=$token");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
      
      if(startsWith($response, "Success")) {
         $type = "success";
      } else if(startsWith($response, "Error")) {
         $type = "danger";
      } else {
         $type = "primary";
      }
   ?>
   <div class="alert alert-<?php echo $type;?> alert-dismissible fade show center" role="alert">
   <?php echo $response;?>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
   </button>
   </div>
   <?php
   } elseif ($_SESSION['user_oauth_provider'] == 'Google LLC' && empty($_COOKIE['rm-rfv']) || $_SESSION['user_oauth_provider'] == 'Google LLC.' && empty($_COOKIE['rm-rfv'])) {
    $email = $_SESSION['user_email'];
    $name = $_SESSION['user_username'];
    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html data-editor-version="2" class="sg-campaigns" xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
          <!--[if !mso]><!-->
          <meta http-equiv="X-UA-Compatible" content="IE=Edge">
          <!--<![endif]-->
          <!--[if (gte mso 9)|(IE)]>
          <xml>
            <o:OfficeDocumentSettings>
              <o:AllowPNG/>
              <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
          </xml>
          <![endif]-->
          <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
        body {width: 800px;margin: 0 auto;}
        table {border-collapse: collapse;}
        table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
        img {-ms-interpolation-mode: bicubic;}
      </style>
    <![endif]-->
          <style type="text/css">
        body, p, div {
          font-family: arial,helvetica,sans-serif;
          font-size: 14px;
        }
        body {
          color: #000000;
        }
        body a {
          color: #1188E6;
          text-decoration: none;
        }
        p { margin: 0; padding: 0; }
        table.wrapper {
          width:100% !important;
          table-layout: fixed;
          -webkit-font-smoothing: antialiased;
          -webkit-text-size-adjust: 100%;
          -moz-text-size-adjust: 100%;
          -ms-text-size-adjust: 100%;
        }
        img.max-width {
          max-width: 100% !important;
        }
        .column.of-2 {
          width: 50%;
        }
        .column.of-3 {
          width: 33.333%;
        }
        .column.of-4 {
          width: 25%;
        }
        @media screen and (max-width:480px) {
          .preheader .rightColumnContent,
          .footer .rightColumnContent {
            text-align: left !important;
          }
          .preheader .rightColumnContent div,
          .preheader .rightColumnContent span,
          .footer .rightColumnContent div,
          .footer .rightColumnContent span {
            text-align: left !important;
          }
          .preheader .rightColumnContent,
          .preheader .leftColumnContent {
            font-size: 80% !important;
            padding: 5px 0;
          }
          table.wrapper-mobile {
            width: 100% !important;
            table-layout: fixed;
          }
          img.max-width {
            height: auto !important;
            max-width: 100% !important;
          }
          a.bulletproof-button {
            display: block !important;
            width: auto !important;
            font-size: 80%;
            padding-left: 0 !important;
            padding-right: 0 !important;
          }
          .columns {
            width: 100% !important;
          }
          .column {
            display: block !important;
            width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
          }
          .social-icon-column {
            display: inline-block !important;
          }
        }
      </style>
          <!--user entered Head Start--><!--End Head user entered-->
        </head>
        <body>
          <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size:14px; font-family:arial,helvetica,sans-serif; color:#000000; background-color:#FFFFFF;">
            <div class="webkit">
              <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#FFFFFF">
                <tr>
                  <td valign="top" bgcolor="#FFFFFF" width="100%">
                    <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td width="100%">
                          <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td>
                                <!--[if mso]>
        <center>
        <table><tr><td width="800">
      <![endif]-->
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:800px;" align="center">
                                          <tr>
                                            <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#17141F" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
        <tr>
          <td role="module-content">
            <p></p>
          </td>
        </tr>
      </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="7121aaab-005f-41fc-a344-4ff122ce8a1a">
        <tbody>
          <tr>
            <td style="font-size:6px; line-height:10px; padding:10px 0px 10px 0px;" valign="top" align="center">
              <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:6% !important; width:6%; height:auto !important;" width="48" alt="" data-proportionally-constrained="true" data-responsive="true" src="http://cdn.mcauto-images-production.sendgrid.net/1de9ff722efdbc70/f6ba7f2a-afd7-42df-9b69-0e9d52f5a2ac/1734x1645.png">
            </td>
          </tr>
        </tbody>
      </table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:0px 0px 0px 0px;" bgcolor="#FFFFFF">
        <tbody>
          <tr role="module-content">
            <td height="100%" valign="top"><table width="780" style="width:780px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="" class="column column-0">
          <tbody>
            <tr>
              <td style="padding:0px;margin:0px;border-spacing:0;"><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="6e45e5cc-9a9b-4f96-b1dd-7820f7a5d0c5" data-mc-module-version="2019-10-22">
        <tbody>
          <tr>
            <td style="padding:85px 20px 25px 20px; line-height:22px; text-align:inherit;" height="100%" valign="top" bgcolor="" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 14px">Your requested the removal of your account,&nbsp;</span></div>
    <div style="font-family: inherit; text-align: center"><span style="font-size: 14px">please copy the token </span><span style="font-size: 14px">and enter it into the panel.</span></div>
    <div style="font-family: inherit; text-align: center"><br></div>
    <div style="font-family: inherit; text-align: center"><br></div>
    <div style="font-family: inherit; text-align: center"><span style="font-size: 24px"><strong>'.$token.'</strong></span></div>
    <div style="font-family: inherit; text-align: center"><br></div><div></div></div></td>
          </tr>
        </tbody>
      </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="9500b366-f515-4dee-985b-bd32310ec29f" data-mc-module-version="2019-10-22">
        <tbody>
          <tr>
            <td style="padding:18px 0px 18px 0px; line-height:22px; text-align:inherit;" height="100%" valign="top" bgcolor="" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 8px">Mail-ID: Rq3uwJlsSOdD3U0uCc3UWoiLhQCkxjBy</span></div><div></div></div></td>
          </tr>
        </tbody>
      </table></td>
            </tr>
          </tbody>
        </table></td>
          </tr>
        </tbody>
      </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="12ddeda2-0995-4bc8-a25a-7b54c4066b41">
        <tbody>
          <tr>
            <td style="font-size:6px; line-height:10px; padding:20px 0px 20px 0px;" valign="top" align="center">
              <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:13% !important; width:13%; height:auto !important;" width="104" alt="" data-proportionally-constrained="true" data-responsive="true" src="http://cdn.mcauto-images-production.sendgrid.net/1de9ff722efdbc70/9526be74-183a-4e7a-8d8d-f8c534cdac1e/2864x1024.png">
            </td>
          </tr>
        </tbody>
      </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="8f3334f2-8e27-4aef-b2bc-07e4ea7bbd3f" data-mc-module-version="2019-10-22">
        <tbody>
          <tr>
            <td style="padding:10px 0px 3px 0px; line-height:10px; text-align:inherit;" height="100%" valign="top" bgcolor="" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(23, 20, 31); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; float: none; display: inline; font-size: 11px">Copyright © 2020 FiveMods.net or its subsidaries and affiliates. All rights reserved</span><span style="color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(23, 20, 31); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; float: none; display: inline">.</span></div><div></div></div></td>
          </tr>
        </tbody>
      </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="c26b4a21-c514-4941-a9ea-dfc94c48c464" data-mc-module-version="2019-10-22">
        <tbody>
          <tr>
            <td style="padding:18px 0px 18px 0px; line-height:10px; text-align:inherit;" height="100%" valign="top" bgcolor="" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 8px; color: #c9c9db">FiveMods.net is not affiliated with Rockstar Games, Rockstar North, GTA5, Take-Two Interactive, FiveM or the CitizenFX Collective. Legal information are listed in the Terms of Service and Legal Notice.<br>
    All gamecontent and trademarks are the property of their respective owners - all rights reserved.</span></div>
    <div style="font-family: inherit; text-align: center"><br></div>
    <div style="font-family: inherit; text-align: center"><span style="font-size: 8px; color: #c9c9db">This mail was sent to <a href="mailto://'.$email.'">'.$email.'</a>. You can change your <a href="https://fivemods.net/account/">email subscription preferences</a> at any time.</span></div><div></div></div></td>
          </tr>
        </tbody>
      </table></td>
                                          </tr>
                                        </table>
                                        <!--[if mso]>
                                      </td>
                                    </tr>
                                  </table>
                                </center>
                                <![endif]-->
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
          </center>
        </body>
      </html>';
    $subject = "FiveMods.net - Account removal for $_SESSION[user_username]";

    $headers = array(
        'Authorization: Bearer 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',
        'Content-Type: application/json'
    );

    $data = array(
        "personalizations" => array(
            array(
                "to" => array(
                    array(
                        "email" => $email,
                        "name" => $name
                    )
                )
            )
        ),
        "from" => array(
            "email" => "account@fivemods.net",
            "name" => "FiveMods.net"
        ),
        "subject" => $subject,
        "content" => array(
            array(
                "type" => "text/html",
                "value" => $body
            )
        )
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
    $_SESSION['success'] = '<div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Successfully requested! </strong> We send an email to '.$_SESSION['user_email'].', please have a look.
      </div>
      ';
   }

}


if (!empty($_POST['token'])) {
   if ($_COOKIE['rm-rfv'] == $_POST['token']) {
      echo "Account got deleted, you will get logout.";

      try {
        $conn = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // sql to delete a record
        $sql = "DELETE FROM user WHERE oauth_uid=$userid";

        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Record deleted successfully";
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }

      $conn = null;

      header('location: /account/logout/?url=removal');
   }
}

?>
<section class="pt-5 pb-5">
   <div class="container">
      <div class="row d-flex justify-content-center">
      <div class="col-md-7">
         <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
         <div class="card border border-danger">
            <div class="card-body text-center p-5">
            <h3 class="pb-2 h3 mt-1">Are you sure?</h3>
            <p class="lead">After entering the security code there is no way back! We will delete your account and you will not be able to restore it.</p>
            <form action="" method="post">
               <input class="form-control mt-md-3" type="password" name="token" placeholder="Please request a token and enter the security token the bot sends you in here..">
               <a href="?r=1" class="btn btn-xs btn-round btn-sm btn-light btn-rised mt-md-3">Request token</a>
               <button type="submit" class="btn btn-xs btn-round btn-sm btn-light btn-rised mt-md-3">Finally delete!</button> <br>
               <a href="/account/">Back</a>
            </form>
            </div>
         </div>
      </div>
      </div>
   </div>
</section>