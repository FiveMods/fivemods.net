<?php

session_start();

$uname = htmlspecialchars($_GET['uname']);

if (empty($uname)) {
   header('location: /user/');
}

require_once('./config.php');

if (isset($_SESSION['downloadMod'])) {
   $downloadMod = $dbpdo->prepare("SELECT m_downloadlink FROM mods WHERE m_id = :id");
   $downloadMod->execute(array("id" => $_SESSION['lastDownload']));
   while ($row = $downloadMod->fetch()) {
      $downloadLink = $row['m_downloadlink'];
   }
   header("Location: $downloadLink");
   unset($_SESSION['downloadMod']);
}

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

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

   if(empty($website)) $website = "-";

   $created = date("d. M Y", strtotime($created));

   if ($blocked == '1') {
      $banned = '<b class="text text-danger">' . $lang["banned"] . '</b>';
      $youbanned = $lang['you-are-banned'];
      $line = " | ";
   } else {
      $banned = '';
   }

   if ($perms == "-1") {
      $rank = ' <small class="badge badge-danger" style="font-size: 12px;">Owner</small>';
   } elseif ($perms == "1024") {
      $rank = ' <small class="badge badge-info" style="font-size: 12px;">Helper</small>';
   } elseif ($perms == "2048") {
      $rank = ' <small class="badge badge-primary" style="font-size: 12px;">Quality Assurance</small>';
   } elseif ($perms == "4096") {
      $rank = ' <small class="badge badge-success" style="font-size: 12px;">Developer</small>';
   }
}


$statement = $pdo->prepare("SELECT m_name, COUNT(m_authorid) FROM mods RIGHT JOIN user ON user.id = mods.m_authorid WHERE user.name= ? ORDER BY m_name");
$statement->execute(array($uname));
while ($row = $statement->fetch()) {
   $publishedmods = $row['COUNT(m_authorid)'];
}

if ($_SESSION['user_id'] == $oauth_uid && $blocked == 0) {
   $editbtn = '<a href="/account/" class="text text-success" style="font-size:12px;"><i class="fas fa-user"></i> ' . $lang['edit-profile'] . '</a>';
} elseif(!empty($_SESSION['user_id'])) {
   $repbtn = '<a href="#" class="text text-danger" style="font-size:12px;" data-toggle="modal" data-target="#reportModal"><i class="fas fa-exclamation-triangle"></i> ' . $lang['report-profile'] . '</a>';
} else {
   $repbtn = '<a href="/account/" class="text text-danger" style="font-size:12px;"><i class="fas fa-exclamation-triangle"></i> Login to report.</a>';
}

$dbpdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

