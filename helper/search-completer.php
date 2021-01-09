<?php 

$words = array(
    "Scripts",
    "Vehicles",
    "Weapons",
    "Peds",
    "Maps",
    "Liveries",
    "Misc",
    "vMenu",
    "Los Santos",
    "Sandy Shores",
    "Blaine County",
    "Police",
    "Firefighter",
);

require_once('config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

$usernameDB = $pdo->prepare("SELECT name FROM user");
$usernameDB->execute();

$usernames = $usernameDB->fetchAll(PDO::FETCH_ASSOC);

foreach($usernames as $username) {
    array_push($words, $username['name']);
}


$tagDB = $pdo->prepare("SELECT tag FROM tags");
$tagDB->execute();

$tags = $tagDB->fetchAll(PDO::FETCH_ASSOC);

foreach($tags as $tag) {
    array_push($words, $tag['tag']);
}

$modDB = $pdo->prepare("SELECT m_name, m_tags FROM mods WHERE m_approved = 0 AND m_blocked = 0");
$modDB->execute();

$mods = $modDB->fetchAll(PDO::FETCH_ASSOC);

foreach($mods as $mod) {
    array_push($words, $mod['m_name']);
    $tags = explode(",",$mod['m_tags']);
    
    foreach($tags as $tag) {
        array_push($words, str_replace(" ","", $tag));
    }
}
echo '<pre>';
print_r($words);
echo '</pre>';

?>