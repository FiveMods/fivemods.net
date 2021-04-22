<?php

session_start();

$uname = htmlspecialchars($_GET['uname']);

if (empty($uname)) {
   header('location: /user/');
}

require_once('./config.php');
$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
if (isset($_SESSION['downloadMod'])) {
   $downloadMod = $pdo->prepare("SELECT m_downloadlink FROM mods WHERE m_id = :id");
   $downloadMod->execute(array("id" => $_SESSION['lastDownload']));
   while ($row = $downloadMod->fetch()) {
      $downloadLink = $row['m_downloadlink'];
   }
   header("Location: $downloadLink");
   unset($_SESSION['downloadMod']);
}



$statement = $pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM user WHERE name = ?");
$statement->execute(array($uname));
while ($row = $statement->fetch()) {
   $oauth_uid = $row['oauth_uid'];
   $id = $row['id'];
   $uuid = $row['uuid'];
   $username = $row['name'];
   $mail = $row['email'];
   $picture = $row['picture'];
   $locale = $row['locale'];
   $description = $row['description'];
   $premium = $row['premium'];
   $profileviews = $row['profileviews'];
   $totaldownloads = $row['totaldownloads'];
   $discord = $row['discord'];
   $twitter = $row['twitter'];
   $youtube = $row['youtube'];
   $instagram = $row['instagram'];
   $github = $row['github'];
   $paypal = $row['paypal'];
   $blocked = $row['blocked'];
   $created = $row['created-at'];
   $updated = $row['updated-at'];
   $perms = $row['permission'];
   $website = $row['website'];
   $location = $row['locale'];

   if (empty($website)) $website = "-";

   $created = date("d. M Y", strtotime($created));

   if ($blocked == '1') {
      $banned = '<b class="text text-danger">' . $lang["banned"] . '</b>';
      $youbanned = $lang['you-are-banned'];
      $line = " | ";
   } else {
      $banned = '';
   }

   if ($perms == "-1") {
      $rank = ' <small class="profile-badge badge-owner"">Owner</small>';
   } elseif ($perms == "1024") {
      $rank = ' <small class="profile-badge badge-helper"">Helper</small>';
   } elseif ($perms == "2048") {
      $rank = ' <small class="profile-badge badge-dev"">Developer</small>';
   } elseif ($perms == "4096") {
      $rank = ' <small class="profile-badge badge-staff"">Staff Member</small>';
   } elseif ($perms == "8192") {
      $rank = ' <small class="profile-badge badge-cm"">Community Manager</small>';
   } elseif ($perms == "16384") {
      $rank = ' <small class="profile-badge badge-mgmt"">Management</small>';
   }
}

if (empty($username)) {
   header('location: /');
}


$statement = $pdo->prepare("SELECT m_name, COUNT(m_authorid) FROM mods RIGHT JOIN user ON user.id = mods.m_authorid WHERE user.name=? AND m_approved='0' AND m_blocked='0' ORDER BY m_name");
$statement->execute(array($uname));
while ($row = $statement->fetch()) {
   $publishedmods = $row['COUNT(m_authorid)'];
}

