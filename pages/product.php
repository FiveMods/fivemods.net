<?php
session_start();
include('./include/header-banner.php');
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

if ($_GET['id']) {
   $nameID = $_GET['id'];
   $sql = "SELECT * FROM mods WHERE m_id = '$nameID' AND m_approved=0 AND m_blocked=0"; 
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $name = $row['m_name'];
         $description = $row['m_description'];
         $img = $row['m_picture'];
         $tags = $row['m_tags'];
         $cat = $row['m_category'];
         $download = $row['m_downloadlink'];
         $required = $row['m_requiredmod'];
         $userid = $row['m_authorid'];
         $rating = $row['m_rating'];
         $changelog = $row['m_changelog'];
         $downloads = $row['m_downloads'];
         $uploaded = $row['m_created-at'];
         $m_price = $row['m_price'];
         $m_prices = $row['m_prices'];

         $tagArray = explode(",", $tags);
         $imgArray = explode(" ", $img);
         $changelogArray = explode("|end", $changelog);

         $number = 0;
         if (!empty($rating)) {
            $rateArray = explode(" ", $rating);
            $number = 0;
            for ($i = 0; $i < count($rateArray); $i++) {
               $number = $number + $rateArray[$i];
            }
            $number = round($number / count($rateArray));
         }

         
         $description = preg_replace('/###\s(.+)/', "<h5>$1</h5>", $description);
         $description = preg_replace('/##\s(.+)/', "<h4>$1</h4>", $description);
         $description = preg_replace('/#\s(.+)/', "<h3>$1</h3>", $description);
         $description = preg_replace('/\*\*(.+)\*\*/', "<b>$1</b>", $description);
         $description = preg_replace('/\*(.+)\*/', "<i>$1</i>", $description);
         $description = preg_replace('/(^(?!\()|\s)(https?:\/\/(?:www\.|(?!www))youtube\.com\/)([A-Za-z0-9-_][^\s|<]{2,})/', "<iframe id=\"ytplayer\" type=\"text/html\" width=\"544\" height=\"306\" src=\"http://www.youtube.com/embed/$3\"></iframe>", $description);
         $description = preg_replace('/(^(?!\()|\s)((https?).*\.(gif|jpe?g|bmp|png))/', "<img src=\"$2\" alt=\"$2\" style=\"max-width: 100%;\">", $description);
         $description = preg_replace('/\[(.+)\]\((.+)\)/', "<a href=\"/ref?rdc=$2\">$1</a>", $description);
         $description = preg_replace('/(\!\[\])\((.+)\)/', "<img src=\"$2\" style=\"max-width: 100%;\">", $description);
         $description = preg_replace('/(^(?!\()|\s)(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s|\)|\<]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s|\)|\<]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s|\)|\<]{2,}|www\.[a-zA-Z0-9]+\.[^\s|\)|\<]{2,})/', "<a href=\"/ref?rdc=$2$3\">$2$3</a>", $description);
         $description = preg_replace('/(\`\`\`)([^\`]+)(\`\`\`)/s', "<code style=\"max-width: 100%;\">$2<br /></code>", $description);
         $description = preg_replace('/@([A-Za-z0-9-_]+[^\s|\W]{1,})/', "<a href=\"/user/$1\">@$1</a>$2", $description);
         
      }
   } else {
      header('location: /');
   }
   $allowRate = true;
   $sql = "SELECT user_id from rate WHERE mod_id = $nameID";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         if($row['user_id'] == $_SESSION['user_iid']) {
            $allowRate = false;
            break;
         }
      }
   }


   $sql = "SELECT * FROM user WHERE id = '$userid'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $username = $row['name'];
         $userimg = $row['picture'];
      }
   }

   $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

   $url = $actual_link;
   $parts = explode('/', $url);
   $urlNumber = $parts[count($parts) - 2];

   
   if (strpos($url, 'download') != FALSE) {
      header('location: '.$download);
   }

   echo '<script>console.log("Number: '.$urlNumber.'");</script>';

   if (isset($_SESSION['downloadMod'])) {
      if($_SESSION['lastDownload'] == $nameID) {
         $downloads = $_SESSION['downloadMod'];
         header("Location: $download");

      } else {
         $downloadMod = $dbpdo->prepare("SELECT m_downloadlink FROM mods WHERE m_id = :id");
         $downloadMod->execute(array("id" => $_SESSION['lastDownload']));
         while($row = $downloadMod->fetch()) {
            $downloadLink = $row['m_downloadlink'];
         }
         header("Location: $downloadLink");
      }
      unset($_SESSION['downloadMod']);
   } 
} else {
   header('location: /');
}


