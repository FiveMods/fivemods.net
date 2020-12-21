<?php
include('./include/header-banner.php');

session_start();

if (!isset($_SESSION['user_id'])) {
	header('location: /account/logout/');
	exit();
}

if($_GET['rq'] == 1) {

   if ($_SESSION['user_oauth_provider'] == "Google LLC." && empty($_COOKIE[$cookie_name]) || $_SESSION['user_oauth_provider'] == "Google LLC" && empty($_COOKIE[$cookie_name])) {

      
     function generateRandomString($length = 24) {
      return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
   }

   $token = generateRandomString();


      $userid = $_POST['value'];
      $code = $token;
      
      if(!isset($_SESSION['2facode'])) {
         $_SESSION['2facode'] = $code;
      }
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"http://85.214.166.192:8081");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "action=enable2FA&userid=$userid&token=$code");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);

      if(startsWith($response, "Success")) {
         $typeAlert = "success";
      } else if(startsWith($response, "Error")) {
         $typeAlert = "danger";
      } else {
         $typeAlert = "primary";
      }

      $_SESSION['dc_id_temp'] = $_POST['value'];

      $pl = "Insert the 2FA token";
      $btn = "Confirm two factor authentification";
      $pattern = "\b[A-Za-z0-9]{24}\b";
      $type = "password";
      $action = "/pages/account/helper/2fa.enable.php";

      $_SESSION['success'] = '<div class="alert alert-'.$typeAlert.'" alert-dismissible fade show center" role="alert">
                     '.$response.'
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
   } elseif ($_SESSION['user_oauth_provider'] == "Discord Inc." && empty($_COOKIE[$cookie_name]) || $_SESSION['user_oauth_provider'] == "Discord Inc" && empty($_COOKIE[$cookie_name])) {
      // Email @phhajek
   } 
} else {
   if ($_SESSION['user_oauth_provider'] == "Google LLC." || $_SESSION['user_oauth_provider'] == "Google LLC") {
      $pl = "Please enter your Discord ID, e.g. 469208494260617217";
      $btn = "Request token";
      $pattern = "\d{17,21}";
      $type = "text";
      $action = "?rq=1";
   } elseif ($_SESSION['user_oauth_provider'] == "Discord Inc." || $_SESSION['user_oauth_provider'] == "Discord Inc") {
      $pl = "Please enter your email address";
      $btn = "Request mail";
      $pattern = "\b[A-Z0-9a-z]+@[A-Z0-9.-]+\.[A-Z]{2,}\b";
      $type = "text";
      $action = "?rq=1";
   } 
}


function startsWith( $haystack, $needle ) {
   $length = strlen( $needle );
   return substr( $haystack, 0, $length ) === $needle;
}
?>
<section class="pt-5 pb-5">
   <div class="container">
      <div class="row d-flex justify-content-center">
      <div class="col-md-7">
         <?php echo $_SESSION['success']; 
         unset($_SESSION['success']);
         ?>
         <div class="card border border-success">
            <div class="card-body text-center p-5">
            <h3 class="pb-2 h3 mt-1">Two-Factor Authentication</h3>
            <p class="lead">Ensure the security of your account - enable the Two-Factor Authentication. </p>
            <form action="<?php echo $action; ?>" method="post">
               <input type="text" name="call" value="callFunc" hidden>
					<input type="text" name="id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
					<input type="text" name="mail" value="<?php echo $_SESSION['user_email']; ?>" hidden>
               <input type="text" name="dcid" value="<?php echo $_SESSION['dc_id_temp']; ?>" hidden>
               <input class="form-control mt-md-3" type="<?php echo $type;?>" pattern="<?php echo $pattern; ?>" name="value" placeholder="<?php echo $pl; ?>" required>
               <button type="submit" class="btn btn-xs btn-round btn-sm btn-success btn-rised mt-md-3"><?php echo $btn; ?></button> <br>
               <a href="/account/">Back</a>
            </form>
            </div>
         </div>
      </div>
      </div>
   </div>
</section>