if ($_SESSION['uuid'] == $uuid && $blocked == 0) {
   $editbtn = '<a href="/account/"><svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
   <circle class="edit-button-circle button-circle" cx="27" cy="27" r="26.5" fill="#AAE8B0" stroke="#13B955"/>
   <path d="M25.75 17H17C16.337 17 15.7011 17.2634 15.2322 17.7322C14.7634 18.2011 14.5 18.837 14.5 19.5V37C14.5 37.663 14.7634 38.2989 15.2322 38.7678C15.7011 39.2366 16.337 39.5 17 39.5H34.5C35.163 39.5 35.7989 39.2366 36.2678 38.7678C36.7366 38.2989 37 37.663 37 37V28.25" stroke="#13B955" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
   <path d="M35.125 15.125C35.6223 14.6277 36.2967 14.3483 37 14.3483C37.7033 14.3483 38.3777 14.6277 38.875 15.125C39.3723 15.6223 39.6517 16.2967 39.6517 17C39.6517 17.7033 39.3723 18.3777 38.875 18.875L27 30.75L22 32L23.25 27L35.125 15.125Z" stroke="#13B955" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
   </svg></a>';
} elseif (!empty($_COOKIE['f_val']) && !empty($_COOKIE['f_key'])) {
   $repbtn = '<a href="#" data-toggle="modal" data-target="#reportModal"><svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
   <circle class="report-button-circle button-circle" cx="27" cy="27" r="26.5" fill="#FECACA" stroke="#B91C1C"/>
   <path d="M27.0731 29.1807C27.5057 29.1807 27.9206 29.0089 28.2265 28.703C28.5325 28.397 28.7043 27.9821 28.7043 27.5495V19.9956C28.7043 19.563 28.5325 19.148 28.2265 18.8421C27.9206 18.5362 27.5057 18.3643 27.0731 18.3643C26.6405 18.3643 26.2255 18.5362 25.9196 18.8421C25.6137 19.148 25.4418 19.563 25.4418 19.9956V27.5244C25.4385 27.7407 25.4783 27.9555 25.5587 28.1564C25.6392 28.3572 25.7589 28.54 25.9107 28.6941C26.0625 28.8483 26.2434 28.9707 26.443 29.0542C26.6426 29.1378 26.8567 29.1808 27.0731 29.1807V29.1807Z" fill="#B91C1C"/>
   <path d="M27.0103 34.7646C28.0498 34.7646 28.8925 33.9219 28.8925 32.8824C28.8925 31.8429 28.0498 31.0002 27.0103 31.0002C25.9708 31.0002 25.1281 31.8429 25.1281 32.8824C25.1281 33.9219 25.9708 34.7646 27.0103 34.7646Z" fill="#B91C1C"/>
   <path d="M42.5448 34.476L30.323 11.9648C29.9995 11.3703 29.5216 10.8741 28.9397 10.5283C28.3578 10.1825 27.6935 10 27.0166 10C26.3398 10 25.6754 10.1825 25.0936 10.5283C24.5117 10.8741 24.0338 11.3703 23.7102 11.9648L11.4759 34.476C11.1557 35.0508 10.9917 35.6994 11.0003 36.3573C11.0089 37.0152 11.1898 37.6594 11.525 38.2256C11.8601 38.7918 12.3378 39.2603 12.9105 39.5843C13.4831 39.9083 14.1306 40.0766 14.7886 40.0724H39.2321C39.8847 40.073 40.5262 39.904 41.0937 39.5819C41.6612 39.2598 42.1353 38.7957 42.4693 38.2351C42.8034 37.6745 42.986 37.0368 42.9992 36.3844C43.0125 35.7319 42.8559 35.0873 42.5448 34.5136V34.476ZM40.3113 36.9103C40.2002 37.0976 40.0423 37.2528 39.8531 37.3606C39.6639 37.4684 39.4499 37.5251 39.2321 37.5252H14.7886C14.5705 37.5258 14.356 37.4695 14.1662 37.3619C13.9765 37.2543 13.8181 37.0991 13.7066 36.9117C13.5951 36.7242 13.5345 36.5109 13.5306 36.2928C13.5267 36.0747 13.5797 35.8594 13.6844 35.6681L25.9061 13.1569C26.0137 12.9577 26.1731 12.7913 26.3675 12.6753C26.5619 12.5593 26.784 12.4981 27.0104 12.4981C27.2367 12.4981 27.4589 12.5593 27.6533 12.6753C27.8477 12.7913 28.0071 12.9577 28.1146 13.1569L40.3364 35.6681C40.4404 35.8595 40.4928 36.0747 40.4884 36.2925C40.484 36.5103 40.4229 36.7232 40.3113 36.9103V36.9103Z" fill="#B91C1C"/>
   </svg></a>';
} else {
   $repbtn = '<a href="/account/sign-in/"><svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
   <circle class="report-button-circle button-circle" cx="27" cy="27" r="26.5" fill="#FECACA" stroke="#B91C1C"/>
   <path d="M27.0731 29.1807C27.5057 29.1807 27.9206 29.0089 28.2265 28.703C28.5325 28.397 28.7043 27.9821 28.7043 27.5495V19.9956C28.7043 19.563 28.5325 19.148 28.2265 18.8421C27.9206 18.5362 27.5057 18.3643 27.0731 18.3643C26.6405 18.3643 26.2255 18.5362 25.9196 18.8421C25.6137 19.148 25.4418 19.563 25.4418 19.9956V27.5244C25.4385 27.7407 25.4783 27.9555 25.5587 28.1564C25.6392 28.3572 25.7589 28.54 25.9107 28.6941C26.0625 28.8483 26.2434 28.9707 26.443 29.0542C26.6426 29.1378 26.8567 29.1808 27.0731 29.1807V29.1807Z" fill="#B91C1C"/>
   <path d="M27.0103 34.7646C28.0498 34.7646 28.8925 33.9219 28.8925 32.8824C28.8925 31.8429 28.0498 31.0002 27.0103 31.0002C25.9708 31.0002 25.1281 31.8429 25.1281 32.8824C25.1281 33.9219 25.9708 34.7646 27.0103 34.7646Z" fill="#B91C1C"/>
   <path d="M42.5448 34.476L30.323 11.9648C29.9995 11.3703 29.5216 10.8741 28.9397 10.5283C28.3578 10.1825 27.6935 10 27.0166 10C26.3398 10 25.6754 10.1825 25.0936 10.5283C24.5117 10.8741 24.0338 11.3703 23.7102 11.9648L11.4759 34.476C11.1557 35.0508 10.9917 35.6994 11.0003 36.3573C11.0089 37.0152 11.1898 37.6594 11.525 38.2256C11.8601 38.7918 12.3378 39.2603 12.9105 39.5843C13.4831 39.9083 14.1306 40.0766 14.7886 40.0724H39.2321C39.8847 40.073 40.5262 39.904 41.0937 39.5819C41.6612 39.2598 42.1353 38.7957 42.4693 38.2351C42.8034 37.6745 42.986 37.0368 42.9992 36.3844C43.0125 35.7319 42.8559 35.0873 42.5448 34.5136V34.476ZM40.3113 36.9103C40.2002 37.0976 40.0423 37.2528 39.8531 37.3606C39.6639 37.4684 39.4499 37.5251 39.2321 37.5252H14.7886C14.5705 37.5258 14.356 37.4695 14.1662 37.3619C13.9765 37.2543 13.8181 37.0991 13.7066 36.9117C13.5951 36.7242 13.5345 36.5109 13.5306 36.2928C13.5267 36.0747 13.5797 35.8594 13.6844 35.6681L25.9061 13.1569C26.0137 12.9577 26.1731 12.7913 26.3675 12.6753C26.5619 12.5593 26.784 12.4981 27.0104 12.4981C27.2367 12.4981 27.4589 12.5593 27.6533 12.6753C27.8477 12.7913 28.0071 12.9577 28.1146 13.1569L40.3364 35.6681C40.4404 35.8595 40.4928 36.0747 40.4884 36.2925C40.484 36.5103 40.4229 36.7232 40.3113 36.9103V36.9103Z" fill="#B91C1C"/>
   </svg></a>';
}

