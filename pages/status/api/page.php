<?php 
// Statusvalues:
// 0 = Operational
// 1 = Degraded Performance
// 2 = Partial Outage
// 3 = Major Outage
// 4 = Maintenance
// 5 = Security Mode (Cloudflare)


if ($statusvalue == 0) {
    echo '<div class="card bg-success text text-white rounded mb-3">
<div class="card-body d-flex justify-content-between" style="font-size:19px;">
    <b>All Systems Operational</b>
    <div>
    <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
    <button class="btn btn-outline-light rounded" title="Refresh Statuspage" onclick="location.reload();"><i class="fas fa-redo"></i></button>
    </div>
</div>
</div>';
} elseif ($statusvalue == 1) {
    echo '<div class="card bg-warning text text-white rounded mb-3">
<div class="card-body d-flex justify-content-between" style="font-size:19px;">
    <b>Degraded Performance</b>
    <div>
    <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
    <button class="btn btn-outline-light rounded" title="Refresh Statuspage" onclick="location.reload();"><i class="fas fa-redo"></i></button>
    </div>
</div>
</div>';
} elseif ($statusvalue == 2) {
    echo '<div class="card bg-primary text text-white rounded mb-3">
<div class="card-body d-flex justify-content-between" style="font-size:19px;">
    <b>Partial Outage</b>
    <div>
    <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
    <button class="btn btn-outline-light rounded" title="Refresh Statuspage" onclick="location.reload();"><i class="fas fa-redo"></i></button>
    </div>
</div>
</div>';
} elseif ($statusvalue == 3) {
    echo '<div class="card bg-danger text text-white rounded mb-3">
<div class="card-body d-flex justify-content-between" style="font-size:19px;">
    <b>Major Outage</b>
    <div>
    <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
    <button class="btn btn-outline-light rounded" title="Refresh Statuspage" onclick="location.reload();"><i class="fas fa-redo"></i></button>
    </div>
</div>
</div>';
} elseif ($statusvalue == 4) {
    echo '<div class="card bg-info text text-white rounded mb-3">
<div class="card-body d-flex justify-content-between" style="font-size:19px;">
    <b>Maintenance</b>
    <div>
    <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
    <button class="btn btn-outline-light rounded" title="Refresh Statuspage" onclick="location.reload();"><i class="fas fa-redo"></i></button>
    </div>
</div>
</div>';
} elseif ($statusvalue == 5) {
    echo '<div class="card bg-dark text text-white rounded mb-3">
<div class="card-body d-flex justify-content-between" style="font-size:19px;">
    <b>Security Mode</b>
    <div>
    <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
    <button class="btn btn-outline-light rounded" title="Refresh Statuspage" onclick="location.reload();"><i class="fas fa-redo"></i></button>
    </div>
</div>
</div>';
} else {
    echo "something went wrong";
}