?>

<style>
   code {
      margin-bottom: 1em;
      padding: 12px 8px;
      padding-bottom: 20px !ie7;
      width: 650px !important;
      max-height: 600px;
      overflow: auto;
      background-color: #eff0f1;
      border-radius: 3px;
      display: inline-block;
      color: black;
   }

   .tag {
      margin-right: 5px;
   }

   .report {
      right: 0px;
      position: absolute;
      margin-right: 1em;
   }

   .rating {
      float: left;

   }

   /* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
      follow these rules. Every browser that supports :checked also supports :not(), so
      it doesn’t make the test unnecessarily selective */
   .rating:not(:checked)>input {
      position: absolute;
      top: -9999px;
      clip: rect(0, 0, 0, 0);
   }

   .rating:not(:checked)>label {
      float: right;
      width: 1em;
      /* padding:0 .1em; */
      margin-right: 9.5%;
      overflow: hidden;
      white-space: nowrap;
      cursor: pointer;
      font-size: 300%;
      /* line-height:1.2; */
      color: #ddd;
   }

   .rating:not(:checked)>label:before {
      content: '★ ';
   }

   .rating>input:checked~label {
      color: dodgerblue;

   }

   .rating:not(:checked)>label:hover,
   .rating:not(:checked)>label:hover~label {
      color: dodgerblue;

   }

   .rating>input:checked+label:hover,
   .rating>input:checked+label:hover~label,
   .rating>input:checked~label:hover,
   .rating>input:checked~label:hover~label,
   .rating>label:hover~input:checked~label {
      color: dodgerblue;

   }

   .rating>label:active {
      position: relative;
      top: 2px;
      left: 2px;
   }

   .center {
      text-align: center;
   }
</style>

