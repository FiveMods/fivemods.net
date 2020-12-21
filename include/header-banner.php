<style>
.fill {
    min-height: 17vh;
    transform: scale(1,1);
    overflow: hidden;
    background-size: cover;
    background-position: center;
    background-image: url('<?php if (empty($_SESSION['user_iid'])) {
   echo $css_banner;
} else { echo $_SESSION['user_banner']; }  ?>');
}
</style>
<section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-light blinker fill">
    <div class="container-fluid">
       <div class="row  justify-content-center align-items-center d-flex text-center h-100">
          <div class="col-12 col-md-8 h-50">
          </div>
       </div>
    </div>
 </section>