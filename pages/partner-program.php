<section class="pt-2 pb-2 mt-0 align-items-center d-flex bg-dark" style="min-height: 100vh; background-size: cover; background-image: url('/static-assets/img/bg-4.png');">
   <div class="container ">
      <div class="row  justify-content-center align-items-center d-flex-row text-center h-100">
         <div class="col-12 col-md-12 h-50 ">
            <h1 class="font-weight-bold   text-white display-2 mb-2 mt-5"> <small>FiveMods</small>
               <br><?php echo $lang['partner-program']; ?>
            </h1>
            <p>
               <a href="#info" class="btn btn-success btn-lg mt-5 mb-5 "><?php echo $lang['see-benefits'];?> &gt;</a>
            </p>
            <div class="btn-container-wrapper p-relative d-block  zindex-1">
               <hr>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="text-primary pt-5 pb-5" id="info">
   <div class="container pt-md-5 pb-md-5">
      <div class="row text-center pb-md-4 justify-content-sm-center ">
         <div class="col-12  col-md-4 m-auto">
            <i class="fas fa-dollar-sign fa-3x mb-3 mt-3 text-primary" aria-hidden="true"></i>
            <h3 class="h4 mt-2 mb-3"></h3>
         </div>
         <div class="col-12  col-md-4 m-auto">
            <i class="fas fa-percentage fa-3x mb-3 mt-3 text-primary" aria-hidden="true"></i>
            <h3 class="h4 mt-2 mb-3"><?php echo $lang['benefit2'];?></h3>
         </div>
         <div class="col-12  col-md-4 m-auto">
            <i class="fas fa-crown fa-3x mb-3 mt-3 text-primary" aria-hidden="true"></i>
            <h3 class="h4 mt-2 mb-3"><?php echo $lang['benefit3'];?></h3>
         </div>
      </div>
      <div class="row text-center justify-content-sm-center ">
         <div class="col-12  col-md-4 m-auto">
            <i class="fas fa-check-double fa-3x mb-3 mt-3 text-primary" aria-hidden="true"></i>
            <h3 class="h4 mt-2 mb-3"><?php echo $lang['benefit4'];?></h3>
         </div>
         <div class="col-12  col-md-4 m-auto">
            <i class="fas fa-cogs fa-3x mb-3 mt-3 text-primary" aria-hidden="true"></i>
            <h3 class="h4 mt-2 mb-3"><?php echo $lang['benefit5'];?></h3>
         </div>
         <div class="col-12  col-md-4 m-auto">
            <i class="fas fa-tachometer-alt fa-3x mb-3 mt-3 text-primary" aria-hidden="true"></i>
            <h3 class="h4 mt-2 mb-3"><?php echo $lang['benefit6'];?></h3>
         </div>
      </div>
   </div>
</section>
<section class="pt-5 pb-5 bg-dark">
   <div class="container">
      <div class="row justify-content-around align-items-center">
         <div class="col-md-6 col-lg-5 col-xl-4">
            <span class="h1 d-block mb-lg-0 text-white"><?php echo $lang['partner-text1'];?></span>
         </div>
         <div class="col-md-6">
            <p class="lead mb-3 text-white"><?php echo $lang['partner-text2'];?></p>
            <div class="d-flex align-items-center">
            <?php
            
            if (($_SESSION['user_id'])) {
               if ($_SESSION['user_2fa'] == "1") {
                  if ($_SESSION['user_premium'] == "0") {
                     echo '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#joinModal">'.$lang['partner-button'].'</button>
                     <span class="d-block mx-1 mx-sm-2 text-small text-white">-</span>
                     <button class="btn btn-light btn-lg" data-toggle="modal" data-target="#conModal">'.$lang['partner-conditions'].'</button>';
                  } elseif (empty($_SESSION['user_id'])) {
                     echo '';
                  } else {
                     echo '<button class="btn btn-light btn-lg">'.$lang['already-in'].'</button>';
                  }
               } else {
                  echo '<a href="/account/" class="btn btn-light btn-lg">Please activate Two-Factor Authentication</a>';
               }              
            } else {
               echo '<a class="btn btn-light btn-lg" href="/account/sign-in/">'.$lang['login-to-part'].'</a>';
            } 
            ?>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="bg-white text-dark pt-5 pb-5">
   <div class="container">
      <div class="row text-center">
         <div class="col">
            <h3 class="  mb-4"><?php echo $lang['partner-text3'];?></h3>
         </div>
      </div>
      <div class="row text-center mt-md-5">
      <?php
         $sql = "SELECT name, picture FROM user WHERE premium = 1 ORDER BY totaldownloads DESC";
         $result = $conn->query($sql);
         if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
               echo '<div class="col-md-3 mb-5 col-12">
                        <a class="profile" href="/user/'.$row["name"].'" title="Go to the profile">
                        <img alt="image" style="width: 150px; height: 150px;" class="img-fluid mb-4 mt-3 rounded-circle img-rised" src="'.$row['picture'].'">
                        <h3><strong>'.$row['name'].'</strong></h3></a>
                        <p>Premium Content Creator</p>
                     </div>';
            }
         }
      ?>
      </div>
   </div>
</section>
<section>
<!-- Modal -->
<div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-labelledby="joinModal"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="joinModal">Partner Application</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="/helper/manage.php" method="post" autocomplete="off">
            <input name="partner" value="1" hidden>
            <div class="form-group">
            <label for="username"><?php echo $lang['partner-question1'];?><span class="text text-danger">*</span></label>
               <input type="text" name="q1" tabindex="1" class="form-control" placeholder="<?php echo $_SESSION['user_username']; ?>" required>
            </div>
            <div class="form-group">
            <label for="username"><?php echo $lang['partner-question2'];?><span class="text text-danger">*</span></label>
               <input type="number" name="q2" tabindex="1"  class="form-control" required>
            </div>
            <div class="form-group">
            <label for="username"><?php echo $lang['partner-question3'];?><span class="text text-danger">*</span></label>
               <textarea type="textarea" name="q3" tabindex="2" class="form-control" placeholder="Lua, C#, Modelling, etc" required></textarea>
            </div>
            <div class="form-group">
            <label for="username"><?php echo $lang['partner-question4'];?><span class="text text-danger">*</span></label>
               <textarea name="q4" tabindex="2" class="form-control" min-length="150" required></textarea>
            </div>
            <div class="form-group">
               <div class="row justify-content-center text-center">
                  <div class="col-xs-6 col-xs-offset-3">
                     <button type="submit" class="form-control btn btn-primary"><?php echo $lang['submit'];?></button>
                  </div>
               </div>
            </div>
         </form>
      </div>
    </div>
  </div>
</div>
</section>
<section>
<!-- Modal -->
<div class="modal fade" id="conModal" tabindex="-1" role="dialog" aria-labelledby="conModal"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="conModal">Partner Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p><?php echo $lang['partner-text4'];?></p>
         <ul>
            <li><?php echo $lang['partner-condition1'];?></li>
            <li><b>5+</b> <?php echo $lang['partner-condition2'];?></li>
            <li><b>100+</b> <?php echo $lang['partner-condition3'];?></li>
         </ul>
      </div>
    </div>
  </div>
</div>
</section>