// Query
$articles = $dbpdo->prepare('
   SELECT SQL_CALC_FOUND_ROWS *
   FROM mods
   LEFT JOIN user ON mods.m_authorid = user.id
   WHERE name="' . $username . '"
   ORDER BY m_id DESC
   LIMIT 6;
');

$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
   .emp-profile {
      padding: 3%;
      margin-top: 3%;
      margin-bottom: 3%;
      border-radius: 0.5rem;
      background: #fff;
   }

   .profile-img {
      text-align: center;
   }

   .profile-img img {
      width: 70%;
      height: 100%;
   }

   .profile-img .file {
      position: relative;
      overflow: hidden;
      margin-top: -20%;
      width: 70%;
      border: none;
      border-radius: 0;
      font-size: 15px;
      background: #212529b8;
   }

   .profile-img .file input {
      position: absolute;
      opacity: 0;
      right: 0;
      top: 0;
   }

   .profile-edit-btn {
      border: none;
      border-radius: 1.5rem;
      width: 70%;
      padding: 2%;
      font-weight: 600;
      color: #6c757d;
      cursor: pointer;
   }

   .proile-rating {
      font-size: 12px;
      color: #818182;
      margin-top: 5%;
   }

   .proile-rating span {
      color: #495057;
      font-size: 15px;
      font-weight: 600;
   }

   .profile-head .nav-tabs {
      margin-bottom: 5%;
   }

   .profile-head .nav-tabs .nav-link {
      font-weight: 600;
      border: none;
   }

   .profile-head .nav-tabs .nav-link.active {
      border: none;
      border-bottom: 2px solid #0062cc;
   }

   .profile-tab label {
      font-weight: 600;
   }

   .profile-tab p {
      font-weight: 600;
      color: #ff8637;
   }
</style>
<?php include('./include/header-banner.php'); ?>
<div class="container emp-profile">
   <div class="row">
      <div class="col-md-4">
         <div class="profile-img">
            <img src="<?php echo $picture; ?>" class="rounded img-fluid" alt="<?php echo $username; ?>-Profile Picture" />
         </div>
      </div>
      <div class="col-md-6">
         <div class="profile-head">
            <h4><?php echo $banned . '' . $line . '' . $username . '' . $rank; ?></h4>
            
            <?php
            
            if ($premium == 1 && $blocked == 0) {
               echo '<small><i class="fas fa-crown" title="Premium content creator"></i> Premium Content Creator</small>';
            } elseif ($blocked == 1) {
               echo '<small><p class="text text-danger">' . $lang['you-are-banned'] . ' <a href="#" class="text text-danger"><u>' . $lang['whybanned'] . '</u></a></p></small>';
            }
            ?>
            <div class="pt-2">
               <hr>
               <?php

               if (!$blocked == 1) {
                  echo '<p>' . $description . '</p>';
               } else {
                  echo '';
               }
               
               if(!empty($discord)) {
                  echo '<a href="/ref?rdc=https://discord.gg/'.$discord.'" role="button" class="fab fa-discord text-primary "></a>';
               }
               if(!empty($twitter)) {
                  echo '<a href="/ref?rdc=https://twitter.com/'.$twitter.'" role="button" class="fab fa-twitter fa-md text-primary smallButton"></a>';
               }
               if(!empty($instagram)) {
               echo '<a href="/ref?rdc=https://instagram.com/'.$instagram.'" role="button" class="fab fa-instagram fa-md text-primary smallButton"></a>';
               }
               if(!empty($youtube)) {
                  echo '<a href="/ref?rdc=https://youtube.com/'.$youtube.'" role="button" class="fab fa-youtube fa-md text-primary smallButton"></a>';
               }
               if(!empty($github)) {
                  echo '<a href="/ref?rdc=https://github.com/'.$github.'" role="button" class="fab fa-github fa-md text-primary smallButton"></a>';
               }
               ?>
            </div>
            <div class="pt-5">
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?php echo $lang['about'] ?></a>
               </li>
               <!--<li class="nav-item">
                  <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="true"><?php echo $lang['social-media'] ?></a>
               </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo $lang['activity'] ?></a>
               </li> -->
            </ul>
         </div>
      </div>
      <div class="col-md-2">

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
   <?php

   if ($blocked == 1) {
      echo '';
   } else {
      echo '<div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-8">
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
            <!--
            <div class="tab-pane fade show" id="social" role="tabpanel" aria-labelledby="social-tab">
               <div class="row">
                  <div class="col-md-6">
                     <label>Discord</label>
                  </div>
                  <div class="col-md-6">
                     <p><a href="/ref?rdc=https://discord.com/users/' . urlencode($discord) . '" target="_blank">' . $discord . '</a></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>Twitter</label>
                  </div>
                  <div class="col-md-6">
                     <p><a href="/ref?rdc=https://twitter.com/' . urlencode($twitter) . '" target="_blank">' . $twitter . '</a></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>YouTube</label>
                  </div>
                  <div class="col-md-6">
                     <p><a href="/ref?rdc=https://youtube.com/' . urlencode($youtube) . '" target="_blank">' . $youtube . '</a></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>Instagram</label>
                  </div>
                  <div class="col-md-6">
                     <p><a href="/ref?rdc=https://instagram.com/' . urlencode($instagram) . '" target="_blank">' . $instagram . '</a></p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>GitHub</label>
                  </div>
                  <div class="col-md-6">
                  <p><a href="/ref?rdc=https://github.com/' . urlencode($github) . '" target="_blank">' . $github . '</a></p>
                  </div>
               </div>
            </div>
            -->
            <!-- Activity not working nor planned yet -->
            <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
               <div class="row">
                  <div class="col-md-6">
                     <label>18.07.2020</label>
                  </div>
                  <div class="col-md-6">
                     <p>Got accepted for Partner program</p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>17.07.2020</label>
                  </div>
                  <div class="col-md-6">
                     <p>Uploaded Mod: Jacks Airport reloaded</p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>17.07.2020</label>
                  </div>
                  <div class="col-md-6">
                     <p>Uploaded Mod: Jacks Airport got fucked</p>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label>17.07.2020</label>
                  </div>
                  <div class="col-md-6">
                     <p>Account got created</p>
                  </div>
               </div>
            </div> -->
         </div>
      </div>
   </div>';
   }
   ?>
</div>
<section class="pt-1 pb-1 bg-dark">
   <div class="container-fluid">
      <div class="row d-flex">
         <div class="col-md-12">
            <div class="card bg-transparent text-light text-center border-0">
               <div class="card-body pt-3 pb-1">
                  <p class="lead pb-0 mb-1"><?php echo $lang['join-partner']; ?>
                     <a href="/partner-program/" class="btn btn-xs  btn-sm btn-light btn-rised ml-md-4"><?php echo $lang['click-here']; ?></a>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
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
               <div class="col-md-4">
                  <div class="loader-wrapper">
                     <span class="loader"><span class="loader-inner"></span></span>
                  </div>
                  <div class="card mb-4 shadow-sm <?php echo $do; ?>">
                     <a href="/product/<?php echo $article['m_id']; ?>/">
                        <img class="card-img-top img-fluid" style="width:350px;height:196px;" async=on src="<?php echo explode(" ", $article['m_picture'])[0]; ?>" alt="<?php echo $article['m_name']; ?>-IMAGE">
                        <?php 
                        if (!empty($article['m_price'])) {
                           echo '<small class="badge badge-info ml-2" style="font-size:9px;">Paid product</small>';
                        } 
                        ?>
                        <small class="badge badge-primary ml-2" style="font-size:9px;"><i class="fas fa-tag mr-1"></i> <?php echo $article['m_category']; ?> </small>
                        <?php
                        if (!empty($article['m_tags'])) {
                           for ($i = 0; $i < count(explode(",", $article['m_tags'])); $i++) {
                              echo '<small class="badge badge-primary ml-2" style="font-size:9px;"><i class="fas fa-tag mr-1"></i> ' . explode(",", $article['m_tags'])[$i] . ' </small>';
                           }
                        }
                        ?>
                     </a>
                     <div class="card-body">
                        <a href="/product/<?php echo $article['m_id']; ?>/" class="<?php echo $css_text ?>">
                           <h5 class="card-topic"><?php echo $article['m_name']; ?></h5>
                        </a>
                        <p class="card-text"><?php echo str_replace("<br />", " ", $article['m_predescription']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                           <?php 
                           
                           if (empty($article['m_price'])) {
                              echo '<div class="btn-group">
                              <form action="/helper/manage.php?o=index&download='.$article['m_id'].'" method="post">
                                 <button type="submit" class="btn btn-sm btn-outline-success">'.$lang['download'].'</button>
                              </form>
                              <button type="button" class="btn btn-sm btn-success" title="'.number_format($article['m_downloads']).' downloads">'.$donwloads . $suffix.' <i class="fas fa-download"></i></button>
                           </div>';
                           } else {
                              echo '<div class="btn-group">
                              <form action="/product/'.$article['m_id'].'/" method="post">
                                 <button type="submit" class="btn btn-sm btn-outline-info">Purchase</button>
                              </form>
                              <button type="button" class="btn btn-sm btn-info" title="'.$article['m_price'].'€">'.$article['m_price'].'€</button>
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