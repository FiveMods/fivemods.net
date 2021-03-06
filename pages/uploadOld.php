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
session_start();
include('./include/header-banner.php');


if(!isset($_COOKIE['f_val']) || !isset($_COOKIE['f_key'])) {
	header("location: /account/logout/");
	exit();
	die();
}
require_once('./config.php');

   $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

   $selVals = $pdo->prepare("SELECT * FROM user WHERE uuid = ?");
   $selVals->execute(array($_SESSION['uuid']));
   $vals = $selVals->fetch();
if (isset($_POST['uploadMod'])) {

   $path = '../storage-html/uploads';
   $userid = $vals['id'];
   $downloadWebsite = 'https://storage.fivemods.net/uploads';

   $modid = randomChars(12);

   $title = htmlspecialchars($_POST['title']);
   $description = nl2br($_POST['description']);
   $category = htmlspecialchars($_POST['category']);
   $tags = htmlspecialchars($_POST['tags']);

   if (empty(htmlspecialchars($_POST['requiredMod']))) {
      $requiredMod = "0";
   } else {
      $requiredMod = htmlspecialchars($_POST['requiredMod']);
   }

   if (empty(htmlspecialchars($_POST['price']))) {
      $price = NULL;
   } else {
      $price = htmlspecialchars($_POST['price']);
   }

   if (!is_dir($path . '/' . $userid)) mkdir($path . '/' . $userid);
   if (!is_dir($path)) mkdir($path);

   mkdir($path . '/' . $userid . '/' . $modid);
   mkdir($path . '/' . $userid . '/' . $modid . '/img');

   move_uploaded_file($_FILES["modupload"]["tmp_name"], $path . '/' . $userid . '/' . $modid . '/' . basename($_FILES["modupload"]["name"]));
   rename($path . '/' . $userid . '/' . $modid . '/' . basename($_FILES["modupload"]["name"]), $path . '/' . $userid . '/' . $modid . '/' . preg_replace("/([#&%§$]{1,})/", "_",str_replace(" ", "_", strtolower($title)) . '-' . $modid . '.zip'));
   $download = $downloadWebsite . '/' . $userid . '/' . $modid . '/' . preg_replace("/([#&%§$]{1,})/", "_",str_replace(" ", "_", strtolower($title)) . '-' . $modid . '.zip');
   $pictures = [];
   foreach ($_FILES["picupload"]["error"] as $key => $error) {
      if ($error == "UPLOAD_ERR_OK") {
         move_uploaded_file($_FILES["picupload"]["tmp_name"][$key], $path . '/' . $userid . '/' . $modid . '/' . 'img/' . basename($_FILES["picupload"]["name"][$key]));
         $fileEnding = substr($_FILES["picupload"]["name"][$key], -5);
         $fileName = randomChars(20);
         rename($path . '/' . $userid . '/' . $modid . '/' . 'img/' . basename($_FILES["picupload"]["name"][$key]), $path . '/' . $userid . '/' . $modid . '/' . 'img/' . $fileName . $fileEnding);
         array_push($pictures, $downloadWebsite . '/' . $userid . '/' . $modid . '/' . 'img/' . $fileName . $fileEnding);
      }
   }
   $pictures = implode(" ", $pictures);

   if($vals['premium'] == 0) {
      $approved = 1;
      $approvedby = NULL;
   } else {
      $approved = 0;
      $approvedby = "Automatically";
   }




   $statement = $pdo->prepare("INSERT INTO mods (m_authorid, m_name, m_picture, m_category, m_tags, m_description, m_requiredmod, m_downloadlink, m_price, m_approved, m_approvedby) VALUES (:uid, :title, :pictures, :category, :tags, :m_description, :requiredMod, :download, :price, :approved, :approvedby)");
   $statement->execute(array('uid' => $userid, 'title' => $title, 'pictures' => $pictures, 'category' => $category, 'tags' => $tags, 'm_description' => $description, 'requiredMod' => $requiredMod, 'download' => $download, 'price' => $price, 'approved' => $approved, 'approvedby' => $approvedby));

   $_SESSION['upload'] = 1;


   if($vals['premium'] == 1) {

      $stmt = $pdo->prepare("SELECT m_id FROM mods WHERE m_name = :name AND m_picture = :pic");
      $stmt->execute(array("name" => $title, "pic" => $pictures));
      $statement = $stmt->fetch();

      $ch = curl_init();
      $token = $apiToken;
      $modid = $statement['m_id'];

      curl_setopt($ch, CURLOPT_URL,"http://85.214.166.192:8081");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "action=newMod&token=$token&modid=$modid");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
   }


   header("Location: /helper/manage.php?upload=1");
   exit();
   die();
}

