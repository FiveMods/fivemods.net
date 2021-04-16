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
    .choices[data-type*=select-multiple] .choices__button, .choices[data-type*=text] .choices__button {
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
    


</style>

<div class="progress">
    <div class="progress-bar bg-success" role="progressbar" style="width: 0%;height:50%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<section class="pt-5 pb-5">
    <div class="container">
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
    </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <section>
                    <div class="container p-5">
                        <div class="row">
                            <div class="col-lg-5 mx-auto">
                                <!--<div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%;height:35%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>-->

                                <div class="p-5 bg-white shadow rounded-lg"><img src="/static-assets/img/svg/upload/upload.svg" loading="lazy" alt="FiveMods upload brand" width="100px" class="d-block mx-auto mb-4 rounded-pill">

                                    <h6 class="text-center mb-4 text-muted">
                                        Upload your resource here
                                    </h6>

                                    <div class="custom-file overflow-hidden rounded-pill mb-5">
                                        <label for="fmUpload" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse for file ...
                                            <input id="fmUpload" type="file" name="files[]" accept=".zip, .7z, .rar, .tar, .tar.gz" required>
                                        </label>
                                    </div>
                                    <!-- End -->

                                    <div class="text-center mb-4 text-muted border p-2" id="uploadPreview">
                                    
                                    </div>
                                    <h6 class="text-center mb-4 text-muted" style="font-size: 10px;">
                                        You have to upload a .zip, .7z, .rar, .tar or .tar.gz file.
                                    </h6>
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

                                <div class="p-5 bg-white shadow rounded-lg"><img src="/static-assets/img/svg/upload/gallery.svg" loading="lazy" alt="FiveMods upload brand" width="100px" class="d-block mx-auto mb-4 rounded-pill">

                                    <h6 class="text-center mb-4 text-muted">
                                        Upload your images here
                                    </h6>

                                    <div class="grid-x grid-padding-x">
                                        <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
                                            <p>
                                                <div class="custom-file overflow-hidden rounded-pill mb-5">
                                                    <label for="upload_imgs" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse for images ...
                                                        <input class="show-for-sr" type="file" id="upload_imgs" name="upload_imgs[]" accept=".jpg, .png, .jpeg, .webp" multiple />
                                                    </label>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                    <h6 class="text-center mb-4 text-muted" style="font-size: 10px;">
                                        You have to upload images in the format .png, .jpg, .jpeg or .webp. Max. 10 images
                                    </h6>
                                    <div class="d-flex justify-content-center">
                                        <a href="/upload2" class="text-center text-muted" style="font-size: 10px;">
                                            <u>Go back to file upload</u>
                                        </a>
                                    </div>
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

                                <form action="upload_file.php" class="was-validated" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" minlength="10" maxlength="75" value="" placeholder="Enter your mod title.." required>
                                        <small id="title" class="form-text text-muted">The title has to be at least 10 and max. 75 characters long.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Description <span class="text text-danger">*</span></label>
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
                                            <option value="HTML">HTML</option>
                                            <option value="Jquery">Jquery</option>
                                            <option value="CSS">CSS</option>
                                            <option value="Bootstrap 3">Bootstrap 3</option>
                                            <option value="Bootstrap 4">Bootstrap 4</option>
                                            <option value="Java">Java</option>
                                            <option value="Javascript">Javascript</option>
                                            <option value="Angular">Angular</option>
                                            <option value="Python">Python</option>
                                            <option value="Hybris">Hybris</option>
                                            <option value="SQL">SQL</option>
                                            <option value="NOSQL">NOSQL</option>
                                            <option value="NodeJS">NodeJS</option>
                                        </select>
                                        <small id="title" class="form-text text-muted">You have to set at least one tag.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Required resource</label>
                                        <input type="text" class="form-control" id="title" name="title" minlength="10" maxlength="75" value="" placeholder="Enter an additional URL..">
                                        <small id="title" class="form-text text-muted">Not required</small>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button id ="submitBtn" class="btn btn-primary" style="padding:10px 20px 10px;border-radius:7px;font-size: 16px;">Upload <i class="fas fa-upload pl-1"></i></button>
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

                                <div class="p-5 bg-white shadow rounded-lg"><img src="/static-assets/img/svg/upload/upload-check.svg" loading="lazy" alt="FiveMods upload brand" width="100px" class="d-block mx-auto mb-4 rounded-pill">

                                    <h6 class="text-center mb-4 text-muted">
                                    <!-- vlt randomizer mit kleinen sprüchen rein machen idk wäre nice ig -->
                                        Done? That wasn\'t too hard.
                                    </h6>

                                    <div class="grid-x grid-padding-x">
                                        <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
                                                <p>
                                                    <div class="custom-file overflow-hidden rounded-pill mb-5">
                                                        <a href="/account/" for="upload_imgs" class="file-upload btn btn-primary btn-block rounded-pill shadow">Take me back to my profile
                                                        </a>
                                                    </div>
                                                </p>
                                                <!--<div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>-->
                                        </div>
                                    </div>
                                    <h6 class="text-center mb-4 text-muted" style="font-size: 10px;">
                                        With uploading an resource you agree to our <a href="/upload-policy/">Upload policy</a>.
                                        Failures can result in a removal of the specific mod or your account.
                                    </h6>
                                    <div class="d-flex justify-content-center">
                                        <a href="/upload/" class="text-center text-muted" style="font-size: 10px;">
                                            <u>Upload more</u>
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
            searchResultLimit: 20,
            renderChoiceLimit: 20
        });


    });