<section class="pt-5 pb-5">
   <div class="container">
      <?php
         if(isset($_SESSION['rated'])) {
      ?>
      <div class="alert alert-success alert-dismissible fade show center" role="alert">
         <strong>Success!</strong> You've successfully rated this mod with <?php echo $_SESSION['rated'];?> stars!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <?php
         unset($_SESSION['rated']);
         }
      ?>
      <?php 
   
         if ($_SESSION['successpurchased'] == TRUE) {
            echo '<div class="alert alert-success alert-dismissible fade show center" role="alert">
            <strong>Success!</strong> You\'ve successfully purchased this mod!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>';
         $_SESSION['successpurchased'] == FALSE;
         unset($_SESSION['successpurchased']);
         }

      ?>
      <div class="row">
         <div class="col-md-6 text-center">
            <div id="imgCarousel" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#imgCarousel" data-slide-to="0" class="active"></li>
                  <?php
                  for ($i=1; $i < count($imgArray); $i++) {
                     echo '<li data-target="#imgCarousel" data-slide-to="' . $i . '"></li>';
                  }
                  ?>
               </ol>
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <img src="<?php echo $imgArray[0]; ?>" class="d-block w-100 img-fluid" style="width:540px;height:304px;" alt="Mod Picture">
                     </div>
                     <?php
                        for ($i=1; $i < count($imgArray); $i++) {
                           echo '<div class="carousel-item">
                                    <img src="' . $imgArray[$i] . '" class="d-block w-100 img-fluid" style="width:540px;height:304px;" alt="Mod Picture">
                                 </div>';
                        }
                     ?>
                  </div>
                  <a class="carousel-control-prev" href="#imgCarousel" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#imgCarousel" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                  </a>
               </div>
            <br><br>
            <?php

            if (!empty($changelog)) {
               echo '<div class="row">
                           <div class="col">
                              <a href="#" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#changeModal">Show Changelog</a>
                           </div>
                        </div>';
            }
            if ($_SESSION['user_iid'] and $allowRate) {
               echo '<div class="row pt-2">
                              <div class="col">
                                 <a class="btn btn-block btn-sm btn-primary" data-toggle="collapse" href="#rate" role="button" aria-expanded="false" aria-controls="rate">Rate this Mod!</a>
                              </div>
                           </div>';
            }
            ?>
            <div class="collapse" id="rate">
               <div class="card card-body border border-primary">
                  <div class="rating">
                     <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars">5 stars</label>
                     <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars">4 stars</label>
                     <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">3 stars</label>
                     <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars">2 stars</label>
                     <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">1 star</label>
                     <br>
                     <button onclick="getRating()" class="btn btn-block btn-sm btn-primary"><?php echo $lang['submit']; ?></button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6 mt-5 mt-md-2 text-center text-md-left">
            <h2 class="mt-0 text-left"><?php echo $name; ?></h2>
            <small class="text-muted"><?php if (empty($m_price)) {
               echo 'Downloads';
            } else {
               echo 'Purchases';
            } ?>: <?php echo $downloads . ' | Uploaded: ' . date("d. M Y", strtotime($uploaded)); if ($_SESSION['user_permission'] == "-1") {
               echo " | <u title='Not seeable for everyone.'>Estimated income: ".($downloads/1000).'€</u>';
            } ?> </small>



            <p class="lead mt-2 mb-3 primary-color text-left">
            <?php if($_SESSION['user_iid']):?>
               <div class="report">
                  <a href="#" class="text text-danger" style="font-size:12px;" data-toggle="modal" data-target="#reportModal"><i class="fas fa-exclamation-triangle"></i> <?php echo $lang['report-mod']; ?></a>
               </div>
               <?php endif;?>
               <div class="" style="color:#FFBF00;" title="This mod got <?php if (!empty($number)) echo $number;
                                                                        else echo '0'; ?> / 5 Stars (<?php echo count($rateArray); ?> ratings)">
                  <?php
                  if (!empty($number)) {
                     for ($i = 0; $i < $number; $i++) {
                        echo '<i class="fas fa-star"></i>';
                     }
                     for ($i = 0; $i < (5 - $number); $i++) {
                        echo '<i class="far fa-star"></i>';
                     }
                  } else {
                     for ($i = 0; $i < 5; $i++) {
                        echo '<i class="far fa-star"></i>';
                     }
                  }
                  ?>
                  <b class="text text-dark">(<?php echo count($rateArray); ?>)</b>
               </div>

               <?php 
               
               if (empty($m_price)) {
                  echo '<b class="badge badge-success">'.$lang['free-download'].'</b>';
               } else {
                  echo '<b class="badge badge-info">Paid product</b>';
               }

               ?>
               
               <?php
               echo '<a href="/search/?query=' . $cat . '&cat=1&submit-search=" class="badge badge-primary tag">' . $cat . '</a>';
               for ($i = 0; $i < count($tagArray); $i++) {
                  echo '<a href="/search/?query=' . $cat . '&cat=1&catset=' . $tagArray[$i] . '&submit-search=" class="badge badge-primary tag">' . $tagArray[$i] . '</a>';
               }

               ?>
            </p>

            <?php
            
            if (empty($m_price)) {
               echo '<form action="/helper/manage.php?o=product&download='.$nameID.'" method="post">
               <button type="submit" class="btn btn-block btn-lg btn-success">'.$lang['download-now'].'</button>
            </form>';
            } else {
               echo '
               <div class="col-12 row">
               <button data-toggle="modal" data-target="#reqPur" class="btn btn-info" style="width: 85%">Purchase now</button><span class="caret"></span>
               <button type="text" class="btn btn-outline-info" style="width: 15%;">'.$m_price.'€</button><span class="caret"></span>

            ';
            }

            ?>
            <?php
            if (!empty($required)) {
               if (strpos($required, "fivemods.net")) {
                  echo ' <a href="' . urlencode($required) . '" class="btn btn-block btn-sm btn-outline-primary">Required Mod</a>';
               } else {
                  echo ' <a href="/ref?rdc=' . $required . '" class="btn btn-block btn-sm btn-outline-primary">Required Mod</a>';
               }
            }
            ?>

            <h5 class="mt-4 text-left"><?php echo $lang['description']; ?></h5>
            <hr>
            <div class="text-left"><?php echo $description; ?></div>
         </div>
      </div>
   </div>
</section>