?>               
<div class="ml-4 mr-4 mb-4 d-flex justify-content-between">
<span><i class="fas fa-check text text-success pr-1"></i> Operational</span>
<span><i class="fas fa-battery-quarter text text-warning pr-1"></i> Degraded Performance</span>
<span><i class="fas fa-exclamation-triangle text text-primary pr-1"></i> Partial Outage</span>
<span><i class="fas fa-times text text-danger pr-1"></i> Major Outage</span>
<span><i class="fas fa-wrench text text-info pr-1"></i> Maintenance</span>
<span><i class="fas fa-lock text text-purple pr-1"></i> Security Mode</span>
</div>
<div class="tab-content pt-3">
<div id="settings" class="tab-pane active">
    <div class="row">
    <div class="col">
        <div class="mt-2">
            <p>FiveMods Main Services</p>
            <hr>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-info">
                    <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                    <span><i class="fas fa-wrench text text-info"></i></span>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
            </div>
        </div>
        
        <div class="mt-5">
            <p>FiveM Services</p>
            <hr>
        </div>
        <?php
            // Initialize an URL to the variable 
            $url = array('https://servers.fivem.net/servers','https://fivem.net','https://fivem.net','https://fivem.net','https://runtime.fivem.net/artifacts/fivem/','https://keymaster.fivem.net'); 
            ?> 
        <div class="row mt-2">
            <?php 
                //////////////////////
                // FiveM Serverlist //
                //////////////////////
                $title1="Status for the FiveM Serverlist, showing all servers of fivem with tags.";
                // Use get_headers() function 
                $headers = @get_headers($url[0]); 
                // Use condition to check the existence of URL 
                if($headers && strpos( $headers[0], '200')) { 
                $status = "URL Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-success">
                        <span><b>FiveM Serverlist</b> <i class="far fa-question-circle" title="'.$title1.'"></i></span>
                        <span><i class="fas fa-check text text-success"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue;
                } elseif ($headers && strpos( $headers[0], '302')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-warning">
                        <span><b>FiveM Serverlist</b> <i class="far fa-question-circle" title="'.$title1.'"></i></span>
                        <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+1;
                } elseif ($headers && strpos( $headers[0], '403')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-dark">
                    <span><b>FiveM Serverlist</b> <i class="far fa-question-circle" title="'.$title1.'"></i></span>
                    <span><i class="fas fa-lock text text-dark"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+5;
                } else { 
                $status = "URL Doesn't Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-danger">
                        <span><b>FiveM Serverlist</b> <i class="far fa-question-circle" title="'.$title1.'"></i></span>
                        <span><i class="fas fa-times text text-danger"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+3;
                } 
                
                ///////////////////////////////////////
                // FiveM Login Authorization Service //
                ///////////////////////////////////////        
                $title2="Status for the FiveM Login Authorization Service, checking the login process into servers.";
                // Use get_headers() function 
                $headers = @get_headers($url[1]); 
                // Use condition to check the existence of URL 
                if($headers && strpos( $headers[0], '200')) { 
                $status = "URL Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveM Login Authorization Service</b> <i class="far fa-question-circle" title="'.$title2.'"></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue;
                } elseif ($headers && strpos( $headers[0], '302')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-warning">
                    <span><b>FiveM Login Authorization Service</b> <i class="far fa-question-circle" title="'.$title2.'"></i></span>
                    <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+1;
                } elseif ($headers && strpos( $headers[0], '403')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-dark">
                <span><b>FiveM Login Authorization Service</b> <i class="far fa-question-circle" title="'.$title2.'"></i></span>
                <span><i class="fas fa-lock text text-dark"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+5;
                } else { 
                $status = "URL Doesn't Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-danger">
                    <span><b>FiveM Login Authorization Service</b> <i class="far fa-question-circle" title="'.$title2.'"></i></span>
                    <span><i class="fas fa-times text text-danger"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+3;
                } 
                
                ?>
        </div>
        <div class="row mt-2">
            <?php 
                /////////////////////////////////////
                // FiveM Main Ingame Accessibility //
                /////////////////////////////////////
                $title3="Status for the accessibility for the ingame content.";
                // Use get_headers() function 
                $headers = @get_headers($url[2]); 
                // Use condition to check the existence of URL 
                if($headers && strpos( $headers[0], '200')) { 
                $status = "URL Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-success">
                        <span><b>FiveM Main Ingame Accessibility</b> <i class="far fa-question-circle" title="'.$title3.'"></i></span>
                        <span><i class="fas fa-check text text-success"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue;
                } elseif ($headers && strpos( $headers[0], '302')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-warning">
                        <span><b>FiveM Main Ingame Accessibility</b> <i class="far fa-question-circle" title="'.$title3.'"></i></span>
                        <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+1;
                } elseif ($headers && strpos( $headers[0], '403')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-dark">
                    <span><b>FiveM Main Ingame Accessibility</b> <i class="far fa-question-circle" title="'.$title3.'"></i></span>
                    <span><i class="fas fa-lock text text-dark"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+5;
                } else { 
                $status = "URL Doesn't Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-danger">
                        <span><b>FiveM Main Ingame Accessibility</b> <i class="far fa-question-circle" title="'.$title3.'"></i></span>
                        <span><i class="fas fa-times text text-danger"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+3;
                } 
                
                ///////////////////
                // FiveM Website //
                ///////////////////        
                $title4="Status for the general FiveM website.";
                // Use get_headers() function 
                $headers = @get_headers($url[3]); 
                // Use condition to check the existence of URL 
                if($headers && strpos( $headers[0], '200')) { 
                $status = "URL Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveM Website</b> <i class="far fa-question-circle" title="'.$title4.'"></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue;
                } elseif ($headers && strpos( $headers[0], '302')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-warning">
                    <span><b>FiveM Website</b> <i class="far fa-question-circle" title="'.$title4.'"></i></span>
                    <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+1;
                } elseif ($headers && strpos( $headers[0], '403')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-dark">
                <span><b>FiveM Website</b> <i class="far fa-question-circle" title="'.$title4.'"></i></span>
                <span><i class="fas fa-lock text text-dark"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+5;
                } else { 
                $status = "URL Doesn't Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-danger">
                    <span><b>FiveM Website</b> <i class="far fa-question-circle" title="'.$title4.'"></i></span>
                    <span><i class="fas fa-times text text-danger"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+3;
                } 
                
                ?>
        </div>
        <div class="row mt-2">
            <?php 
                /////////////////////
                // FiveM Artifacts //
                /////////////////////
                $title5="Status fot the FiveM server artifacts, linux and windows.";
                // Use get_headers() function 
                $headers = @get_headers($url[4]); 
                // Use condition to check the existence of URL 
                if($headers && strpos( $headers[0], '200')) { 
                $status = "URL Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-success">
                        <span><b>FiveM Artifacts</b> <i class="far fa-question-circle" title="'.$title5.'"></i></span>
                        <span><i class="fas fa-check text text-success"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue;
                } elseif ($headers && strpos( $headers[0], '302')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-warning">
                        <span><b>FiveM Artifacts</b> <i class="far fa-question-circle" title="'.$title5.'"></i></span>
                        <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+1;
                } elseif ($headers && strpos( $headers[0], '403')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-dark">
                    <span><b>FiveM Artifacts</b> <i class="far fa-question-circle" title="'.$title5.'"></i></span>
                    <span><i class="fas fa-lock text text-dark"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+5;
                } else { 
                $status = "URL Doesn't Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                    <div class="card-body d-flex justify-content-between border-bottom border-danger">
                        <span><b>FiveM Artifacts</b> <i class="far fa-question-circle" title="'.$title5.'"></i></span>
                        <span><i class="fas fa-times text text-danger"></i></span>
                    </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+3;
                } 
                
                /////////////////////
                // FiveM Keymaster //
                /////////////////////      
                $title6="Status for the FiveM keymaster, required to create a server.";
                // Use get_headers() function 
                $headers = @get_headers($url[5]); 
                // Use condition to check the existence of URL 
                if($headers && strpos( $headers[0], '200')) { 
                $status = "URL Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-success">
                    <span><b>FiveM Keymaster</b> <i class="far fa-question-circle" title="'.$title6.'"></i></span>
                    <span><i class="fas fa-check text text-success"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue;
                } elseif ($headers && strpos( $headers[0], '302')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-warning">
                    <span><b>FiveM Keymaster</b> <i class="far fa-question-circle" title="'.$title6.'"></i></span>
                    <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+1;
                } elseif ($headers && strpos( $headers[0], '403')) {
                $status = "URL Directing"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-dark">
                <span><b>FiveM Keymaster</b> <i class="far fa-question-circle" title="'.$title6.'"></i></span>
                <span><i class="fas fa-lock text text-dark"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+5;
                } else { 
                $status = "URL Doesn't Exist"; 
                echo '<div class="col">
                <div class="card rounded">
                <div class="card-body d-flex justify-content-between border-bottom border-danger">
                    <span><b>FiveM Keymaster</b> <i class="far fa-question-circle" title="'.$title6.'"></i></span>
                    <span><i class="fas fa-times text text-danger"></i></span>
                </div>
                </div>
                </div>';
                $statusvalue = $statusvalue+3;
                } 
                
                ?>
        </div>
    </div>
    </div>
</div>
</div>
<div class="mt-4">
<p>Last updated: <?php echo date("d. M Y - h:m:sa (H:m:s)"); ?></p>
</div>