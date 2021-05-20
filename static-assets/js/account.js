$('#noSpace').on("keyup", function(e) {
    e.target.value = e.target.value.replace(' ', '_');
    e.target.value = e.target.value.replace('™', 'TM');
    e.target.value = e.target.value.replace('®', 'R');
});

$('#newUsername').on("click", function() {
    const validate = validateUsername($('#username').val());
    if(validate == "") 
    {	

        const formData = new FormData();
        formData.append('username', $('#username').val());

        $.ajax({
            type: 'POST',
            url: '/pages/account/helper/account.edit.php',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            error: function() {
                console.log("error");
            },
            success: function(res) {

                switch (res) {
                    case "ERR_EMPTY":
                        err = 1
                        errText = "You can't have an empty Username!"
                        break;
                    case "ERR_REGEX":
                        err = 1
                        errText = "Your username should only contain underscores, letters and numbers"
                        break;
                    case "ERR_LEN":
                        err = 1
                        errText = "Your username has to be 3-35 characters long"
                        break;
                    case "SUCCESS":
                        err = 0
                        break;
                    case "NOT_LOGGED_IN":
                        err = 1;
                        errtext = "Your are not logged in";
                        window.location.replace("https://fivemods.net/logout?url=invalid");
                        break;
                    case "ERR_ALREADY_EXISTING":
                        err = 1;
                        errtext = "This username is already taken"
                        break;
                    default:
                        err = 1
                        errText = "Unknown error"
                        break;
                }

                if(err == 1) {
                    $('#alert-box').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><strong>Error! </strong> Something went wrong: ' + errText + '</div>')
                } else if(err == 0) {
                    $('#alert-box').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button><strong>Successfully changed! </strong> Your username got updated</div>')
                }
                

            }
        });
    } 
    else 
    {
        $('#alert-box').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">x</button><strong>Error! </strong> Something went wrong: ' + validate + '</div>')
    }
});

function validateUsername(str) {
    
    var error = "";
    var illegalChars = /\W/;

    if (str == "") {
        error = "You have to insert a username in order to change it.";
    } else if ((str.length <= 3) || (str.length >= 35)) {
        error = "Your username has to be 3-35 characters long";
    } else if (illegalChars.test(str)) {
    error = "Please only use underscores, numbers and letters for your username";
    } else {
        error = "";
    }
    return error;
}