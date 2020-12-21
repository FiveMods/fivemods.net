<?php 

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

include('./include/header-banner.php'); 

echo '<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">';


$sql = "SELECT * FROM user";
   $result = $conn->query($sql);
   if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
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
                   <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                       '.$insert.'
                       <a href="/user/'.$username.'/">
                       <div class="card-body">
                           <p class="card-text"><img src="'.$userimg.'" width="75px" class="img-fluid rounded" alt="'.$username.'-Profile Picture"></img></p>
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

   echo '</div>
   </div>
</section>';
?>          