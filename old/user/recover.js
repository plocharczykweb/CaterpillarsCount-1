$(document).ready(function () {

    //hide the form
    $("#recoveryForm").hide();

    //getting URL encoded params...
    var params = {};

    if (location.search) {
        var parts = location.search.substring(1).split('&');

        for (var i = 0; i < parts.length; i++) {
            var nv = parts[i].split('=');
            if (!nv[0]) continue;
            params[nv[0]] = nv[1] || true;
        }
    }

    // Now you can get the parameters you want like so:
    var userID = params.userID;
    var recoveryToken = params.recoveryToken;

    //POST to get the user's email address and display it
    var inputData = {
            userID: userID
    };

    $.ajax({
       url: "/api/users.php",
       type: "POST",
       dataType: "json",
       data: JSON.stringify(inputData),
       success: function(data, xhr, status){

            //code before the pause
            setTimeout(function(){
            //do what you need here
                $("#account").text(data.email);
                $("#progress").hide();
                $("#recoveryForm").show();
            }, 2000);

       },
       error: function(xhr,status){

            $("#account").text("User not found");
            $("#progress").hide();

       }
    });

    var $submitButton = $("#submit");
    $submitButton.click(function (e) {

        e.preventDefault();
        var pw = $('#new');
        var confirm = $('#confirm');

        $(".error").remove();
        pw.css("border", "none");
        confirm.css("border", "none");

        if (!pw.val() || !confirm.val()) {
            $(".error").remove();
            pw.css("border", "1px solid red");
            confirm.css("border", "1px solid red");
            confirm.after("<p class = 'error'>Please fill in both fields!</p>");
            return;
        }

        if (pw.val() != confirm.val()) {
            $(".error").remove();
            pw.css("border", "1px solid red");
            confirm.css("border", "1px solid red");
            confirm.after("<p class = 'error'>Fields do not match!</p>");
            return;
        }

        //POST to change password
        var inputData = {
            userID: parseInt(userID),
            recoveryToken: recoveryToken,
            password: pw.val()
        };

        $("#progress").show();

        $.ajax({
           url: "/api/users.php",
           type: "POST",
           data: JSON.stringify(inputData),
           success: function(data, xhr, status){


                $("#account").text("Password successfully changed!");
                $("#account").after("<p class = 'error'>Redirecting to login page in 10 seconds...</p>");
                $("#progress").hide();
                $("#recoveryForm").hide();

                setTimeout(function(){
                //do what you need here
                    window.location.replace("/user/login.html");
                }, 10000);


           },
           error: function(xhr,status){
                $("#progress").hide();

                if(xhr.status == 403){
                    $("#account").text("This recovery link is expired or fraudulent. Please request a new one.");
                    $("#account").after("<p class = 'error'>Redirecting to login page in 10 seconds...</p>");
                    $("#recoveryForm").hide();
                    setTimeout(function(){
                    //do what you need here
                        window.location.replace("/user/login.html");
                    }, 10000);
                }
                else{
                    $("#account").text("Error while attempting to change password.");
                }





           }
        });


        $("#progress").hide();



    });




});
