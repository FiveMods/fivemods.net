<?php

require_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Not allowed!";
    header('location: /account/logout/?url=error');
    exit;
} else {

    if ($_SESSION['user_id'] != htmlspecialchars($_POST['uid'])) {
        header('location: /account/');
    } else {

        include('./include/header-banner.php');

        session_start();

        if ($_SESSION['user_blocked'] == 1) {
            header('location: /account/logout/?url=banned');
        }

        if (!isset($_SESSION['user_id'])) {
            header('location: /account/logout/');
            exit();
        }

        $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');

        if (isset($_POST['id'])) {
            $modid = htmlspecialchars($_POST['id']);
            $_SESSION['mmid'] = $modid;
        } else {
            exit();
            die();
        }

        $statement = $pdo->prepare("SELECT * FROM mods WHERE m_id = ?");
        $statement->execute(array($modid));
        while ($r = $statement->fetch()) {
            $m_id = $r['m_id'];
            $m_authorid = $r['m_authorid'];
            $m_name = $r['m_name'];
            $m_picture = $r['m_picture'];
            $m_category = $r['m_category'];
            $m_tags = $r['m_tags'];
            $m_description = $r['m_description'];
            $m_predescription = $r['m_predescription'];
            $m_changelog = $r['m_changelog'];
            $m_authorid2 = $r['m_authorid2'];
            $m_requiredmod = $r['m_requiredmod'];
            $m_downloadlink = $r['m_downloadlink'];
            $m_approved = $r['m_approved'];
            $m_approvedby = $r['m_approvedby'];
            $m_denyreason = $r['m_denyreason'];
            $m_downloads = $r['m_downloads'];
            $m_blocked = $r['m_blocked'];
            $m_blockedby = $r['m_blockedby'];
            $m_blockreason = $r['m_blockedreason'];
            $m_rating = $r['m_rating'];
            $m_price = $r['m_price'];
            $m_prices = $r['m_prices'];
            $m_created_at = $r['m_created-at'];
            $m_updated_at = $r['m_updated-at'];
        }

        if ($m_authorid != $_SESSION['user_iid']) {
            header('location: /account/logout/?url=error');
        }
    }
}

?>
<meta http-equiv="refresh" content="1440;url=/logout/?url=timeout" />
<style>
    textarea {
        resize: none;
        overflow: hidden;
        min-height: 50px;
        max-height: 100px;
    }
