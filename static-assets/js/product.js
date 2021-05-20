$('#submitRate').on("click", function() {
    var star1 = document.getElementById("star1").checked;
    var star2 = document.getElementById("star2").checked;
    var star3 = document.getElementById("star3").checked;
    var star4 = document.getElementById("star4").checked;
    var star5 = document.getElementById("star5").checked;

    if (star1 === true) {
       var rating = 1
    } else if (star2 === true) {
       var rating = 2
    } else if (star3 === true) {
       var rating = 3
    } else if (star4 === true) {
       var rating = 4
    } else if (star5 === true) {
       var rating = 5
    }

    const formData = new FormData();
    formData.append('rate', rating);
    formData.append('mid', nameID);

    $.ajax({
       type: 'POST',
          url: '/helper/mod.rate.php',
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
                      errtext = "You cant rate a mod with 0 stars!"
                      break;
                   case "NOT_LOGGED_IN":
                      err = 1
                      errtext = "Your are not logged in (how can you even use this feature?)"
                      break;
                   case "ERR_ALREADY_RATED":
                      err = 1
                      errtext = "You already rated this mod!"
                      break;
                   case "SUCCESS":
                      err = 0
                      errtext = "SUCCESS"
                      break;
                   default:
                      err = 1
                      errtext = "Unknown error"
                      break;
             }
             
             if(err == 1) {
                $('#fm-container').prepend("  <div class=\"alert alert-danger\">" +
                                                 "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                                 "<strong>Error!</strong> " + errtext +
                                              "</div>");
             } else {
                $('#fm-container').prepend("  <div class=\"alert alert-success\">" +
                                                 "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>" +
                                                 "<strong>Success! </strong> You've rated this mod with " + rating + " stars! (You may have to reload the page to see the new rating)" +
                                              "</div>");
             }

          }
    });

 });