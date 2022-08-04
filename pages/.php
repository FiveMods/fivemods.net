<div class="leftBasedAds" style="left: 0px; position: fixed; text-align: center; top: 20%;margin-left:3%;">


    <!-- Vertical Test -->
    <ins class="adsbygoogle leftBasedAds" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="2716933531" data-ad-format="auto" data-full-width-responsive="true"></ins> <!-- data-ad-format="auto" data-full-width-responsive="true" -->
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

</div>
<div class="rightBasedAds" style="right: 0px; position: fixed; text-align: center; top: 20%;margin-right:3%;">

    <!-- Vertical Test -->
    <ins class="adsbygoogle rightBasedAds" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="2716933531" data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<?php
include('./vertical-ads.html');
require_once('./config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

// User input
$site = (int)isset($_GET['site']) ? (int)$_GET['site'] : 1;
$perPage = (int)isset($_GET['max']) && $_GET['max'] <= 100 ? (int)$_GET['max'] : 24;

// Positioning
$start = ($site > 1) ? ($site * $perPage) - $perPage : 0;

// Query
$articles = $pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM mods LEFT JOIN user ON mods.m_authorid = user.id WHERE m_approved = 0 AND m_blocked = 0 ORDER BY m_id DESC LIMIT {$start}, {$perPage};");

$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

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

// Generate csrf token validation
$csrfValidate = openssl_random_pseudo_bytes(24);
$csrfValidate = bin2hex($csrfValidate);

$_SESSION['csrfValidate'] = $csrfValidate;
echo '<script>console.log("CSRF validate: ' . $_SESSION['csrfValidate'] . '");</script>';

?>
<style>
    .container-img {
        position: relative;
    }

    .text-block {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: black;
        color: white;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>
<div>
    <?php include('./include/header-banner.php'); ?>
    <section class="pt-5 pb-5 blinker">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3 class="mb-3"><?php echo $lang['categories']; ?></h3>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary mb-3 mr-1 rounded" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a class="btn btn-primary mb-3 rounded" href="#carouselExampleIndicators2" role="button" data-slide="next">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <a href="/search/?query=Vehicles&cat=1&submit-search=">
                                            <div class="card container-img rounded shadow1">
                                                <img class="img-fluid cover-cat rounded" alt="img_<?php echo $lang['vehicles']; ?>-348px-217px-cover" title="<?php echo $lang['vehicles']; ?>" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(90):sharpen(1,0.3,true)/https://wallpaperaccess.com/full/2192755.jpg">
                                                <div class="text-block">
                                                    <h4><?php echo $lang['vehicles']; ?></h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="/search/?query=Maps&cat=1&submit-search=">
                                            <div class="card container-img rounded shadow1">
                                                <img class="img-fluid cover-cat rounded" alt="img_<?php echo $lang['maps']; ?>-348px-217px-cover" title="<?php echo $lang['maps']; ?>" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(90):sharpen(1,0.3,true)/https://media.sketchfab.com/models/fe9ddaaea413487395b9f0656fd0afd7/thumbnails/36fefca8f37d405689ed7f618dc39857/62c7f8001ffc4936ab905945ad9264dd.jpeg">
                                                <div class="text-block">
                                                    <h4><?php echo $lang['maps']; ?></h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="/search/?query=Weapons&cat=1&submit-search=">
                                            <div class="card container-img rounded shadow1">
                                                <img class="img-fluid cover-cat rounded" alt="img_<?php echo $lang['weapons']; ?>-348px-217px-cover" title="<?php echo $lang['weapons']; ?>" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(90):sharpen(1,0.3,true)/https://img.gta5-mods.com/q95/images/real-weapons-v-animated/46f77a-20161130020713_1.jpg">
                                                <div class="text-block">
                                                    <h4><?php echo $lang['weapons']; ?></h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card container-img rounded shadow1">
                                            <a href="/search/?query=Peds&cat=1&submit-search=">
                                                <img class="img-fluid cover-cat rounded" alt="img_<?php echo $lang['peds']; ?>-348px-217px-cover" title="<?php echo $lang['peds']; ?>" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(90):sharpen(1,0.3,true)/https://libertycity.net/uploads/download/gta5_newskins/fulls/an4ttg7sk621gulo1957qdc9u0/15388334076961_32d199-grand-theft-auto-v-screenshot.jpg">
                                                <div class="text-block">
                                                    <h4><?php echo $lang['peds']; ?></h4>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card container-img rounded shadow1">
                                            <a href="/search/?query=Liveries&cat=1&submit-search=">
                                                <img class="img-fluid cover-cat rounded" alt="img_<?php echo $lang['liveries']; ?>-348px-217px-cover" title="<?php echo $lang['liveries']; ?>" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(90):sharpen(1,0.3,true)/https://wallpapercave.com/wp/wp3949177.png">
                                                <div class="text-block">
                                                    <h4><?php echo $lang['liveries']; ?></h4>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card container-img rounded shadow1">
                                            <a href="/search/?query=Scripts&cat=1&submit-search=">
                                                <img class="img-fluid cover-cat rounded" alt="img_<?php echo $lang['scripts']; ?>-348px-217px-cover" title="<?php echo $lang['scripts']; ?>" src="https://c4.wallpaperflare.com/wallpaper/579/458/496/computer-unixporn-unix-command-lines-wallpaper-preview.jpg">
                                                <div class="text-block">
                                                    <h4><?php echo $lang['scripts']; ?></h4>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card container-img rounded shadow1">
                                            <a href="https://store.londonstudios.net/fivemods">
                                                <img class="img-fluid cover-cat rounded" alt="img_London Studios-348px-217px-cover" title="London Studios" src="https://img-cdn.fivemods.net/unsafe/filters:watermark(https://v2-assets.fivemods.net/xFRHEkdM2bvmSUVq.png,-140,40,0,14,50):format(webp):quality(95):sharpen(0.2,0.5,true)/https://i.ibb.co/4JRSY52/Copy-of-Base-Design.png">
                                                <div class="text-block">
                                                    <h4>London Studios</h4>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card container-img rounded shadow1">
                                            <a href="/discord/">
                                                <img class="img-fluid cover-cat rounded" alt="img_London Studios-348px-217px-cover" title="London Studios" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/https://www.techniknews.net/wp-content/uploads/2021/07/discord-logo-header.jpg">
                                                <div class="text-block">
                                                    <h4>Our Discord</h4>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card container-img rounded shadow1">
                                            <a href="/upload/">
                                                <img class="img-fluid cover-cat rounded" alt="img_London Studios-348px-217px-cover" title="London Studios" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/https://s3.fivemods.net/assets/upload_logo_primary.png">
                                                <div class="text-block">
                                                    <h4>Upload Mod</h4>
                                                </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
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
                    <a class="page-link rounded" href="?site=<?php echo $site - 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['previous']; ?></a>
                </li>
                <?php for ($x = 1; $x <= $sites; $x++) : ?>
                    <li class="page-item <?php if ($site === $x) {
                                                echo 'active';
                                            } ?>"><a class="page-link" href="?site=<?php echo $x; ?>&max=<?php echo $perPage; ?>#product"><?php echo $x; ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?php if ($site == $x - 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link rounded" href="?site=<?php echo $site + 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['next']; ?></a>
                </li>
            </ul>
        </nav>
    </section>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="d-flex justify-content-end">
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm mb-3 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="?max=12">Show <b>12</b> entries</a>
                        <a class="dropdown-item" href="?max=24">Show <b>24</b> entries</a>
                        <a class="dropdown-item" href="?max=48">Show <b>48</b> entries</a>
                        <a class="dropdown-item" href="?max=96">Show <b>96</b> entries</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $i = 0;
                foreach ($articles as $article) :
                    $i++;

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
                    if (($i % 12) == 0) : ?>

                        <div class="col-md-4 d-flex align-items-stretch">
                            <div class="card mb-4 shadow-sm rounded shadow1 <?php echo $do; ?>">
                                <a href="/ref/?csrf=<?php echo $_SESSION['csrfValidate']; ?>&add=track&rel=https://store.londonstudios.net/fivemods" target="_blank" rel="noreferrer noopener">
                                    <img class="card-img-top img-fluid cover rounded" loading="lazy" src="https://img-cdn.fivemods.net/unsafe/filters:watermark(https://v2-assets.fivemods.net/xFRHEkdM2bvmSUVq.png,-30,40,0,14,50):format(webp):quality(95):sharpen(0.2,0.5,true)/https://media.discordapp.net/attachments/826871170628452372/1001881485525135390/Star-Chase.png?width=1202&height=676" alt="Advert-Image">

                                </a>
                                <div class="card-body">
                                    <a href="/ref/?csrf=<?php echo $_SESSION['csrfValidate']; ?>&add=track&rel=https://store.londonstudios.net/fivemods" target="_blank" rel="noreferrer noopener" class="<?php echo $css_text ?>">
                                        <h5 class="card-topic">Star Chase - London Studios</h5>
                                    </a>
                                    <p class="card-text">Deploy GPS trackers onto target vehicles during high-speed pursuits. Bring your police department to the next level with Star Chase.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="/ref/?csrf=<?php echo $_SESSION['csrfValidate']; ?>&add=track&rel=https://store.londonstudios.net/fivemods" rel="noreferrer noopener" target="_blank" class="btn btn-sm btn-outline-success matomo_download"><?php echo $lang['purchase']; ?></a>
                                            <!-- <button type="button" class="btn btn-sm btn-success" title="<?php echo number_format($article['m_downloads']); ?> downloads"><?php echo  $donwloads . $suffix; ?> <i class="fas fa-download"></i></button> -->
                                        </div>
                                        <small class="text-muted">sponsored by <a href="/ref/?csrf=<?php echo $_SESSION['csrfValidate']; ?>&add=track&rel=https://store.londonstudios.net/fivemods" target="_blank" rel="noreferrer noopener"><b>London Studios</b></a></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card mb-4 shadow-sm rounded shadow1 <?php echo $do; ?>">
                            <a href="/product/<?php echo $article['m_id']; ?>/">
                                <img class="card-img-top img-fluid cover rounded" loading="lazy" src="https://img-cdn.fivemods.net/unsafe/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/<?php echo explode(" ", $article['m_picture'])[0]; ?>" alt="<?php echo $article['m_name']; ?>-IMAGE">

                            </a>
                            <div class="card-body">
                                <a href="/product/<?php echo $article['m_id']; ?>/" class="<?php echo $css_text ?>">
                                    <h5 class="card-topic"><?php echo $article['m_name']; ?></h5>
                                </a>
                                <p class="card-text"><?php echo htmlspecialchars(str_replace("<br />", " ", substr($article['m_description'], 0, 130) . "...")); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <form action="/helper/manage.php?o=index&download=<?php echo $article['m_id']; ?>" method="post">
                                            <button type="submit" class="btn btn-sm btn-outline-success matomo_download"><?php echo $lang['download']; ?></button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-success" title="<?php echo number_format($article['m_downloads']); ?> downloads"><?php echo  $donwloads . $suffix; ?> <i class="fas fa-download"></i></button>
                                    </div>
                                    <small class="text-muted"><?php echo $lang['by']; ?> <a href="/user/<?php echo $article['name']; ?>"><b><?php echo $article['name']; ?></b></a> <?php if ($article['premium'] == 1) echo '<a href="/partner-program/" class="fas fa-crown text text-muted" title="Premium content creator"></a>'; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <div class="centerBasedFooterAd" style="text-align: center; bottom: 35%;">
        <!-- Footer-Block-Ads -->
        <ins class="adsbygoogle" style="display:inline-block;width:820px;height:200px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="1867802594" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <section>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($site <= 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link rounded" href="?site=<?php echo $site - 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['previous']; ?></a>
                </li>
                <?php for ($x = 1; $x <= $sites; $x++) : ?>
                    <li class="page-item <?php if ($site === $x) {
                                                echo 'active';
                                            } ?>"><a class="page-link" href="?site=<?php echo $x; ?>&max=<?php echo $perPage; ?>#product"><?php echo $x; ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?php if ($site == $x - 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link rounded" href="?site=<?php echo $site + 1; ?>&max=<?php echo $perPage; ?>#product"><?php echo $lang['next']; ?></a>
                </li>
            </ul>
        </nav>
    </section>
</div>
<?php
$pdo = null;
?>