<script>
   function getRating() {
      var star1 = document.getElementById("star1").checked;
      var star2 = document.getElementById("star2").checked;
      var star3 = document.getElementById("star3").checked;
      var star4 = document.getElementById("star4").checked;
      var star5 = document.getElementById("star5").checked;

      if (star1 === true) {
         var rating = 1
      } else if (star2 === true) {
         var rating = 2
      } else if (star3 === true) {
         var rating = 3
      } else if (star4 === true) {
         var rating = 4
      } else if (star5 === true) {
         var rating = 5
      }

      window.location.href = "/helper/manage.php?rate=1&id=<?php echo $nameID; ?>_" + rating + "&userid=<?php echo $_SESSION['user_iid'];?>";
   }
</script>


<section class="mt-3 pb-1 bg-dark">
   <div class="container-fluid">
      <div class="row d-flex">
         <div class="col-md-12">
            <div class="card bg-transparent text-light text-center border-0">
               <div class="card-body pt-3 pb-1">

                  <p class="lead pb-0 mb-1"><a href="/user/<?php echo $username; ?>"><img class="pr-3" async=on src="<?php echo $userimg; ?>" height="32" alt="Profile Picture"></a><?php echo $lang['made-by']; ?>
                     <a href="/user/<?php echo $username; ?>"><?php echo $username; ?></a>.
                     <a href="/user/<?php echo $username; ?>" class="btn btn-xs  btn-sm btn-light btn-rised ml-md-4">Show more </a>
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
               <?php
               $sql = "SELECT * FROM mods WHERE m_authorid = '$userid' AND m_approved=0 AND m_blocked=0 ORDER BY m_downloads ASC";
               $result = $conn->query($sql);
               if ($result->num_rows > 1) {
                  echo '<h4>' . $lang['other-mods'] . '</h4>';
               } else {
                  echo '<h4>' . $lang['famous-mods'] . '</h4>';
               }
               ?>
            </div>
         </div>
      </div>
   </footer>
