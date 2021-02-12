<?php 

require_once('./config.php');

// Connect to mysql
$dbpdo = new PDO('mysql:dbname='.$mysql['dbname'].';host='.$mysql['servername'].'', ''.$mysql['username'].'', ''.$mysql['password'].'');

// User input
$site = (int)isset($_GET['site']) ? (int)$_GET['site'] : 1;
$perPage = (int)isset($_GET['max']) && $_GET['max'] <= 100 ? (int)$_GET['max'] : 12;

// Positioning
$start = ($site > 1) ? ($site * $perPage) - $perPage : 0;

if (isset($_GET['submit-search'])) {
   $search = htmlspecialchars($_GET['query']);
} 
$searchDB = "%".$search."%";

// Query
$articles = $dbpdo->prepare("
   SELECT SQL_CALC_FOUND_ROWS *
   FROM mods
   LEFT JOIN user ON mods.m_authorid = user.id
   WHERE m_id LIKE :search AND m_approved = 0 OR m_name LIKE :search AND m_approved = 0 OR m_category LIKE :search AND m_approved = 0 OR
   name LIKE :search AND m_approved = 0 OR m_tags LIKE :search AND m_approved = 0 OR m_description LIKE :search AND m_approved = 0
   ORDER BY m_id DESC
   LIMIT {$start}, {$perPage};
");

// Fetiching article
$articles->execute(array("search" => $searchDB));
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

// Pages
$total = $dbpdo->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$sites = ceil($total / $perPage);

// Get category/tag query
$cat = htmlspecialchars(htmlspecialchars($_GET['query']));

// Get tags content
$tags = $dbpdo->prepare("
   SELECT * 
   FROM tags
   WHERE category = ?
   ORDER BY tag ASC
");

// Fetching tags
$tags->execute(array($cat));
$tags = $tags->fetchAll(PDO::FETCH_ASSOC);

$user = htmlspecialchars(htmlspecialchars($_GET['query']));

$display_user = $dbpdo->prepare("
   SELECT * 
   FROM user
   WHERE name = ? OR uuid = ?
   LIMIT 1
");

// Fetching tags
$display_user->execute(array($user, $user));
$display_user = $display_user->fetchAll(PDO::FETCH_ASSOC);


// Chars for product url
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';

include('./include/header-banner.php');
?>
<style>
.small {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 40%;
}
.card:hover {
   border: 1px solid #e57c0b;
}
</style>
<section class="pt-4">
   <div class="container">
   <form action="/search/" method="GET">
      <div class="input-group input-group-lg mb-4">
         <input name="query" class="form-control" placeholder="<?php echo $lang['searchbar'] ?>" aria-label="<?php echo $lang['searchbar'] ?>" aria-describedby="basic-addon2">
         <div class="input-group-append">
            <button class="btn btn-secondary" type="submit" name="submit-search"><?php echo $lang['search'] ?></button>
         </div>
      </div>
      <?php

      // input misspelled word
      $input = htmlspecialchars(htmlspecialchars($_GET['query']));
      
      // array of words to check against
      include('./helper/search-completer.php');
      
      // no shortest distance found, yet
      $shortest = -1;
      
      // loop through words to find the closest
      foreach ($words as $word) {
      
         // calculate the distance between the input word,
         // and the current word
         $lev = levenshtein($input, $word);
      
         // check for an exact match
         if ($lev == 0) {
      
            // closest word is this one (exact match)
            $closest = $word;
            $shortest = 0;
      
            // break out of the loop; we've found an exact match
            break;
         }
      
         // if this distance is less than the next found shortest
         // distance, OR if a next shortest word has not yet been found
         if ($lev <= $shortest || $shortest < 0) {
            // set the closest match, and shortest distance
            $closest  = $word;
            $shortest = $lev;
         }
      }
      
      // calculate the percentage of the words combined (not sure if it works with an array (F in chat))
      $perc = similar_text($input, $words, $percent);

      // echo "Input word: $input\n";
      if (!$shortest == 0 xor $percent>="35") {
         echo '<p style="margin-top:-20px;"><i>'.$lang['did-you-mean'].' <a href="?query='.$closest.'&submit-search="><u>'.$closest.'</u></a> ?</i></p>';
      }       
      
      ?>
   </form>
      <?php
         if(!empty(htmlspecialchars($_GET["query"]))) {
            if ($total >= 1) {
               echo '<h3><b>'.$total.'</b> '.$lang['search-results'].'"<b><u><i>'.htmlspecialchars($_GET["query"]).'</i></u></b>"</h3><br>';
            } else {
               echo '<h3>'.$lang['no-results'].' "<b><u><i>'.htmlspecialchars($_GET["query"]).'</i></u></b>"</h3><br>';
            }
         }

         if (isset($_GET['cat']) == 1) {
            
            $db = "SELECT * FROM tags WHERE category = '' ORDER BY tag ASC";
            $stmt = $dbpdo->prepare("SELECT * FROM tags WHERE category = :cat ORDER BY tag ASC");
            $stmt->execute(array("cat" => $cat));
            if ($stmt->rowCount() > 0) {
               echo '<h5>';
               while($row = $stmt->fetch()) {
                  $tag = $row["tag"];
                  echo '<a href="/search/?query='.urlencode(htmlspecialchars($tag)).'&cat=1&catset='.urlencode(htmlspecialchars($_GET['query'])).'&submit-search=" class="badge badge-pill badge-primary tag ml-1 mr-1"><i class="fas fa-tag mr-1"></i>'.$tag.'</a>';
               }
               echo '</h5>
                     <hr>';
            } 
         }
      ?>
     <br>
   </div>
</section>
<section id="product">
   <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
         <li class="page-item <?php if($site <= 1) { echo 'disabled'; } elseif ($total == 0) { echo 'disabled'; } ?>">
         <a class="page-link" href="?query=<?php echo htmlspecialchars($_GET['query']); ?>&site=<?php echo $site-1; ?>&max=<?php echo $perPage; ?>&submit-search=#product"><?php echo $lang['previous']; ?></a>
         </li>
         <?php 
         for($x = 1; $x <= $sites; $x++): ?>
            <li class="page-item <?php if($site === $x) { echo 'active'; } elseif ($total == 0) { echo 'disabled'; } ?>"><a class="page-link" href="?query=<?php echo htmlspecialchars($_GET['query']); ?>&site=<?php echo $x; ?>&max=<?php echo $perPage; ?>&submit-search=#product"><?php echo $x; ?></a></li>
         <?php endfor; ?>
         <li class="page-item <?php if($site == $x-1) { echo 'disabled'; } elseif ($total == 0) { echo 'disabled'; } ?>">
            <a class="page-link" href="?query=<?php echo htmlspecialchars($_GET['query']); ?>&site=<?php echo $site+1; ?>&max=<?php echo $perPage; ?>&submit-search=#product"><?php echo $lang['next']; ?></a>
         </li>
      </ul>
   </nav>
</section>
<section class="pt-5 pb-5">
   <div class="container">
      <div class="row">
         <?php foreach($display_user as $display_users): ?>
         <?php if ($display_users['premium'] == 1) {
            $premium = '<a href="/partner-program/" class="fas fa-crown text text-muted" title="Premium content creator"> Premium Content Creator</a>';
         } ?>
            <div class="col-md-4">
               <div class="card mb-4 shadow-sm">
                  <a href="/user/<?php echo $display_users['name']; ?>/">
                  <img class="card-img-top img-fluid small mt-3 border border-success rounded-circle" src="<?php echo $display_users['picture']; ?>" alt="<?php echo $display_users['name']; ?>-IMAGE">
                  </a>
                  <hr>
                  <div class="card-body">
                     <!--<a href="/product/" class="text text-primary d-flex justify-content-between align-items-center">-->
                     <h5 class="card-topic text text-primary"><?php echo $display_users['name']; ?></h5>
                     <small class="text text-light"><?php echo $premium; ?></small>
                     <!--</a>-->
                     <p class="card-text"><?php echo $display_users['description']; ?></p>
                     <div class="d-flex justify-content-between align-items-center">
                        <a href="/user/<?php echo $display_users['name']; ?>/" class="btn btn-block btn-sm btn-outline-success"><?php echo $lang['to-profile']; ?></a>
                     </div>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>

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
                        <img class="card-img-top img-fluid rounded shadow1 cover" async=on src="<?php echo explode(" ", $article['m_picture'])[0]; ?>" alt="<?php echo $article['m_name']; ?>-IMAGE">
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
                        <p class="card-text"><?php echo str_replace("<br />", " ", substr($article['m_description'], 0, 130) . "..."); ?></p>
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
   <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
         <li class="page-item <?php if($site <= 1) { echo 'disabled'; } elseif ($total == 0) { echo 'disabled'; } ?>">
         <a class="page-link" href="?query=<?php echo htmlspecialchars($_GET['query']); ?>&site=<?php echo $site-1; ?>&max=<?php echo $perPage; ?>&submit-search=#product"><?php echo $lang['previous']; ?></a>
         </li>
         <?php for($x = 1; $x <= $sites; $x++): ?>
            <li class="page-item <?php if($site === $x) { echo 'active'; } elseif ($total == 0) { echo 'disabled'; } ?>"><a class="page-link" href="?query=<?php echo htmlspecialchars($_GET['query']); ?>&site=<?php echo $x; ?>&max=<?php echo $perPage; ?>&submit-search=#product"><?php echo $x; ?></a></li>
         <?php endfor; ?>
         <li class="page-item <?php if($site == $x-1) { echo 'disabled'; } elseif ($total == 0) { echo 'disabled'; } ?>">
            <a class="page-link" href="?query=<?php echo htmlspecialchars($_GET['query']); ?>&site=<?php echo $site+1; ?>&max=<?php echo $perPage; ?>&submit-search=#product"><?php echo $lang['next']; ?></a>
         </li>
      </ul>
   </nav>
</section>