</script>
<!-- Kp habs ausm internet kopiert müsste man dann anpassen wenn man es auch verwenden möchte. -->
<script>

    $('#fmUpload').on("change", function() {
        $('#uploadPreview').html("<i class=\"far fa-file-archive pr-2\"></i> " + event.target.files[0]['name']);
    });

    $('#submitBtn').on("click", function(evt) {
        
        evt.preventDefault ();/*
        const files = document.querySelector('[type=file]').files;
        const formData = new FormData();
        
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            formData.append('files[]', file)
        }
        
        fetch ("/helper/mod.upload.php", {
            method: "POST",
            body: formData,
        }).then ((response) => {
            console.log (response);
            if (response.status === 200) {
            }
        });
        

        
        const input = $('#fmUpload');
        const progressBarFill = document.querySelector("#progressBar > .progress-bar-fill");
        //const progressBarText = progressBarFill.querySelector(".progress-bar-text");
        evt.preventDefault();

        const files = document.querySelector('[type=file]').files;
        const formData = new FormData();
        
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            formData.append('files[]', file)
        }

        const xhr = new XMLHttpRequest();

        xhr.open("POST", "/helper/mod.upload.php");
        xhr.upload.addEventListener("progress", e => {
            const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;

            progressBarFill.style.width = percent.toFixed(2) + "%";
            //progressBarText.textContent = percent.toFixed(2) + "%";
        })

        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.send(formData);
        */

        const files = document.querySelector('[type=file]').files;
        const formData = new FormData();
        
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            formData.append('files[]', file)
        }


        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = ((e.loaded / e.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete + '%');
                    }
                }, false)
                return xhr;
            },
            type: 'POST',
            url: '/helper/mod.upload.php',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $(".progress-bar").width('0%');
            },
            error: function() {
                console.log("error");
            },
            success: function(res) {
                if(res == "ok") {
                    console.log("uploaded");
                } else {
                    console.log("failed");
                }
            }
        });
    });


    var imgUpload = document.getElementById('upload_imgs'),
        imgPreview = document.getElementById('img_preview'),
        totalFiles, previewTitle, previewTitleText, img;

    imgUpload.addEventListener('change', previewImgs, false);

    function previewImgs(event) {
        totalFiles = imgUpload.files.length;

        if (!!totalFiles) {
            imgPreview.classList.remove('quote-imgs-thumbs--hidden');
            previewTitle = document.createElement('p');
            previewTitle.style.fontWeight = 'bold';
            previewTitleText = document.createTextNode('');
            previewTitle.appendChild(previewTitleText);
            imgPreview.appendChild(previewTitle);
        }

        for (var i = 0; i < totalFiles; i++) {
            img = document.createElement('img');
            img.src = URL.createObjectURL(event.target.files[i]);
            img.classList.add('img-preview-thumb');
            imgPreview.appendChild(img);
        }
    }
</script>