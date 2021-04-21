const id = randomChars(15);

var uploadMod = null;

$("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

$("html").on("dragover", function(e) {
    e.preventDefault();
    e.stopPropagation();
});

$('html').on('drop', function (e) {
    e.stopPropagation();
    e.preventDefault();

    var file = e.originalEvent.dataTransfer.files;

    $('#uploadPreview').html("<i class=\"far fa-file-archive pr-2\"></i> " + file[0]['name']);
    uploadMod = file[0];
});


$('#fmUpload').on("change", function() {
    $('#uploadPreview').html("<i class=\"far fa-file-archive pr-2\"></i> " + event.target.files[0]['name']);
});

const modExtensions = ["zip", "7z", "rar", "tar", "tar.gz", "ZIP", "7Z", "RAR", "TAR", "TAR.GZ"];
var stop = false;
$('#submitUpload').on("click", function(evt) {
    evt.preventDefault();
    stop = false;
    $('#submitUpload').prop('disabled', true)
    $('#fmUpload').prop('disabled', true)

    const files = document.querySelector('#fmUpload[type=file]').files;
    const formData = new FormData();
    
    if(uploadMod != null) {
        file = uploadMod;
    } else {
        file = files[0]
    }

    if(file != null) {
        
        if(file['size'] > 100000000) {
            $('#status-bar').html("<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                    "<strong>Error! </strong> Your file is too powerful (100MB upload limit reached)!</div>");
            $('#submitUpload').prop('disabled', false)
            $('#fmUpload').prop('disabled', false)
            stop = true;
        } else if(modExtensions.indexOf(file['name'].split(".")[file['name'].split(".").length - 1]) == -1) {
            $('#status-bar').html("<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                    "<strong>Error! </strong> Stop trying to break things!</div>");
            $('#submitUpload').prop('disabled', false)
            $('#fmUpload').prop('disabled', false)
            stop = true;

        }

        formData.append('files[]', file)
        formData.append('id', id)
        
        if(!stop) {
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(e) {
                        if (e.lengthComputable) {
                            var percentComplete = ((e.loaded / e.total) * 100);
                            $(".pg-mods").width(Math.ceil(percentComplete) + '%');
                            $(".pg-mods").html(Math.ceil(percentComplete) + '%');
                        }
                    }, false)
                    return xhr;
                },
                type: 'POST',
                url: '/helper/mod.modupload.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $(".pg-mods").width('0%');
                },
                error: function() {
                    console.log("error");
                },
                success: function(res) {
                    if(res == "ERR_EXT") {
                        err = 1;
                        errtext = "Stop trying to break things.";
                    } else if(res == "ERR_BIG") {
                        err = 1;
                        errtext = "Your file is too powerful (100MB upload limit reached)";
                    } else if(res == "NOT_LOGGED_IN") {
                        err = 1;
                        errtext = "Your are not logged in";
                        window.location.replace("https://fivemods.net/logout?url=invalid");
                    } else if(res == "ERR_NO_ID") {
                        err = 1;
                        errtext = "We are missing some backend information, please relog the page and do the upload procedure again.";
                    } else {
                        err = 0;
                    }
                    if(err == 1) {
                        $('#status-bar').html("  <div class=\"alert alert-danger\">" +
                                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                        "<strong>Error! </strong>" + errtext +
                                    "</div>");
                        $('#submitUpload').prop('disabled', false)
                        $('#fmUpload').prop('disabled', false)
                    } else if (res == "SUCCESS"){
                        setTimeout(() => {
                            $('#status-bar').html(" ");
                            $('#pills-home').hide("slow")
                            $('#pills-modupload').tab("show")
                        }, 1000);
                    } else {
                        alert("Something went wrong. If this message keeps occuring, please message our support team.")
                        $('#submitUpload').prop('disabled', false)
                        $('#fmUpload').prop('disabled', false)
                    }
                }
            });
        }
    } else {
        $('#status-bar').html("  <div class=\"alert alert-danger\">" +
                                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                    "<strong>Error! </strong> You didn't upload a file!" +
                                "</div>");
        $('#submitUpload').prop('disabled', false)
        $('#fmUpload').prop('disabled', false)
    }
    
});

picExtensions = ["png", "jpg", "webp", "jpeg", "PNG", "JPG", "WEBP", "JPEG"];

