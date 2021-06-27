<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if (substr($page, -1) == '/') {
        $page = substr($page, 0, -1);
    }
    $site_parameters = json_decode(file_get_contents('lib/spec_meta.json'), true)[$page];
} else {
    $site_parameters = json_decode(file_get_contents('lib/spec_meta.json'), true)['index'];
}
echo '<!-- Detailed Meta Tags -->'
    .'<meta name="description" content="'.$site_parameters['description'].'" />'
    .'<meta name="keywords" content="'.$site_parameters['keywords'].'" />'
    .'<meta name="page-topic" content="'.$site_parameters['page-topic'].'" />'
    .'<meta name="page-type" content="'.$site_parameters['page-type'].'" />'
    .'<!-- DC Meta Tags -->'
    .'<meta name="DC.Description" content="'.$site_parameters['description'].'" />'
?>
