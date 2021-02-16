<?php include('./include/header-banner.php'); ?> 
<div class="container mt-5">
   <div class="col">
      <div class="row">
         <div class="col mb-5">
            <div class="e-profile" id="status">
            <?php 
            // Statusvalues:
            // 0 = Operational
            // 1 = Degraded Performance
            // 2 = Partial Outage
            // 3 = Major Outage
            // 4 = Maintenance
            // 5 = Security Mode (Cloudflare)
            $stmt = $conn->prepare("SELECT * FROM fm_status");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            $main = $data[0]['status'];
            $updown = $data[1]['status'];
            $discord = $data[2]['status'];
            $google = $data[3]['status'];
            $github = $data[4]['status'];
            $advertisement = $data[5]['status'];
            $cookies = $data[6]['status'];
            $location = $data[7]['status'];
            $payment = $data[8]['status'];

            if ($main == 0 && $updown == 0 && $discord == 0 && $google == 0 && $github == 0 && $advertisement == 0 && $cookies == 0 && $location == 0 && $payment == 0) {
                echo '<div class="card bg-success text text-white rounded mb-3">
            <div class="card-body d-flex justify-content-between" style="font-size:19px;">
                <b>All Systems Operational</b>
                <div>
                <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
                <button id="btnRefresh" class="btn btn-outline-light rounded" title="Refresh Statuspage"><i class="fas fa-redo"></i></button>
                </div>
            </div>
            </div>';
            } elseif ($main == 5 || $updown == 5 || $discord == 5 || $google == 5 || $github == 5 || $advertisement == 5 || $cookies == 5 || $location == 5 || $payment == 5) {
                echo '<div class="card bg-dark text text-white rounded mb-3">
            <div class="card-body d-flex justify-content-between" style="font-size:19px;">
                <b>Security Mode</b>
                <div>
                <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
                <button id="btnRefresh" class="btn btn-outline-light rounded" title="Refresh Statuspage"><i class="fas fa-redo"></i></button>
                </div>
            </div>
            </div>';
            } elseif ($main == 4 || $updown == 4 || $discord == 4 || $google == 4 || $github == 4 || $advertisement == 4 || $cookies == 4 || $location == 4 || $payment == 4) {
                echo '<div class="card bg-info text text-white rounded mb-3">
            <div class="card-body d-flex justify-content-between" style="font-size:19px;">
                <b>Maintenance</b>
                <div>
                <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
                <button id="btnRefresh" class="btn btn-outline-light rounded" title="Refresh Statuspage"><i class="fas fa-redo"></i></button>
                </div>
            </div>
            </div>';
            } elseif ($main == 3 || $updown == 3 || $discord == 3 || $google == 3 || $github == 3 || $advertisement == 3 || $cookies == 3 || $location == 3 || $payment == 3) {
                echo '<div class="card bg-danger text text-white rounded mb-3">
            <div class="card-body d-flex justify-content-between" style="font-size:19px;">
                <b>Major Outage</b>
                <div>
                <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
                <button id="btnRefresh" class="btn btn-outline-light rounded" title="Refresh Statuspage"><i class="fas fa-redo"></i></button>
                </div>
            </div>
            </div>';
            } elseif ($main == 2 || $updown == 2 || $discord == 2 || $google == 2 || $github == 2 || $advertisement == 2 || $cookies == 2 || $location == 2 || $payment == 2) {
                echo '<div class="card bg-primary text text-white rounded mb-3">
            <div class="card-body d-flex justify-content-between btnRefresh" style="font-size:19px;">
                <b>Partial Outage</b>
                <div>
                <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
                <button id="btnRefresh" class="btn btn-outline-light rounded" title="Refresh Statuspage"><i class="fas fa-redo"></i></button>
                </div>
            </div>
            </div>';
            } elseif ($main == 1 || $updown == 1 || $discord == 1 || $google == 1 || $github == 1 || $advertisement == 1 || $cookies == 1 || $location == 1 || $payment == 1) {
                echo '<div class="card bg-warning text text-white rounded mb-3">
            <div class="card-body d-flex justify-content-between" style="font-size:19px;">
                <b>Degraded Performance</b>
                <div>
                <!-- <button class="btn btn-outline-light rounded" title="Join Newsletter" onclick="location.reload();"><i class="far fa-newspaper"></i></button> -->
                <button id="btnRefresh" class="btn btn-outline-light rounded" title="Refresh Statuspage"><i class="fas fa-redo"></i></button>
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
                        <?php
                        if ($main == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($main == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($main == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($main == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                                <span><i class="fas fa-times text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($main == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($main == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Main Website Accessibility</b> <i class="far fa-question-circle" title="Status of the main website accessibility. This should be always green!"></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        if ($updown == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($updown == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($updown == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($updown == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($updown == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($updown == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Up & Down Service</b> <i class="far fa-question-circle" title="FiveMods.net upload and download service check. Controls if you can either upload and or download products."></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        ?>
                    </div>
                    <div class="row mt-2">
                        <?php
                        if ($discord == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($discord == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($discord == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($discord == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($discord == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($discord == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Discord Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Discord login service."></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        } 
                        if ($google == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($google == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($google == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($google == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($google == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($google == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Google Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Google login service."></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        ?>
                    </div>
                    <div class="row mt-2">
                        <?php
                        if ($advertisement == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($advertisement == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($advertisement == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($advertisement == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($advertisement == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($advertisement == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Advertisement Service</b> <i class="far fa-question-circle" title="Status for our own advertisement service. Thats something we planned for the future!"></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        if ($cookies == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($cookies == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($cookies == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($cookies == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($cookies == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($cookies == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Cookie & Session Service</b> <i class="far fa-question-circle" title="Status for the FiveMods cookie and session service. Important for login and account features."></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        ?>
                    </div>
                    <div class="row mt-2">
                        <?php
                        if ($location == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($location == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($location == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($location == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($location == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($location == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Location & GeoIP Service</b> <i class="far fa-question-circle" title="Status for the GeoIP and Location serivice. Important for login and account features."></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        if ($payment == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($payment == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($payment == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($payment == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($payment == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($payment == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Payment and Invoice Service</b> <i class="far fa-question-circle" title="Status for the Payment and Invoice service"></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        
                        ?>
                    </div>
                    <div class="row mt-2">
                        <?php
                        if ($github == 0) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-success">
                                <span><b>FiveMods Github Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Github login service."></i></span>
                                <span><i class="fas fa-check text text-success"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($github == 1) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-warning">
                                <span><b>FiveMods Github Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Github login service."></i></span>
                                <span><i class="fas fa-battery-quarter text text-warning"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($github == 2) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-primary">
                                <span><b>FiveMods Github Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Github login service."></i></span>
                                <span><i class="fas fa-exclamation-triangle text text-primary"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($github == 3) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-danger">
                                <span><b>FiveMods Github Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Github login service."></i></span>
                                <span><i class="fas fa-times text text-danger"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($github == 4) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-info">
                                <span><b>FiveMods Github Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Github login service."></i></span>
                                <span><i class="fas fa-wrench text text-info"></i></span>
                            </div>
                            </div>
                        </div>';
                        } elseif ($github == 5) {
                            echo '<div class="col">
                            <div class="card rounded">
                            <div class="card-body d-flex justify-content-between border-bottom border-purple">
                                <span><b>FiveMods Github Login Authorization</b> <i class="far fa-question-circle" title="Exclusive Github login service."></i></span>
                                <span><i class="fas fa-lock text text-purple"></i></span>
                            </div>
                            </div>
                        </div>';
                        }
                        ?>
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
    }, 30000);
});
</script>
<script>
$(document).on('click','#btnRefresh',function(){
    $("#status").load("/pages/status/api/page.php");
});
</script>