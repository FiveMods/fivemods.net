<?php include('./include/header-banner.php'); ?>
<section class="pb-5">
   <div class="bg-gray">
      <div class="container">
         <div class="row-100"></div>
         <div class="row text-left">
            <div class="col-8 pt-4">
               <h1><?php echo $lang['contact'];?></h1>
               <p class="text-h3 pt-3"><?php echo $lang['contact-text1'];?></p>
            </div>
         </div>
         <div class="row-100"></div>
      </div>
   </div>
   <div class="container">
      <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
      <div class="row-100"></div>
      <div class="row">
         <div class="col-12 col-md-6 col-lg-5">
            <h2><?php echo $lang['email-support'];?></h2>
            <p class="text-large"><?php echo $lang['contact-text2'];?></p>
            <p class="text-h3 mt-4 mt-lg-5">
               <strong><?php echo $lang['contact-us-at'];?>:</strong>
            </p>
            <p>
               <a href="mailto://fivemods.management@gmail.com">fivemods.management@gmail.com</a>
            </p>
            <p><strong><?php echo $lang['complaint'];?>?</strong></p>
            <p>
               <a href="mailto://fivemods.management@gmail.com?subject=General%20or%20legal%20complaint%20%7C%20SID%3A%20<?php echo session_id();?>">fivemods.management@gmail.com</a>
            </p>
            <p><strong><?php echo $lang['privacy-manager'];?>:</strong></p>
            <p>
               <a href="mailto:fivemods.management@gmail.com?subject=General%20privacy%20issue%20%7C%20SID%3A<?php echo session_id();?>">fivemods.management@gmail.com</a>
            </p>
         </div>
         <?php
         
         if (empty($_SESSION['user_id'])) {
            echo '<div class="col-12 col-md-6 ml-auto"><div class="row mt-4"><a href="/account/login/" class="btn btn-block btn-primary">'.$lang['log-in'].' to fill out the form.</a></div></div>';
         } else {
            echo '<div class="col-12 col-md-6 ml-auto">
            <h2>'.$lang['contact-form'].'</h2>
            <form method="post" action="/helper/manage.php">
               <div class="row mt-4">
                  <div class="col">
                     <select name="category" class="form-control" required>
                        <option disabled>'.$lang['select-category'].'</option>
                        <option value="General Support">'.$lang['general-support'].'</option>
                        <option value="Bugreport">'.$lang['bugreport'].'</option>
                        <option value="Suggestion">'.$lang['suggestion'].'</option>
                        <option value="Stolen Mod Report">'.$lang['stolen-mod-report'].'</option>
                     </select>
                  </div>
               </div>
               <div class="row mt-4">
                  <div class="col">
                     <input type="text" name="header" class="form-control" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" minlength="10" maxlength="75" placeholder="'.$lang['heading'].'" required>
                     <span style="font-size: 10px;">Please enter min. 10 and max. 75 characters.</span>
                  </div>
               </div>
               <div class="row mt-4">
                  <div class="col">
                     <textarea class="form-control" name="message" rows="10" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" minlength="50" maxlength="1500" placeholder="'.$lang['how-can-we-help'].'" style="margin-top: 0px; margin-bottom: 0px; height: 162px;" required></textarea>
                     <span style="font-size: 10px;">Please enter min. 50 and max. 1500 characters.</span>
                  </div>
               </div>
               <div class="row mt-4">
                  <div class="col">
                     <input type="text" name="contact" value="1" hidden>
                     <input type="text" name="userid" value="1" hidden>
                     <button type="submit" class="btn btn-primary">'.$lang['submit'].'</button> <br>
                     <span style="font-size: 10px;">With pressing the button "'.$lang['submit'].'" you confirm our <a href="/ban-policy/">'.$lang['ban-policy'].'</a> as well as our <a href="/terms-of-service/">'.$lang['terms-of-service'].'</a>.</span>
                  </div>
               </div>
            </form>
         </div>';
         }

         

         ?>
      </div>
   </div>
</section>