</style>
<script>
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }
</script>
<div class="container mt-5 mb-5">
    <?php echo $_SESSION['modsuccess']; ?>
    <?php

    if ($m_approved == "0") {
        echo '<section class="mb-3 bg-success">
    <div class="container-fluid">
       <div class="row d-flex">
          <div class="col-md-12">
             <div class="card bg-transparent text-light text-center border-0">
                <div class="card-body pt-1 pb-1">
                   <p class="lead pb-0 mb-0">
                   <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> | Your mod got approved by <a href="/user/' . $m_approvedby . '/" class="text-white">' . $m_approvedby . '</a>.
                   </p>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>';
    } elseif ($m_approved == "-1") {
        echo '<section class="mb-3 bg-danger">
    <div class="container-fluid">
       <div class="row d-flex">
          <div class="col-md-12">
             <div class="card bg-transparent text-light text-center border-0">
                <div class="card-body pt-1 pb-1">
                   <p class="lead pb-0 mb-0">
                   <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> | Your mod got denied. Reason: ' . $m_denyreason . '.
                   </p>
                   <small>You may adjust your modification to fit our <a href="/upload-policy/" class="text text-white">Upload Policies</a>.</small>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>';
    } elseif ($m_approved == "1") {
        echo '<section class="mb-3 bg-info">
    <div class="container-fluid">
       <div class="row d-flex">
          <div class="col-md-12">
             <div class="card bg-transparent text-light text-center border-0">
                <div class="card-body pt-1 pb-1">
                   <p class="lead pb-0 mb-0">
                   <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> | Your mod is currently getting reviewed.
                   </p>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>';
    }

    ?>
    <div class="row gutters-sm">
        <div class="col-md-4 d-none d-md-block">
            <div class="card">
                <div class="card-body">
                    <nav class="nav flex-column nav-pills nav-gap-y-1">
                        <a href="#settings" data-toggle="tab" data-target="#profile" class="nav-item nav-link has-icon nav-link-faded active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>Mod Settings
                        </a>
                        <a href="#stats" data-toggle="tab" data-target="#stats" class="nav-item nav-link has-icon nav-link-faded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2 mr-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            Mod Stats
                        </a>
                        <a href="/account/" class="nav-item nav-link has-icon nav-link-faded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>Back to Profile
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom mb-3 d-flex d-md-none">
                    <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" class="nav-link has-icon active">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#stats" data-toggle="tab" class="nav-link has-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2 mr-2">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile" data-toggle="tab" class="nav-link has-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">
                    <div class="tab-pane active" id="profile">
                        <h6>MOD SETTINGS</h6>
                        <hr>
                        <form action="/pages/account/helper/mod.edit.php" method="post">
                            <div class="form-group">
                                <label for="modName">Mod Name <a href="#info" class="text text-danger">*</a> </label>
                                <input type="text" class="form-control" name="modName" id="modName" minlength="10" maxlength="75" aria-describedby="modName" placeholder="Enter the prodcut name" value="<?php echo $m_name; ?>" required>
                                <small id="modName" class="form-text text-muted">The title has to be at least 10 and max. 75 characters long. You can change it at any time.</small>
                            </div>
                            <div class="form-group">
                                <label for="modDesc">Mod Description <a href="#info" class="text text-danger">*</a></label>
                                <textarea oninput="auto_grow(this)" class="form-control autosize" rows="50" name="modDesc" id="modDesc" minlegth="150" maxlength="1000" placeholder="Write something about your product" required><?php echo $m_description; ?></textarea>
                                <small id="modDesc" class="form-text text-muted">The description has to be at least 150 characters and max. 1000 chars long</small>
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="modCategory">Change category <span class="text text-danger">*</span></label>
                                    <select class="custom-select" id="modCategory" name="modCategory" required>
                                        <option value="Choose" disabled selected>Choose category...</option>
                                        <option value="Scripts">Scripts</option>
                                        <option value="Vehicles">Vehicles</option>
                                        <option value="Weapons">Weapons</option>
                                        <option value="Peds">Peds</option>
                                        <option value="Maps">Maps</option>
                                        <option value="Liveries">Liveries</option>
                                        <option value="Misc">Misc</option>
                                    </select>
                                    <small id="modCategory" class="form-text text-muted">You can change the mod category easily.</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="tags">Change your tags <span class="text text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tags" name="tags" minlength="3" value="<?php echo $m_tags; ?>" required placeholder="You can add multiple tags, just seperate them with a comma.">
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="requiredMod">Change required Mod</label>
                                    <input type="url" class="form-control" id="requiredMod" name="requiredMod" value="<?php if ($m_requiredmod == "0") {
                                                                                                                            echo "";
                                                                                                                        } else {
                                                                                                                            echo $m_requiredmod;
                                                                                                                        }; ?>" placeholder="URL">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label>Change your pictures here <span class="text text-danger">*</span></label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="picupload[]" id="picupload" accept=".jpg, .png, .jpeg, .webp" multiple required>
                                    <label class="custom-file-label" for="picupload">Choose file...</label>
                                </div>
                            </div> -->
                            <div class="form-group small text-muted" id="info">
                                Fields marked with <span class="text text-danger">*</span> are mandatory fields and must be filled out.
                            </div>
                            <input type="text" name="call" value="callFunc" hidden>
                            <input type="text" name="id" value="<?php echo $_SESSION['user_iid']; ?>" hidden>
                            <button type="submit" class="btn btn-primary">Save & Update</button>
                            <a href="?del=<?php echo $m_id; ?>" class="btn btn-danger">Delete mod</a>
                        </form>
                        <!-- <p class="mt-4 form-group small text-muted">Mit <span class="text text-danger">*</span> gekennzeichnete Felder sind sogennante Pflichtfelder und müssen ausgefüllt werden.</p> -->
                    </div>
                    <div class="tab-pane" id="stats">
                        <h6>MOD STATS</h6>
                        <hr>
                        <div class="form-group mb-0">
                            <label class="d-block">Rating</label>
                            <?php

                            $number = 0;
                            if (!empty($m_rating)) {
                                $rateArray = explode(" ", $m_rating);
                                $number = 0;
                                for ($i = 0; $i < count($rateArray); $i++) {
                                    $number = $number + $rateArray[$i];
                                }
                                $number = round($number / count($rateArray));
                            }

                            ?>
                            <p class="font-size-sm text-muted">There are curretnly <b><?php echo count($rateArray); ?></b> ratings on your mod.</p>
                        </div>
                        <hr>
                        <div class="form-group mb-0">
                            <label class="d-block">Estimated income:</label>
                            <p class="font-size-sm text-muted">The estimated income for this mod <b>$<?php echo $m_downloads / (1000); ?></b></p>
                        </div>
                        <hr>
                        <div class="form-group mb-0">
                            <label class="d-block">Total downloads:</label>
                            <p class="font-size-sm text-muted">There are <b><?php echo $m_downloads; ?></b> total downloads for this mod.</p>
                        </div>
                        <hr>
                        <div class="form-group mb-0">
                            <label class="d-block">Dates:</label>
                            <p class="font-size-sm text-muted">Last update: <?php echo $m_updated_at; ?><br>Mod creation: <?php echo $m_created_at; ?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $("#success-alert").hide();
        $("#myWish").click(function showAlert() {
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                $("#success-alert").slideUp(500);
            });
        });
    });
</script>