// Query
$articles = $pdo->prepare('
   SELECT SQL_CALC_FOUND_ROWS *
   FROM mods
   LEFT JOIN user ON mods.m_authorid = user.id
   WHERE name=:username
   ORDER BY m_id DESC
');

$articles->execute(array("username" => $username));
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap');

   :root {
      --badge-owner-color: #E91E63;
      --badge-helper-color: #20C581;
      --badge-dev-color: #3498DB;
      --badge-staff-color: #E88017;
      --badge-mgmt-color: #ED4545;
      --badge-cm-color: #ED6F45;
   }

   .profile-badge {
      padding: 4px 8px;
      border: solid 1px;
      border-radius: 50px;
      margin-left: 10px;
      text-align: center;
      font-family: 'Montserrat', sans-serif;
      font-size: 13px;
   }

   .badge-owner {
      color: var(--badge-owner-color);
      border-color: var(--badge-owner-color);
   }

   .badge-helper {
      color: var(--badge-helper-color);
      border-color: var(--badge-helper-color);
   }

   .badge-dev {
      color: var(--badge-dev-color);
      border-color: var(--badge-dev-color);
   }

   .badge-staff {
      color: var(--badge-staff-color);
      border-color: var(--badge-staff-color);
   }

   .badge-cm {
      color: var(--badge-cm-color);
      border-color: var(--badge-cm-color);
   }

   .badge-mgmt {
      color: var(--badge-mgmt-color);
      border-color: var(--badge-mgmt-color);
   }

   .emp-profile {
      padding: 3%;
      margin-top: 3%;
      margin-bottom: 3%;
      border-radius: 1rem;
      background: rgba(255, 255, 255, 0.6);
      display: flex;
      flex-direction: row;
      /* opacity: 0.6; */
   }

   .profile-img {
      margin-right: 30px;
      text-align: center;
      position: sticky;
      position: -webkit-sticky;
      top: 120px;
   }

   .profile-img img {
      border-radius: 50%;
      width: 70%;
      max-width: 200px;
   }

   .left-col-container {
      flex: 4;
   }

   .mid-col-container {
      flex: 6;
   }

   .right-col-container {
      flex: 2;
      display: flex;
      justify-content: flex-end;
   }

   .right-col-container a {
      height: fit-content;
   }

   .right-col-container svg {
      width: 40px;
   }

   .button-circle {
      transition: fill 100ms ease;
   }

   .right-col-container a:hover .report-button-circle {
      fill: #FFA1A1;
   }

   .right-col-container a:hover .edit-button-circle {
      fill: #83F18E;
   }

   .user-description {
      margin: 14px 0;
   }

   .profile-top {
      display: flex;
      align-items: center;
   }

   .user-about {
      margin-top: 2.5rem;
   }

   .user-about-content {
      margin-top: 1rem;
   }
   
   .social-button {
      margin-right: 1rem;
      color: #1B1F23;
      font-size: 16px;
      text-decoration: none !important;
      transition: all 100ms ease;
   }

   .social-button:hover {
      color: #1B1F23;
      opacity: .75;
   }

   hr {
      margin: 8px 0;
   }

   .socials {
      margin: 6px 0 8px 0;
   }
   
   .profile-tab label {
      font-weight: 600;
   }

   .profile-tab p {
      font-weight: 600;
      color: #ff8637;
   }
   
   .join-partner {
      padding: 16px;
      display: flex;
      justify-content: center;
   }

   .join-partner p {
      margin: 0 !important;
   }

   .user-about h5 {
      font-size: 19px !important;
   }

   .partner-button {
      border-radius: 2px !important;
   }

   @media screen and (max-width: 768px) {
      .emp-profile {
         flex-direction: column;
      }

      .profile-img {
         margin: 0 0 30px 0;
      }
   }

</style>
<?php include('./include/header-banner.php'); ?>
<div class="container emp-profile shadow1">
   <div class="left-col-container">
      <div class="profile-img">
         <img src="https://img-cdn.fivemods.net/unsafe/229x229/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/<?php echo $picture; ?>" alt="<?php echo $username; ?>-Profile Picture" />
      </div>
   </div>
   <div class="mid-col-container">
      <div class="profile-head">
         <h4 class="profile-top"><?php echo $banned . '' . $line . '' . $username . '' . $rank; ?></h4>

         <?php

         if ($premium == 1 && $blocked == 0) {
            echo '<small><i class="fas fa-crown" title="Premium content creator"></i> Premium Content Creator</small>';
         } elseif ($blocked == 1) {
            echo '<small><p class="text text-danger">' . $lang['you-are-banned'] . ' <a href="#" class="text text-danger"><u>' . $lang['whybanned'] . '</u></a></p></small>';
         }
         
         if (!$blocked == 1) {
            echo '
         <div class="user-description">
            <hr>
            <div class="socials">';
            if (!empty($discord)) {
               echo '<a href="/ref?rdc=https://discord.gg/' . $discord . '" role="button" class="fab fa-discord social-button"></a>';
            }
            if (!empty($twitter)) {
               echo '<a href="/ref?rdc=https://twitter.com/' . $twitter . '" role="button" class="fab fa-twitter fa-md social-button"></a>';
            }
            if (!empty($instagram)) {
               echo '<a href="/ref?rdc=https://instagram.com/' . $instagram . '" role="button" class="fab fa-instagram fa-md social-button"></a>';
            }
            if (!empty($youtube)) {
               echo '<a href="/ref?rdc=https://youtube.com/' . $youtube . '" role="button" class="fab fa-youtube fa-md social-button"></a>';
            }
            if (!empty($github)) {
               echo '<a href="/ref?rdc=https://github.com/' . $github . '" role="button" class="fab fa-github fa-md social-button"></a>';
            }
            echo '
            </div>
            <p>' . $description . '</p></div>';
            }
            ?>
      </div>
      <?php
      if ($blocked == 1) {
         echo '';
      } else {
         echo '
      <div class="user-about">
         <h5 clas="user-about-title">' . $lang['about'] . '</h5>
         <hr>
            <div class="user-about-content">
               <div class="tab-content profile-tab" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                     <div class="row">
                        <div class="col-md-6">
                           <label>' . $lang['username'] . '</label>
                        </div>
                        <div class="col-md-6">
                           <p>' . $username . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label>' . $lang['joined-at'] . '</label>
                        </div>
                        <div class="col-md-6">
                           <p>' . $created . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label>Website</label>
                        </div>
                        <div class="col-md-6">
                           <a href="/ref/?rdc=' . $website . '"><p>' . $website . '</p></a>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label>' . $lang['published-mods'] . '</label>
                        </div>
                        <div class="col-md-6">
                           <p>' . $publishedmods . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label>Total Downloads</label>
                        </div>
                        <div class="col-md-6">
                           <p>' . $totaldownloads . '</p>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label>Location</label>
                        </div>
                        <div class="col-md-6">
                           <p>' . $location . '</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>';
   }
   ?>
   </div>
   <div class="right-col-container">
      <?php
      if ($blocked == 0) {
         echo $repbtn;
         echo $editbtn;
      } elseif ($blocked == 1) {
         $repbtn = "";
         $editbtn = "";
         echo '';
      }
      ?>
   </div>
   
</div>
<section class="join-partner bg-dark">
   <p class="lead pb-0 mb-1 text-light"><?php echo $lang['join-partner']; ?>
      <a href="/partner-program/" class="btn btn-xs btn-sm btn-light btn-rised ml-md-4 partner-button"><?php echo $lang['click-here']; ?></a>
   </p>
</section>

<?php if(!empty($articles)): ?>
<section class="">
   <footer class="pt-5 pb-3">
      <div class="container">
         <div class="row text-center">
            <div class="col">
               <h4><?php echo $lang['more-mods'] . " " . $username; ?></h4>
            </div>
         </div>
      </div>
   </footer>
</section>
<section class="pt-5 pb-5">
   <div class="container">
      <div class="row">

         <?php foreach ($articles as $article) : ?>
            <?php

            if ($article['m_downloads'] >= 1000 && $article['m_downloads'] < 1000000) {
               $suffix = "k";
               $donwloads = $article['m_downloads'] / 1000;
               $donwloads = round($donwloads, 1);
            } elseif ($article['m_downloads'] >= 1000000) {
               $suffix = "M";
               $donwloads = $article['m_downloads'] / 1000000;
               $donwloads = round($donwloads, 1);
            } else {
               $suffix = "";
               $donwloads = $article['m_downloads'];
            }

            if ($article['m_approved'] != "0" || $article['m_blocked'] != "0") {
               continue;
            }

            ?>
            <div class="col-md-4 d-flex align-items-stretch">
               <div class="card mb-4 shadow-sm <?php echo $do; ?>">
                  <a href="/product/<?php echo $article['m_id']; ?>/">
                     <img class="card-img-top img-fluid rounded shadow1 cover" async=on src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/<?php echo explode(" ", $article['m_picture'])[0]; ?>" alt="<?php echo $article['m_name']; ?>-IMAGE">
                     <?php
                     if (!empty($article['m_price'])) {
                        echo '<small class="badge badge-info ml-2" style="font-size:9px;">Paid product</small>';
                     }
                     ?>
                  </a>
                  <div class="card-body">
                     <a href="/product/<?php echo $article['m_id']; ?>/" class="<?php echo $css_text ?>">
                        <h5 class="card-topic"><?php echo $article['m_name']; ?></h5>
                     </a>
                     <p class="card-text"><?php echo str_replace("<br />", " ", substr($article['m_description'], 0, 130) . "...");; ?></p>
                     <div class="d-flex justify-content-between align-items-center">
                        <?php

                        if (empty($article['m_price'])) {
                           echo '<div class="btn-group">
                              <form action="/helper/manage.php?o=index&download=' . $article['m_id'] . '" method="post">
                                 <button type="submit" class="btn btn-sm btn-outline-success">' . $lang['download'] . '</button>
                              </form>
                              <button type="button" class="btn btn-sm btn-success" title="' . number_format($article['m_downloads']) . ' downloads">' . $donwloads . $suffix . ' <i class="fas fa-download"></i></button>
                           </div>';
                        } else {
                           echo '<div class="btn-group">
                              <form action="/product/' . $article['m_id'] . '/" method="post">
                                 <button type="submit" class="btn btn-sm btn-outline-info">Purchase</button>
                              </form>
                              <button type="button" class="btn btn-sm btn-info" title="' . $article['m_price'] . '€">' . $article['m_price'] . '€</button>
                           </div>';
                        }

                        ?>
                        <small class="text-muted"><?php echo $lang['by']; ?> <a href="/user/<?php echo $article['name']; ?>"><b><?php echo $article['name']; ?></b></a> <?php if ($article['premium'] == 1) {
                                                                                                                                                                           echo '<a href="/partner-program/" class="fas fa-crown text text-muted" title="Premium content creator"></a>';
                                                                                                                                                                        } ?></small>
                     </div>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>
<?php endif; ?>
<section>
   <!-- Modal -->
   <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="reportModal"><?php echo $lang['report-profile']; ?></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form id="ajax-register-form" action="/helper/manage.php" method="post" role="form" autocomplete="off">
                  <h4>
                     Message our discord support with the suspicious profile.
                  </h4>
                  <div class="form-group">
                     <div class="row justify-content-center text-center">
                        <div class="col-xs-6 col-xs-offset-3">
                           <button type="button" class="form-control btn btn-primary" data-dismiss="modal" aria-label="Close"><?php echo $lang['close']; ?></button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<?php 

$pdo = null;

?>