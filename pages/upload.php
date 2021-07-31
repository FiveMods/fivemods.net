<div class="leftBasedAds" style="left: 0px; position: fixed; text-align: center; top: 20%;margin-left:3%;">


    <!-- Vertical Test -->
    <ins class="adsbygoogle leftBasedAds" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="2716933531" data-ad-format="auto" data-full-width-responsive="true"></ins> <!-- data-ad-format="auto" data-full-width-responsive="true" -->
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<div class="rightBasedAds" style="right: 0px; position: fixed; text-align: center; top: 20%;margin-right:3%;">

    <!-- Vertical Test -->
    <ins class="adsbygoogle rightBasedAds" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-9727102575141971" data-ad-slot="2716933531" data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<?php
session_start();
include('./include/header-banner.php');
?>
<link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
<script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>
<style>
    .rounded-lg {
        border-radius: 1rem;
    }

    .custom-file-label.rounded-pill {
        border-radius: 50rem;
    }

    .custom-file-label.rounded-pill::after {
        border-radius: 0 50rem 50rem 0;
    }

    .file-upload input[type='file'] {
        display: none;
    }

    .quote-imgs-thumbs--hidden {
        display: none;
    }

    .img-preview-thumb {
        background: #fff;
        border: 1px solid #777;
        border-radius: 0.25rem;
        box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
        margin: .5rem;
        max-width: 140px;
        max-height: 94px;
        /* padding: 0.15rem; */
    }

    .choices__list--multiple .choices__item {
        display: inline-block;
        vertical-align: middle;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 500;
        margin-right: 3.75px;
        margin-bottom: 3.75px;
        background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
        border: 1px solid #fff;
        color: #fff;
        word-break: break-all;
    }

    .choices[data-type*=select-multiple] .choices__button,
    .choices[data-type*=text] .choices__button {
        position: relative;
        display: inline-block;
        margin: 0 -4px 0 8px;
        padding-left: 16px;
        border-left: 1px solid #fff;
        background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjEiIGhlaWdodD0iMjEiIHZpZXdCb3g9IjAgMCAyMSAyMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSIjRkZGIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0yLjU5Mi4wNDRsMTguMzY0IDE4LjM2NC0yLjU0OCAyLjU0OEwuMDQ0IDIuNTkyeiIvPjxwYXRoIGQ9Ik0wIDE4LjM2NEwxOC4zNjQgMGwyLjU0OCAyLjU0OEwyLjU0OCAyMC45MTJ6Ii8+PC9nPjwvc3ZnPg==);
        background-size: 8px;
        width: 8px;
        line-height: 1;
        opacity: .75;
        border-radius: 0;
    }

    #check-short {
        animation: checkshort 500ms linear backwards;
    }

    #check-long {
        opacity: 0;
        animation: checklong 571ms linear 500ms forwards;
    }

    #extra-box {
        animation: extrabox 500ms linear forwards;
    }

    @keyframes checkshort {
        0% {
            clip-path: polygon(0 0, 100% 0, 100% 0%, 0 0%);
        }

        100% {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        }
    }

    @keyframes checklong {
        0% {
            opacity: 1;
            clip-path: polygon(0 78%, 100% 78%, 100% 100%, 0 100%);
        }

        100% {
            opacity: 1;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        }
    }

    @keyframes extrabox {
        0% {
            opacity: 0;
        }

        75% {
            opacity: 0;
        }

        76% {
            opacity: 1;
            clip-path: polygon(0 0, 0 100%, 0 100%, 0 0);
        }

        100% {
            clip-path: polygon(0 100%, 0 0, 100% 0, 100% 100%);
        }
    }
</style>
<div class="row">
    <div class="container">
        <div id="status-bar"></div>
    </div>