</section>
<section class="pt-5 pb-5">
   <div class="container">
      <div class="row">
         <?php
         if ($result->num_rows > 1) {
            $mods = 0;
            while ($row = $result->fetch_assoc()) {
               $id = $row['m_id'];
               $name = $row['m_name'];
               $predescription = $row['m_predescription'];
               $img = explode(" ", $row['m_picture'])[0];
               $tags = explode(",", $row['m_tags']);
               $cat = $row['m_category'];
               $downloads = $row['m_downloads'];
               $m_price = $row['m_price'];
               $m_prices = $row['m_prices'];

               if (!empty($m_price)) {
                  $do = 'border border-info';
               } 

               if ($id != $_GET['id'] && $mods < 9 && empty($m_price)) {
                  $mods++;
                  echo '<div class="col-md-4">
                                 <div class="card mb-4 shadow-sm ">
                                    <a href="/product/' . $id . '/">
                                    <img async=on class="card-img-top img-fluid" style="width:350px;height:196px;" src="' . $img . '" alt="' . $img . '-Image (display)">
                                    <small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $cat . ' </small>';
                  for ($i = 0; $i < count($tags); $i++) {
                     echo '<small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $tags[$i] . ' </small>';
                  }
                  echo '</a>
                                    <div class="card-body">
                                       <a href="/product/' . $id . '/" class="text text-dark">
                                          <h5 class="card-topic">' . $name . '</h5>
                                       </a>
                                       <p class="card-text">' . $predescription . '</p>
                                       <div class="d-flex justify-content-between align-items-center">
                                       <div class="btn-group">
                                       <form action="/helper/manage.php?o=index&download=' . $id. '" method="post">
                                          <button type="submit" class="btn btn-sm btn-outline-success">'.$lang['download'].'</button>
                                       </form>
                                       <button type="button" class="btn btn-sm btn-success" title="'.number_format($downloads).' downloads">'.$downloads.' <i class="fas fa-download"></i></button>
                                    </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>';
               } elseif ($id != $_GET['id'] && $mods < 9 && !empty($m_price)) {
                  echo '<div class="col-md-4">
                                 <div class="card mb-4 shadow-sm '.$do.'">
                                    <a href="/product/' . $id . '/">
                                    <img async=on class="card-img-top img-fluid" style="width:350px;height:196px;" src="' . $img . '" alt="' . $img . '-Image (display)">
                                    <small class="badge badge-info ml-2" style="font-size:9px;">Paid product</small>
                                    <small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $cat . ' </small>';
                  for ($i = 0; $i < count($tags); $i++) {
                     echo '<small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $tags[$i] . ' </small>';
                  }
                  echo '</a>
                                    <div class="card-body">
                                       <a href="/product/' . $id . '/" class="text text-dark">
                                          <h5 class="card-topic">' . $name . '</h5>
                                       </a>
                                       <p class="card-text">' . $predescription . '</p>
                                       <div class="d-flex justify-content-between align-items-center">
                                          <div class="btn-group">
                                          <form action="/product/'.$id.'/" method="post">
                                             <button type="submit" class="btn btn-sm btn-outline-info">Purchase</button>
                                          </form>
                                             <button type="button" class="btn btn-sm btn-info" title="'.$m_price.'€">'.$m_price.'€</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>';
               }
            }
         } else {
            $sql = "SELECT * FROM mods WHERE m_approved=0 AND m_blocked=0 ORDER BY m_downloads DESC LIMIT 7";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
               while ($row = $result->fetch_assoc()) {
                  $id = $row['m_id'];
                  $name = $row['m_name'];
                  $predescription = str_replace("<br />", " ", $row['m_predescription']);
                  $img = explode(" ", $row['m_picture'])[0];
                  $tags = explode(",", $row['m_tags']);
                  $cat = $row['m_category'];
                  $downloads = $row['m_downloads'];
                  if ($id != $_GET['id'] && $mods < 9 && empty($m_price)) {
                     echo '<div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                       <a href="/product/' . $id . '/">
                                       <img async=on class="card-img-top img-fluid" style="width:350px;height:196px;" src="' . $img . '" alt="' . $img . '-Image (display)">
                                       <small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $cat . ' </small>';
                     for ($i = 0; $i < count($tags); $i++) {
                        echo '<small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $tags[$i] . ' </small>';
                     }
                     echo '</a>
                                       <div class="card-body">
                                          <a href="/product/' . $id . '/" class="text text-dark">
                                             <h5 class="card-topic">' . $name . '</h5>
                                          </a>
                                          <p class="card-text">' . $predescription . '</p>
                                          <div class="d-flex justify-content-between align-items-center">
                                             <div class="btn-group">
                                                <a href="/helper/manage.php?o=product&download='. $id .'" class="btn btn-sm btn-outline-success">' . $lang['download'] . '</a>
                                                <button type="button" class="btn btn-sm btn-success" title="' . $downloads . ' downloads">' . $downloads . ' <i class="fas fa-download"></i></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>';
                  } elseif ($id != $_GET['id'] && $mods < 9 && !empty($m_price)) {
                  echo '<div class="col-md-4">
                                 <div class="card mb-4 shadow-sm '.$do.'">
                                    <a href="/product/' . $id . '/">
                                    <img async=on class="card-img-top img-fluid" style="width:350px;height:196px;" src="' . $img . '" alt="' . $img . '-Image (display)">
                                    <small class="badge badge-info ml-2" style="font-size:9px;">Paid product</small>
                                    <small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $cat . ' </small>';
                  for ($i = 0; $i < count($tags); $i++) {
                     echo '<small class="badge badge-primary ml-2" style="font-size:9px;margin-top: 10px; margin-bottom: -10px"><i class="fas fa-tag mr-1"></i> ' . $tags[$i] . ' </small>';
                  }
                  echo '</a>
                                    <div class="card-body">
                                       <a href="/product/' . $id . '/" class="text text-dark">
                                          <h5 class="card-topic">' . $name . '</h5>
                                       </a>
                                       <p class="card-text">' . $predescription . '</p>
                                       <div class="d-flex justify-content-between align-items-center">
                                          <div class="btn-group">
                                          <form action="/product/'.$_id.'/" method="post">
                                             <button type="submit" class="btn btn-sm btn-outline-info">Purchase</button>
                                          </form>
                                             <button type="button" class="btn btn-sm btn-info" title="'.$m_price.'€">'.$m_price.'€</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>';
               }
               }
            }
         }
         ?>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModal" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="changeModal">Changelog / Updatelog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <?php
            for ($i = count($changelogArray) - 1; $i >= 0; $i = $i - 1) {
               echo '<h6>Changelog ' . ($i + 1) . '</h6>
                  <p>' . $changelogArray[$i] . '</p>
                  <hr>';
            }
            ?>
         </div>
      </div>
   </div>
