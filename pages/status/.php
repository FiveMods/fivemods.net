<?php include('./include/header-banner.php'); ?> 
<div class="container mt-5">
   <div class="col">
      <div class="row">
         <div class="col mb-5">
            <div class="e-profile" id="status">

               
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Load status -->
<script>
    $(document).ready(function() {
        $("#status").load("/pages/status/api/page.php");

        var intervalId = window.setInterval(function(){
            $("#status").load("/pages/status/api/page.php");
        }, 5000);
    });
</script>