</div>
<section class="pt-5 pb-5">

    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-modupload-tab" data-toggle="pill" href="#pills-modupload" role="tab" aria-controls="pills-modupload" aria-selected="false">Mod Upload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-form-tab" data-toggle="pill" href="#pills-form" role="tab" aria-controls="pills-form" aria-selected="false">Form</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-done-tab" data-toggle="pill" href="#pills-done" role="tab" aria-controls="pills-done" aria-selected="false">Done</a>
                    </li>
                </ul>
            </div>
        </div>
    </div> -->

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <section>
                <div class="container p-5">
                    <div class="row">
                        <div class="col-lg-5 mx-auto uploadDiv">
                            <div class="progress mb-2 ml-1 mr-1 rounded">
                                <div class="progress-bar pg-mods bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="p-5 bg-white shadow rounded-lg"><img src="/static-assets/img/svg/upload/upload.svg" loading="lazy" alt="FiveMods upload brand" width="100px" class="d-block mx-auto mb-4 rounded-pill">

                                <h6 class="text-center mb-4 text-muted">
                                    Upload your resource here
                                </h6>

                                <div class="custom-file overflow-hidden rounded-pill mb-5">
                                    <label for="fmUpload" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse for file ...
                                        <input id="fmUpload" type="file" name="files[]" accept=".zip, .7z, .rar, .tar or .tar.gz" required>
                                    </label>
                                </div>
                                <!-- End -->

                                <div class="text-center mb-4 text-muted border p-2" id="uploadPreview">

                                </div>
                                <h6 class="text-center mb-4 text-muted" style="font-size: 10px;">
                                    You have to upload a .zip, .7z, .rar, .tar or .tar.gz file.
                                </h6>
                                <button id="submitUpload" class="btn btn-success btn-block rounded">Save & Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="pills-modupload" role="tabpanel" aria-labelledby="pills-modupload-tab">
            <section>
                <div class="container p-5">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="progress mb-2 ml-1 mr-1 rounded">
                                <div class="progress-bar pg-pics bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="p-5 bg-white shadow rounded-lg"><img src="/static-assets/img/svg/upload/gallery.svg" loading="lazy" alt="FiveMods upload brand" width="100px" class="d-block mx-auto mb-4 rounded-pill">

                                <h6 class="text-center mb-4 text-muted">
                                    Upload your images here
                                </h6>

                                <div class="grid-x grid-padding-x">
                                    <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
                                        <p>
                                        <div class="custom-file overflow-hidden rounded-pill mb-5">
                                            <label for="fmPicupload" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse for images ...
                                                <input class="show-for-sr" type="file" id="fmPicupload" name="fmPicupload[]" accept=".jpg, .png, .jpeg, .webp" multiple />
                                            </label>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                                <h6 class="text-center mb-4 text-muted" style="font-size: 10px;">
                                    You have to upload images in the format .png, .jpg, .jpeg or .webp. Max. 10 images
                                </h6>
                                <button id="submitPictures" class="btn btn-success btn-block rounded">Save & Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pt-3 pb-3">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="card-deck quote-imgs-thumbs quote-imgs-thumbs--hidden p-3 bg-white shadow rounded-lg" id="img_preview" aria-live="polite">
                            <div class="card-img-top shadow"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="pills-form" role="tabpanel" aria-labelledby="pills-form-tab">
            <section>
                <div class="container p-5">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">

                            <div class="p-5 bg-white shadow rounded-lg">

                                <form action="upload_file.php" id="form-upload" class="was-validated" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" minlength="10" maxlength="75" value="" placeholder="Enter your mod title.." required>
                                        <small id="title" class="form-text text-muted">The title has to be at least 10 and max. 75 characters long.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description <span class="text text-danger">*</span></label>
                                        <textarea class="form-control" id="description" name="description" value="" placeholder="Enter an exciting description.." rows="5" minlength="150" required></textarea>
                                        <small id="title" class="form-text text-muted">The description has to be at least 150 characters long.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Select a category <span class="text text-danger">*</span></label>
                                        <select class="form-control custom-select" id="category" name="category" required>
                                            <option value="" disabled selected>Choose category..</option>
                                            <option value="Scripts">Scripts</option>
                                            <option value="Vehicles">Vehicles</option>
                                            <option value="Weapons">Weapons</option>
                                            <option value="Peds">Peds</option>
                                            <option value="Maps">Maps</option>
                                            <option value="Liveries">Liveries</option>
                                            <option value="Misc">Misc</option>
                                        </select>
                                        <small id="title" class="form-text text-muted">You have to select a category.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Set some tags <span class="text text-danger">*</span></label>
                                        <select id="choices-multiple-remove-button" placeholder="Select up to 20 tags" multiple>
                                            <?php
                                            require_once('config.php');
                                            $pdo = new PDO('mysql:dbname=' . $mysql['dbname'] . ';host=' . $mysql['servername'] . '', '' . $mysql['username'] . '', '' . $mysql['password'] . '');
                                            $selVals = $pdo->prepare("SELECT * FROM tags");
                                            $selVals->execute();
                                            $vals = $selVals->fetchAll();

                                            foreach ($vals as $value) {
                                                echo '<option value="' . $value['tag'] . '">' . $value['tag'] . '</option>';
                                            }


                                            ?>
                                        </select>
                                        <small id="title" class="form-text text-muted">You have to set at least one tag.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Required resource</label>
                                        <input type="text" class="form-control" id="required" name="required" minlength="10" maxlength="75" value="" placeholder="Enter an additional URL..">
                                        <small id="title" class="form-text text-muted">Not required</small>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button id="submitBtn" class="btn btn-primary" style="padding:10px 20px 10px;border-radius:7px;font-size: 16px;">Upload <i class="fas fa-upload pl-1"></i></button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pt-3 pb-3">
                <div class="container">
                    <div class="row row-grid">
                        <div class="col-xs-6 col-md-3 my-1 quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="pills-done" role="tabpanel" aria-labelledby="pills-done-tab">
            <section>
                <div class="container p-5">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">

                            <div class="p-5 bg-white shadow rounded-lg">
                                <svg width="100" viewBox="0 0 4353 4732" fill="none" xmlns="http://www.w3.org/2000/svg" loading="lazy" alt="FiveMods upload brand" class="d-block mx-auto mb-4 rounded-pill">
                                    <g id="check file">
                                        <g id="file">
                                            <path id="Vector" d="M377.516 16.6526C236.713 59.5057 112.234 165.618 38.7719 304.381C2.04063 371.721 0 463.55 0 2365.41C0 4267.27 2.04063 4359.1 38.7719 4426.44C91.8281 4526.43 189.778 4626.42 285.688 4677.44C365.272 4722.33 385.678 4722.33 1442.72 4728.46C2501.81 4734.58 2520.17 4732.54 2560.98 4691.72C2612 4640.71 2614.04 4581.53 2560.98 4528.47C2522.21 4489.7 2493.64 4487.66 1485.58 4487.66C487.709 4487.66 446.897 4485.62 381.597 4446.85C344.866 4424.4 297.931 4377.47 275.484 4340.74C234.672 4275.44 234.672 4232.58 234.672 2365.41C234.672 498.24 234.672 455.387 275.484 390.087C297.931 353.356 344.866 306.421 381.597 283.974C446.897 245.203 487.709 243.162 1522.31 243.162H2597.72L2605.88 461.509C2614.04 702.303 2638.53 771.684 2752.8 892.081C2877.28 1026.76 2946.66 1047.17 3279.28 1055.33C3560.89 1063.49 3579.26 1061.45 3620.07 1020.64C3646.6 994.112 3662.92 951.259 3662.92 910.447C3662.92 802.293 3603.74 590.068 3546.61 481.915C3475.18 353.356 3307.85 186.024 3179.29 114.603C2971.15 2.36823 2924.22 -1.71302 1622.3 0.327607C965.216 0.327607 406.084 8.49011 377.516 16.6526ZM3003.8 304.381C3126.24 359.478 3285.41 514.565 3346.63 637.003C3430.29 806.375 3426.21 814.537 3230.31 814.537C2942.58 814.537 2846.67 718.628 2846.67 430.899C2846.67 239.081 2852.79 234.999 3003.8 304.381Z" fill="url(#paint0_linear)" />
                                            <path id="Vector_2" d="M3458.86 1426.74C3420.09 1465.51 3418.05 1494.08 3418.05 2038.93C3418.05 2583.77 3420.09 2612.34 3458.86 2651.11C3481.31 2673.56 3518.04 2691.93 3540.48 2691.93C3562.93 2691.93 3599.66 2673.56 3622.11 2651.11C3660.88 2612.34 3662.92 2583.77 3662.92 2038.93C3662.92 1494.08 3660.88 1465.51 3622.11 1426.74C3599.66 1404.29 3562.93 1385.93 3540.48 1385.93C3518.04 1385.93 3481.31 1404.29 3458.86 1426.74Z" fill="url(#paint1_linear)" />
                                        </g>
                                        <g id="Green Checkmark">
                                            <circle id="circle" cx="3541.86" cy="3919.93" r="810.5" fill="url(#paint2_linear)" />
                                            <g id="Checkmarks">
                                                <rect id="extra-box" x="3454" y="4166.82" width="113.472" height="113.472" transform="rotate(45 3454 4166.82)" fill="white" />
                                                <rect id="check-short" x="3007" y="4040.74" width="226.939" height="518.717" rx="113.469" transform="rotate(-45 3007 4040.74)" fill="white" />
                                                <rect id="check-long" x="3901.05" y="3559.31" width="226.939" height="972.594" rx="113.469" transform="rotate(45 3901.05 3559.31)" fill="white" />
                                            </g>
                                        </g>
                                    </g>
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="1831.46" y1="4731.04" x2="1831.46" y2="-0.000976562" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#E94057" />
                                            <stop offset="1" stop-color="#F27121" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="3540.48" y1="2691.93" x2="3540.48" y2="1385.93" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#E94057" />
                                            <stop offset="1" stop-color="#F27121" />
                                        </linearGradient>
                                        <linearGradient id="paint2_linear" x1="3541.86" y1="3109.43" x2="3541.86" y2="4730.43" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#57C84D" />
                                            <stop offset="1" stop-color="#2EB62C" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <h6 class="text-center mb-4 pt-4 text-muted">
                                    <!-- vlt randomizer mit kleinen sprüchen rein machen idk wäre nice ig -->
                                    You uploaded your mod. <br> We will review and hopefully approve it in the next few days.
                                </h6>

                                <div class="grid-x grid-padding-x">
                                    <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
                                        <p>
                                        </p>
                                        <!--<div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>-->
                                    </div>
                                </div>
                                <h6 class="text-center mb-4 pt-3 text-muted" style="font-size: 10px;">
                                    With uploading an resource you agree to our <a href="/upload-policy/">Upload policy</a>.
                                    Failures can result in withdrawal of monitarization, a removal of the specific mod or your account.
                                </h6>
                                <div class="d-flex justify-content-center">
                                    <a href="/" class="text-center text-muted" style="font-size: 10px;">
                                        <u>Go back to FiveMods.net</u>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pt-3 pb-3">
                <div class="container">
                    <div class="row row-grid">
                        <div class="col-xs-6 col-md-3 my-1 quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>
                    </div>
                </div>
            </section>
        </div>

    </div>
</section>
<script>
    $(document).ready(function() {

        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount: 20,
            searchResultLimit: 100,
            renderChoiceLimit: 100
        });


    });
</script>

<script src="/static-assets/js/upload.js?v=<?php echo time(); ?>"></script>