</div>
<section>
   <!-- Modal -->
   <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="reportModal"><?php echo $lang['report-mod']; ?></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="/helper/manage.php" method="post" autocomplete="off">
                  <div class="form-group">
                     <div class="row mb-2">
                        <div class="col">
                           <label for="username">Reason<span class="text text-danger">*</span></label>
                           <select class="form-control" name="reason" required>
                              <option disabled>Select Category</option>
                              <option value="Inappropriate Pictures">Inappropriate Pictures</option>
                              <option value="Inappropriate Description">Inappropriate Description</option>
                              <option value="Harassment">Harassment</option>
                              <option value="Stolen Mod Circulation">Stolen Mod Circulation</option>
                              <option value="Required Mod Link is a virus">Required Mod Link is a virus</option>
                              <option value="Wrong Tags">Wrong Tags</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="username">Evidence<span class="text text-danger">*</span></label>
                     <input type="text" name="evidence" id="evidence" tabindex="2" class="form-control" placeholder="https://fivemods.net/link-to-evidence" required>
                  </div>
                  <div class="form-group">
                     <div class="row justify-content-center text-center">
                        <div class="col-xs-6 col-xs-offset-3">
                           <input name="modid" value="<?php echo $_GET['id']; ?>" hidden>
                           <input name="authorid" value="<?php echo $userid; ?>" hidden>
                           <input name="reportmod" value="1" hidden>
                           <button type="submit" tabindex="4" class="form-control btn btn-primary"><?php echo $lang['submit']; ?></button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade d-justify-content-center text-center bg bg-dark" style="margin:7%;" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-dismiss="myModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-dark border-bootom border-dark">
            <button type="button" class="close text text-white" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body bg bg-dark">

            <div id="imgCarousel" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#imgCarousel" data-slide-to="0" class="active"></li>
                  <?php
                  for ($i = 1; $i < count($imgArray); $i++) {
                     echo '<li data-target="#imgCarousel" data-slide-to="' . $i . '"></li>';
                  }
                  ?>
               </ol>
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <a href="#" data-toggle="modal" data-target="#myModal">
                        <img async=on src="<?php echo $imgArray[0]; ?>" class="img-fluid" alt="Mod Picture">
                  </div>
                  <?php
                  for ($i = 1; $i < count($imgArray); $i++) {
                     echo '<div class="carousel-item">
                                 <img async=on src="' . $imgArray[$i] . '" class="img-fluid" alt="Mod Picture">
                              </div>';
                  }
                  ?>
                  </a>
               </div>
               <a class="carousel-control-prev" href="#imgCarousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#imgCarousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </a>
            </div>

         </div>
      </div>
   </div>
</div>


<!-- Request Modal -->
<div class="modal fade" id="reqPur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Continue shopping?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Your current budget amounts: <?php $ch = curl_init();
                  $token = "TOzXNzpsBMyMEfehloqIeEDFOPZRzjDV6YzqjFiXPbOab0GfRcxHEC89nLDckG9MFsafPCFY4Uz2aYZW28ty4tV0KbI9c1bFLqA2";
                  $userid = $_SESSION['user_id'];

                  curl_setopt($ch, CURLOPT_URL,"http://85.214.166.192:8081");
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, "action=reqBalance&token=$token&uid=$userid");
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  $response = curl_exec($ch);
                  curl_close($ch); echo "<b>".$response."€</b><hr>"; ?>
                  <!-- Are you sure you want to buy this product?<br> -->
                  <i><b>Note:</b> After buying you can always download the product again for free!</i><br>
                <small class="text-muted">With purchasing you accept our <a href="/payment-agreement/">universal billing & payment agreement</a>, and <a href="/terms-of-service/">terms of service</a>.</small>
            </div>
            <div class="modal-footer">
                <form action="/helper/manage.php?o=index&purchase=<?php echo $nameID; ?>" method="post">
                    <input type="text" name="call" value="callFunc" hidden>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnSave" class="btn btn-info" data-toggle="modal" data-target="#reqPur">Buy now</button>
                </form>
            </div>
        </div>
    </div>
</div>