<?php

require_once('./config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

// User input
$site = (int)isset($_GET['site']) ? (int)$_GET['site'] : 1;
$perPage = (int)isset($_GET['max']) && $_GET['max'] <= 100 ? (int)$_GET['max'] : 12;

// Positioning
$start = ($site > 1) ? ($site * $perPage) - $perPage : 0;

// Query
$articles = $pdo->prepare("
   SELECT SQL_CALC_FOUND_ROWS *
   FROM mods
   LEFT JOIN user ON mods.m_authorid = user.id
   ORDER BY m_id DESC
   LIMIT {$start}, {$perPage};
");

$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

// Query 2
$most = $pdo->prepare("
   SELECT SQL_CALC_FOUND_ROWS *
   FROM mods
   LEFT JOIN user ON mods.m_authorid = user.id
   WHERE m_approved = 0 AND m_blocked = 0
   ORDER BY m_downloads DESC
   LIMIT 0, 4;
");

$most->execute();
$most = $most->fetchAll(PDO::FETCH_ASSOC);

// Pages
$total = $pdo->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$sites = ceil($total / $perPage);


if (isset($_SESSION['downloadMod'])) {
   $downloadMod = $pdo->prepare("SELECT m_downloadlink FROM mods WHERE m_id = :id");
   $downloadMod->execute(array("id" => $_SESSION['lastDownload']));
   while ($row = $downloadMod->fetch()) {
      $downloadLink = $row['m_downloadlink'];
   }
   header("Location: $downloadLink");
   unset($_SESSION['downloadMod']);
}


?>
<div>
   <?php include('./include/header-banner.php'); ?>
   <section class="pt-5 pb-5">
      <div class="container">
         <div class="row d-flex ">
            <div class="col-lg-6 d-flex">
               <div class="card justify-content-center p-lg-4 p-3 mb-1">
                  <div class="card-body py-3 flex-grow-0">
                     <span class="d-block h2">“Inspire and Motivate new Creator”</span>
                     <p class="lead">Your products are booming? Here is the place to show everyone.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="row">

                  <?php foreach ($most as $mosts) : ?>
                     <div class="col-6">
                        <a href="/product/<?php echo $mosts['m_id']; ?>/" class="card mb-3">
                           <img class="card-img-top img-fluid img-thumbnail cover-sm" async=on src="<?php echo explode(" ", $mosts['m_picture'])[0]; ?>" alt="<?php echo $mosts['m_name'] ?>-PICTURE">
                           <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                 <h6 class="mb-0"><?php echo $mosts['m_name'] ?></h6>
                                 <i class="fas fa-chevron-right"> </i>
                              </div>
                           </div>
                        </a>
                     </div>

                  <?php endforeach; ?>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section id="product">
      <nav aria-label="Page navigation example">
         <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($site <= 1) {
                                    echo 'disabled';
                                 } ?>">
               <a class="page-link" href="?site=<?php echo $site - 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['previous']; ?></a>
            </li>
            <?php for ($x = 1; $x <= $sites; $x++) : ?>
               <li class="page-item <?php if ($site === $x) {
                                       echo 'active';
                                    } ?>"><a class="page-link" href="?site=<?php echo $x; ?>&max=<?php echo $perPage; ?>#product"><?php echo $x; ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?php if ($site == $x - 1) {
                                    echo 'disabled';
                                 } ?>">
               <a class="page-link" href="?site=<?php echo $site + 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['next']; ?></a>
            </li>
         </ul>
      </nav>
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
                        <img class="card-img-top img-fluid img-thumbnail cover" async=on src="<?php echo explode(" ", $article['m_picture'])[0]; ?>" alt="<?php echo $article['m_name']; ?>-IMAGE">
                        
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
            <li class="page-item <?php if ($site <= 1) {
                                    echo 'disabled';
                                 } ?>">
               <a class="page-link" href="?site=<?php echo $site - 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['previous']; ?></a>
            </li>
            <?php for ($x = 1; $x <= $sites; $x++) : ?>
               <li class="page-item <?php if ($site === $x) {
                                       echo 'active';
                                    } ?>"><a class="page-link" href="?site=<?php echo $x; ?>&max=<?php echo $perPage; ?>#product"><?php echo $x; ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?php if ($site == $x - 1) {
                                    echo 'disabled';
                                 } ?>">
               <a class="page-link" href="?site=<?php echo $site + 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['next']; ?></a>
            </li>
         </ul>
      </nav>
   </section>
</div>
<?php
   $pdo = null;
?>