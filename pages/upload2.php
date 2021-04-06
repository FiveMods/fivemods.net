<?php
session_start();
include('./include/header-banner.php');
?>
<link href="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.css" rel="stylesheet">
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
</style>
<div class="progress">
    <div class="progress-bar bg-success" role="progressbar" style="width: 25%;height:35%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<section class="pt-5 pb-5">
    <?php

            if (empty($_GET['w'])) {
                echo '<section>
                <div class="container p-5">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">

                            <div class="p-5 bg-white shadow rounded-lg"><img src="/static-assets/img/svg/upload_brand.svg" loading="lazy" alt="FiveMods upload brand" width="200" class="d-block mx-auto mb-4 rounded-pill">

                                <h6 class="text-center mb-4 text-muted">
                                    Upload your resource here
                                </h6>

                                <div class="custom-file overflow-hidden rounded-pill mb-5">
                                    <label for="fileUpload" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse for file ...
                                        <input id="fileUpload" type="file">
                                    </label>
                                </div>
                                <!-- End -->

                                <div class="text-center mb-4 text-muted border p-2">
                                <i class="far fa-file-archive pr-2"></i> my_uploaded_mod.zip
                                </div>
                                <h6 class="text-center mb-4 text-muted" style="font-size: 10px;">
                                    You have to upload a .zip, .7z, .rar, .tar or .tar.gz file.
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';
            } elseif ($_GET['w'] == 1) {
                # code...
            }

            ?>
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="card p-3">
                    <div id="fmUpload"></div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js"></script>
    <script>
        var uppy = Uppy.Core()
            .use(Uppy.Dashboard, {
                inline: true,
                target: '#fmUpload',
                height: 270
            })
            .use(Uppy.Tus, {
                endpoint: 'https://storage.fivemods.net/upload/img/ext/?id=?'
            }) //you can put upload URL here, where you want to upload images

        uppy.on('complete', (result) => {
            console.log('Upload complete! We’ve uploaded these files:', result.successful)
        })
    </script> -->
</section>