<div class="leftBasedAds" style="left: 0px; position: fixed; text-align: center; top: 20%;margin-left:3%;">


  <!-- Vertical Test -->
  <ins class="adsbygoogle leftBasedAds" style="display:inline-block;width:160px;height:600px"
       data-ad-client="ca-pub-9727102575141971"
       data-ad-slot="2716933531"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>
<div class="rightBasedAds" style="right: 0px; position: fixed; text-align: center; top: 20%;margin-right:3%;">

  <!-- Vertical Test -->
  <ins class="adsbygoogle rightBasedAds" style="display:inline-block;width:160px;height:600px"
       data-ad-client="ca-pub-9727102575141971"
       data-ad-slot="2716933531"></ins>
  <script>
       (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>
<?php

require_once('./config.php');

$pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');


include('./include/header-banner.php');

echo '<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">';


$result = $pdo->prepare("SELECT * FROM user ORDER BY name ASC");
$result->execute();
   if($result->rowCount() > 0) {
      while($row = $result->fetch()) {
         $username = $row['name'];
         $userimg = $row['picture'];
         $uid = $row['uuid'];
         $premium = $row['premium'];
         $blocked = $row['blocked'];

         if (!empty($username)) {
            if ($blocked != 1) {
                if ($premium == 1) {
                    $insert = '<div class="card-header"><a href="/partner-program/" class="fas fa-crown text text-muted" title="Premium content creator"></a> '.$username.'</div>';
                } else {
                    $insert = '<div class="card-header">'.$username.'</div>';
                }

                if (empty($userimg)) {
                    $userimg = "./static-assets/img/";
                } else {
                    $userimg = $row['picture'];
                }

               echo '<div class="col-md-3 text-center">
                   <div class="card text-dark bg-light mb-3 rounded shadow1" style="max-width: 18rem;">
                       '.$insert.'
                       <a href="/user/'.$username.'/">
                       <div class="card-body">
                           <p class="card-text"><img src="https://img-cdn.fivemods.net/unsafe/75x75/filters:format(webp):quality(95):sharpen(0.2,0.5,true)/'.$userimg.'" class="img-fluid rounded" alt="'.$username.'-Profile Picture"></img></p>
                       </div>
                       <a href="/user/'.$username.'/" class="btn btn-primary btn-block btn-sm">'.$lang['visit']. ' '.$username.'</a>
                   </div>
               </a>
           </div>';
             }
         } else {
             echo '';
         }
      }
   }
   $pdo = null;

   echo '</div>
   </div>
</section>';
?>