$pdo = null;
function randomChars($length)
{
   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   return substr(str_shuffle($permitted_chars), 0, $length);
} ?>
<style>
   .submitFinal {
      padding-left: 10%;
      padding-right: 10%;
      display: block;
      margin: auto;
   }

   .center {
      text-align: center;
   }

   .btn-upload {
      margin-right: 5px;
   }

   .final-upload p,
   .final-upload li {
      margin-left: 25%;
   }
</style>
<section class="pt-5 pb-5">
   <div class="container">
      <div class="card">
         <div class="card-header">
            <h3><?php echo $lang['upload-text1']; ?></h3>
         </div>

         <div class="card-body">
            <form autocomplete="off" class="was-validated" method="post" action="/upload" enctype="multipart/form-data">
               <div class="row d-flex justify-content-center">
                  <div class="col-sm-12 col-12">
                     <?php
                     if (isset($_SESSION['upload'])) :
                        unset($_SESSION['upload']);
                     ?>
                        <div class="alert alert-success alert-dismissible fade show center" role="alert">
                           <strong>Success!</strong> You successfully uploaded a modification!
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     <?php endif; ?>
                     <div class="card-header pills-regular d-flex justify-content-center">
                        <ul class="nav nav-pills card-header-pills" role="tablist">
                           <li class="nav-item">
                              <button class="btn btn-primary rounded btn-upload nav-link active show" id="card-pills-1" data-toggle="tab" href="#card-pill-1" role="tab" aria-controls="card-1" aria-selected="true">1</span>
                           </li>
                           <li class="nav-item">
                              <button class="btn btn-primary rounded btn-upload nav-link" id="card-pills-2" data-toggle="tab" href="#card-pill-2" role="tab" aria-controls="card-2" aria-selected="false">2</span>
                           </li>
                           <li class="nav-item">
                              <button class="btn btn-primary rounded btn-upload nav-link" id="card-pills-3" data-toggle="tab" href="#card-pill-3" role="tab" aria-controls="card-3" aria-selected="false">3</span>
                           </li>
                        </ul>
                     </div>
                     <div class="card-body">
                        <div class="tab-content">
                           <!-- Introduction -->
                           <div class="tab-pane fade active show" id="card-pill-1" role="tabpanel" aria-labelledby="card-tab-1">
                              <div class="form-group text-center">
                                 <div class="alert alert-info" role="alert">
                                    <h4 class="alert-heading"><?php echo $lang['welcome'] . ' ' . $vals['name']; ?>!</h4>
                                    <p><?php echo $lang['upload-start-msg']; ?></p>
                                    <hr>
                                    <p class="mb-0"><?php echo $lang['app-time']; ?> </a>: <b>1-3 <?php echo $lang['days']; ?></b></p>
                                 </div>
                              </div>
                           </div>
                           <!-- End Introduction -->
                           <div class="tab-pane fade" id="card-pill-2" role="tabpanel" aria-labelledby="card-tab-2">
                              <!-- Header -->
                              <h2 class="center"><?php echo $lang['upload-prod']; ?></h2><br>
                              <div class="alert alert-warning text-center" role="alert">
                                 <?php echo $lang['fill-fields']; ?> <span class="text text-danger">*</span>
                              </div>

                              <br>
                              <!-- End Header -->
                              <!-- Title -->
                              <div>
                                 <label for="tile">Title <span class="text text-danger">*</span></label>
                                 <input type="text" class="form-control" id="title" name="title" minlength="10" maxlength="75" value="" required>
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">The title has to be at least 10 and max. 75 characters long</div>
                              </div>
                              <br>
                              <!-- Description -->
                              <div>
                                 <label for="description">Description <span class="text text-danger">*</span></label>
                                 <textarea class="form-control" id="description" name="description" value="" rows="5" minlength="150" required></textarea>
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">The description has to be at least 150 characters long</div>
                              </div>
                              <br>
                              <!-- Mod Upload -->
                              <p>Upload your Mod here <span class="text text-danger">*</span></p>
                              <div class="custom-file mb-3">
                                 <input type="file" class="custom-file-input" name="modupload" id="modupload" accept=".zip, .7z, .rar, .tar, .tar.gz" required>
                                 <label class="custom-file-label" for="modupload">Choose file...</label>
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">You have to upload a .zip, .7z, .rar, .tar or .tar.gz file</div>
                              </div>
                              <output id="uploadOutput"></output>
                              <br><br>
                              <!-- Category -->
                              <div>
                                 <label for="category">Select a category <span class="text text-danger">*</span></label>
                                 <select class="custom-select" id="category" name="category" onChange="CategoryFeedback(this)" required>
                                    <option value="" disabled selected>Choose category...</option>
                                    <option value="Scripts">Scripts</option>
                                    <option value="Vehicles">Vehicles</option>
                                    <option value="Weapons">Weapons</option>
                                    <option value="Peds">Peds</option>
                                    <option value="Maps">Maps</option>
                                    <option value="Liveries">Liveries</option>
                                    <option value="Misc">Misc</option>
                                 </select>
                                 <div id="categoryfeedback" class="invalid-feedback">You have to select a category</div>
                              </div>
                              <br>
                              <!-- Tags -->
                              <div>
                                 <label for="tags">Set some tags <span class="text text-danger">*</span></label>
                                 <input type="text" class="form-control" id="tags" name="tags" minlength="3" value="" required placeholder="You can add multiple tags, just seperate them with a comma.">
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">You have to set at least one tag!</div>
                              </div>
                              <br>
                              <!-- Picture Upload -->
                              <p>Upload some pictures here <span class="text text-danger">*</span></p>
                              <div class="custom-file mb-3">
                                 <input type="file" class="custom-file-input" name="picupload[]" id="picupload" accept=".jpg, .png, .jpeg, .webp" multiple required>
                                 <label class="custom-file-label" for="picupload">Choose file...</label>
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">You have to upload at least one .jpg, .jpeg, .png or .webp image file (max. 10 pictures)</div>
                              </div>
                              <output id="pictureOutput"></output>
                              <br><br>
                              <!-- Required Mod -->
                              <div>
                                 <label for="requiredMod">Required Mod</label>
                                 <input type="url" class="form-control" id="requiredMod" name="requiredMod" value="" placeholder="URL">
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">You have to use an URL</div>
                              </div>
                              <br>
                              <!-- Price suggestion -->
                              <!--
                              <div>
                                 <label for="price">Price suggestion</label>
                                 <input type="number" class="form-control" id="price" name="price" value="" placeholder="Use this if you want your mod to be sold on FiveMods. Payment Policy applies." max="5">
                                 <div class="valid-feedback">Looks good!</div>
                                 <div class="invalid-feedback">You have to use a number between 0 and 5</div>
                              </div>
                              -->
                           </div>
                           <div class="tab-pane fade" id="card-pill-3" role="tabpanel" aria-labelledby="card-tab-3">
                              <!-- Header -->
                              <h2 class="text-center"><?php echo $lang['nearly-done']; ?></h2><br>
                              <div class="alert alert-warning final-upload" role="alert">
                                 <p><?php echo $lang['upload-submit1']; ?> </p>
                                 <div class="text-center">
                                    <a href="/upload-policy/"><?php echo $lang['upload-policy']; ?></a>
                                 </div>
                                 <p>
                                 <?php echo $lang['upload-submit2']; ?>
                                 </p>
                              </div>
                              <br>
                              <!-- End Header -->
                              <div class="form-group d-flex justify-content-center">
                                 <input name="uploadMod" value="1" hidden>
                                 <button type="submit" class="btn btn-primary" style="margin-right: 5px;"><?php echo $lang['accept-and-upload']; ?> </button>
                                 <button type="reset" class="btn btn-danger">Reset</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
