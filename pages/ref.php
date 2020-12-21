<?php 

   $ref = urldecode($_GET['rdc']);

   $marks = array(
"grabify.link",
"bmwforum.co",
"leancoding.co",
"spottyfly.com",
"stopify.co",
"yoütu.be",
"discörd.com",
"minecräft.com",
"freegiftcards.co",
"disçordapp.com",
"särahah.eu",
"särahah.pl",
"xda-developers.us",
"quickmessage.us",
"fortnight.space",
"fortnitechat.site",
"youshouldclick.us",
"joinmy.site",
"crabrave.pw"
   ); 
   
   if (in_array($ref, $marks)) { 

      $check = 1;

      $output1 = '<section class="pt-5 pb-5">
   <div class="container">
      <div class="row d-flex justify-content-center">
      <div class="col-md-7">
         <div class="card border border-danger">
            <div class="card-body text-center p-5">
            <h2 class="fas fa-exclamation-triangle text-danger"></h2>
            <h3 class="pb-2 h3 mt-1 text-danger">'.$ref.'</h3>
            <p class="lead">This site is external and we <b>can\'t guarantee the safety</b>, always make sure to be on a website <b>using a SSL certificate</b>.</p>
            <h5>This link grabs personal information, <b>we won\'t redirect you</b>.</h5> 
            </div>
         </div>
      </div>
      </div>
   </div>
</section>';

   } else { 

      $check = 0;

      $output1 = '<section class="pt-5 pb-5">
   <div class="container">
      <div class="row d-flex justify-content-center">
      <div class="col-md-7">
         <div class="card border border-success">
            <div class="card-body text-center p-5">
            <h3 class="pb-2 h3 mt-1 '.$css_text.'">'.$ref.'</h3>
            <p class="lead">This site is external and we <b>can\'t guarantee the safety</b>, always make sure to be on a website <b>using a SSL certificate</b>.</p>
            <a href="'.$ref.'" class="btn btn-xs btn-round btn-lg btn-success btn-rised mt-md-3">Continue and leave page</a> <br>
            <a href="'.$ref.'" class="btn btn-xs btn-round btn-sm btn-light btn-rised mt-md-3" target="_blank">Open link in new tab</a>
            </div>
         </div>
      </div>
      </div>
   </div>
</section>';

   }

?>
<?php include('./include/header-banner.php'); ?>
<?php echo $output1; ?>