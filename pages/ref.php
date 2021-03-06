<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('max_execution_time', 300);

require_once('./config.php');

if (isset($_GET['rdc'])) {

    $ref = urldecode($_GET['rdc']);

    $suburl = getHost($ref);
    $url = giveHost($suburl);

    $stmt = $conn->prepare("SELECT marked_links FROM links WHERE marked_links LIKE ?");
    $stmt->bind_param("s", $url);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $link = $row['marked_links'];
        }

        $check = 1;

        $output1 = '<section class="pt-5 pb-5">
    <div class="container">
        <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card border border-danger">
                <div class="card-body text-center p-5">
                <h2 class="fas fa-exclamation-triangle text-danger"></h2>
                <h3 class="pb-2 h3 mt-1 text-danger">'.$link.'</h3>
                <p class="lead">This site is external and we <b>can\'t guarantee the safety</b>, always make sure to be on a website <b>using a SSL certificate</b>.</p>
                <h5>This link grabs personal information, <b>we won\'t redirect you</b>.</h5>
                </div>
            </div>
        </div>
        </div>
    </div>
    </section>';

    include('./include/header-banner.php');
    echo $output1;


    } else {

        if (strpos($ref, 'https://') !==false) {
            $link = $ref;
        } else {
            if (strpos($ref, 'http://') !==false) {
                $strip = str_replace('http://', '', $ref);
                $link = 'https://'.$strip;
            } else {
                $link = 'https://'.$ref;
            }
        }


        $check = 0;

        $output1 = '<section class="pt-5 pb-5">
    <div class="container">
        <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card border border-success">
                <div class="card-body text-center p-5">
                <h3 class="pb-2 h3 mt-1 '.$css_text.'">'.$link.'</h3>
                <p class="lead">This site is external and we <b>can\'t guarantee the safety</b>, always make sure to be on a website <b>using a SSL certificate</b>.</p>
                <a href="'.$link.'" rel="nofollow noopener noreferrer" class="btn btn-xs btn-round btn-lg btn-success btn-rised mt-md-3">Continue and leave page</a> <br>
                <a href="'.$link.'" class="btn btn-xs btn-round btn-sm btn-light btn-rised mt-md-3" rel="nofollow noopener noreferrer" target="_blank">Open link in new tab</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    </section>';

    include('./include/header-banner.php');
    echo $output1;

    }

} else {

    $output1 = '<section class="pt-5 pb-5">
    <div class="container">
        <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card border border-danger">
                <div class="card-body text-center p-5">
                <h2 class="fas fa-exclamation-triangle text-danger"></h2>
                <h3 class="pb-2 h3 mt-1 text-danger">Error</h3>
                <p class="lead">There was no link provided, to go back click the button.</p>
                <a href="/" class="btn btn-xs btn-round btn-sm btn-light btn-rised mt-md-3">Go Back</a>
                </div>
            </div>
        </div>
        </div>
    </div>
    </section>';

    include('./include/header-banner.php');
    echo $output1;


}

function getHost($Address) {
    $parseUrl = parse_url(trim($Address));
    return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2)));
}

function giveHost($host_with_subdomain) {
    $array = explode(".", $host_with_subdomain);
    return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
}


?>

<div class="centerBasedFooterAd" style="text-align: center; bottom: 35%;">
    <!-- Footer-Block-Ads -->
    <ins class="adsbygoogle" style="display:inline-block;width:820px;height:207px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="1867802594"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