<script>
   window.addEventListener("load", function(event) {
      console.log("Site loaded!");
   });

   function picchange(evt) {

      var files = evt.target.files;

      var fragments = [];

      for (var i = 0, f; f = files[i]; i++) {
         fragments.push('<li><strong>', f.name, '</strong> (', f.type || 'n/a', ') - ',
                        f.size, ' bytes</li>');
      }
   document.getElementById('pictureOutput').innerHTML = '<ul>' + fragments.join('') + '</ul>';
   }

   function uploadChange(evt) {

      var files = evt.target.files;

      var fragments = [];

      for (var i = 0, f; f = files[i]; i++) {
         fragments.push('-> <strong>', f.name, '</strong> (', f.type || 'n/a', ') - ',
            (f.size / 1000000).toString().slice(0, 4) , ' MB');
      }
   document.getElementById('uploadOutput').innerHTML = fragments.join('');
   }

   document.addEventListener("DOMContentLoaded", function() {
      document.getElementById('picupload').addEventListener('change', picchange, false);
      document.getElementById('modupload').addEventListener('change', uploadChange, false);
   });


   function CategoryFeedback(item) {
      document.getElementById('categoryfeedback').className = "valid-feedback";
      document.getElementById('categoryfeedback').innerHTML = "Looks good!";
   };

    var modupload = document.getElementById('modupload');
    modupload.onchange = function() {
        if (!modupload.files[0].name.endsWith(".zip") && !modupload.files[0].name.endsWith(".7z") && !modupload.files[0].name.endsWith(".rar") && !modupload.files[0].name.endsWith(".tar") && !modupload.files[0].name.endsWith(".tar.gz")) {
            modupload.value = '';
        }
    };
    var picupload = document.getElementById('picupload');
    picupload.onchange = function() {
        if (picupload.files.length <= 10) {
            for (let v = 0; v < picupload.files.length; v++) {
            if (!picupload.files[v].name.endsWith(".png") && !picupload.files[v].name.endsWith(".jpg") && !picupload.files[v].name.endsWith(".jpeg") && !picupload.files[v].name.endsWith(".webp")) {
                picupload.value = '';
                break;
            }
         }
      } else {
         picupload.value = '';
      }
   };
</script>