$('#submitPictures').on("click", function(evt) {
    evt.preventDefault();
    stop = false;
    $('#submitPictures').prop('disabled', true)
    $('#fmPicupload').prop('disabled', true)

    const files = document.querySelector('#fmPicupload[type=file]').files;
    const formData = new FormData();

    if(files.length > 0) {
        
        for (let i = 0; i < files.length; i++) {
            let file = files[i];

            if(files.length > 10) {
                $('#status-bar').html("<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                        "<strong>Error! </strong> You uploaded more than 10 pictures!</div>");
                $('#submitPictures').prop('disabled', false)
                $('#fmPicupload').prop('disabled', false)
                stop = true;
            } else if(file['size'] > 100000000) {
                $('#status-bar').html("<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                        "<strong>Error! </strong> Your file is too powerful (100MB upload limit reached)!</div>");
                $('#submitPictures').prop('disabled', false)
                $('#fmPicupload').prop('disabled', false)
                stop = true;
            } else if(picExtensions.indexOf(file['name'].split(".")[file['name'].split(".").length - 1]) == -1) {
                console.log("Name: " + file['name'] + ", Ending: " + file['name'].split(".")[file['name'].split(".").length - 1])
                $('#status-bar').html("<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                        "<strong>Error! </strong> One of your attached files has an unvalid file ending!</div>");
                $('#submitPictures').prop('disabled', false)
                $('#fmPicupload').prop('disabled', false)
                stop = true;

            }

            formData.append('files[]', file)
        }
        formData.append('id', id)
        if(!stop) {
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(e) {
                        if (e.lengthComputable) {
                            var percentComplete = ((e.loaded / e.total) * 100);
                            $(".pg-pics").width(Math.ceil(percentComplete) + '%');
                            $(".pg-pics").html(Math.ceil(percentComplete) + '%');
                        }
                    }, false)
                    return xhr;
                },
                type: 'POST',
                url: '/helper/mod.picupload.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $(".pg-pics").width('0%');
                },
                error: function() {
                    console.log("error");
                },
                success: function(res) {
                    if(res == "ERR_EXT") {
                        err = 1;
                        errtext = "Stop trying to break things.";
                    } else if(res == "ERR_BIG") {
                        err = 1;
                        errtext = "Your file is too powerful (100MB upload limit reached)";
                    } else if(res == "NOT_LOGGED_IN") {
                        err = 1;
                        errtext = "Your are not logged in";
                        window.location.replace("https://fivemods.net/logout?url=invalid");
                    } else if(res == "ERR_TOO_MANY") {
                        err = 1;
                        errtext = "The upload limit is 10 pictures.";
                    } else if(res == "ERR_NO_ID") {
                        err = 1;
                        errtext = "We are missing some backend information, please relog the page and do the upload procedure again.";
                    } else {
                        err = 0;
                    }
                    if(err == 1) {
                        $('#status-bar').html("  <div class=\"alert alert-danger\">" +
                                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                        "<strong>Error! </strong>" + errtext +
                                    "</div>");
                        $('#submitPictures').prop('disabled', false)
                        $('#fmPicupload').prop('disabled', false)
                    } else if (res == "SUCCESS"){
                        setTimeout(() => {
                            $('#status-bar').html(" ");
                            $('#pills-modupload').hide("slow")
                            $('#pills-form').tab("show")
                        }, 1000);
                    } else {
                        alert("Something went wrong. If this message keeps occuring, please message our support team.")
                        $('#submitPictures').prop('disabled', false)
                        $('#fmPicupload').prop('disabled', false)
                    }
                    
                }
            });
        }
    } else {
        $('#status-bar').html("  <div class=\"alert alert-danger\">" +
                                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                    "<strong>Error! </strong> You have to upload at least <b>1</b> picture!" +
                                "</div>");
        $('#submitPictures').prop('disabled', false)
        $('#fmPicupload').prop('disabled', false)
    }
});

$('#form-upload').on("submit", function(evt) {

    evt.preventDefault();
    $('#submitBtn').prop('disabled', true)

    const formData = new FormData();
    var title = $('#title').val();
    var description = $('#description').val();
    var category = $('#category').val();
    var tags = $('#choices-multiple-remove-button').val();
    var required = $('#required').val();
    
    formData.append('id', id)
    formData.append('title', title)
    formData.append('description', description)
    formData.append('category', category)
    formData.append('tags', tags)
    formData.append('required', required)

    $.ajax({
        type: 'POST',
        url: '/helper/mod.upload.php',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        error: function() {
            console.log("error");
        },
        success: function(res) {
            console.log(res);
            if(res == "NOT_LOGGED_IN") {
                err = 1;
                errtext = "Your are not logged in";
                window.location.replace("https://fivemods.net/logout?url=invalid");
            } else if(res == "ERR_EMPTY") {
                err = 1;
                errtext = "Something went wrong, please try it again!";
            }
            if(err == 1) {
                $('#status-bar').html("  <div class=\"alert alert-danger\">" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                "<strong>Error! </strong>" + errtext +
                            "</div>");
                $('#submitBtn').prop('disabled', false)
            } else if (res == "SUCCESS"){
                setTimeout(() => {
                    $('#status-bar').html(" ");
                    $('#pills-form').hide("slow")
                    $('#pills-done').tab("show")
                }, 1000);
            } else {
                alert("Something went wrong. If this message keeps occuring, please message our support team.")
                $('#submitBtn').prop('disabled', false)
            }
        }
    });
            
})


var imgUpload = document.getElementById('fmPicupload'),
    imgPreview = document.getElementById('img_preview'),
    totalFiles, previewTitle, previewTitleText, img;

imgUpload.addEventListener('change', previewImgs, false);

function previewImgs(event) {
    $('#img_preview').html(" ");
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

function randomChars(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}