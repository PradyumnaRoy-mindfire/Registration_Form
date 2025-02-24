var pageModule = (function($){
        //to show the recommandation span of format for input 
    function recomandation(){
        $("#fname-warn").on('focus',function(){
            $("#fname-recom").fadeIn();
            $("#fname-warn").on('blur',function(){
                $("#fname-recom").fadeOut();
            });
        });
        $("#lname-warn").on('focus',function(){
            $("#lname-recom").fadeIn();
            $("#lname-warn").on('blur',function(){
                $("#lname-recom").fadeOut();
            });
        });
        $("#phno-warn").on('focus',function(){
            $("#phno-recom").fadeIn();
            $("#phno-warn").on('blur',function(){
                $("#phno-recom").fadeOut();
            });
        });
        $("#email-warn").on('focus',function(){
            $("#email-recom").fadeIn();
            $("#email-warn").on('blur',function(){
                $("#email-recom").fadeOut();
            });
        });
        $("#pin-warn").on('focus',function(){
            $("#pin-recom").fadeIn();
            $("#pin-warn").on('blur',function() {
                $("#pin-recom").fadeOut();
            })
        });
        $("#pass").on('focus',function(){
            $("#pass-recom").fadeIn();
            $("#pass").on('blur',function() {
                $("#pass-recom").fadeOut();
            })
        });

    }
        //for hiding the error span along with putting input
    function hideError() {
        $("#fname").on('input',function() {
            $("#fname").removeClass('errorEffect');
            $("#fname-err").text("");
        });
       
        $("#lname").on('input',function() {
            $("#lname").removeClass('errorEffect');
            $("#lname-err").text("");
        });

        $("#pass").on('input',function() {
            $("#pass").removeClass('errorEffect');
            $("#pass-err").text("");
        });
        
        $("#phno").on('input',function() {
            $("#phno").removeClass('errorEffect');
            $("#phno-err").text("");
        });
        
        $("#email").on('input',function() {
            $("#email").removeClass('errorEffect');
            $("#email-err").text("");
        });
        
        $("#gender").on('input',function() {
            $("#gender").removeClass('errorEffect');
            $("#gender-err").text("");
        });
        
        $("#pin").on('input',function() {
            $("#pin").removeClass('errorEffect');
            $("#pin-err").text("");
        });
       
        $("#terms").on('input',function() {
            $("#terms").removeClass('errorEffect');
            $("#terms-err").text("");
        });

            //for updatation in profile page
        $(".profileInput").on('input',function() {
            $(".profileInput").removeClass('errorEffect');
            $("#pfname-err").text("");
        });
        $("#phnoProfile").on('input',function() {
            $("#phnoProfile").removeClass('errorEffect');
            $("#pfphno-err").text("");
        });
        $("#emailProfile").on('input',function() {
            $("#emailProfile").removeClass('errorEffect');
            $("#pfemail-err").text("");
        });

           //for favInput
        $("#favouriteName").on('input',function() {
            $("#favouriteName").removeClass('errorEffect');
            $("#favNameErr").text("");
        });

        $("#favouriteItem").on('input',function() {
            $("#favouriteItem").removeClass('errorEffect');
            $("#favItemErr").text("");
        });
       
    }
    //         //Show Password
    function showHiddenPassword() {
            // For registration form
        $('.eye').click(function() {
            $("#pass").addClass("fullWidth");
            if ($('#pass').attr('type') === "password") {
                $('#pass').attr('type','text');
            } else {
                $('#pass').attr('type','password');;
            }
            //for login form
            $("#loginPass").addClass("fullWidth");
            if ($('#loginPass').attr('type') === "password") {
                $('#loginPass').attr('type','text');
            } else {
                $('#loginPass').attr('type','password');;
            }

        });
    }
        
 

       //for updation of profile
    function updateButtontoggle() {
        $(".profileInput").on('click',function(){
            $('.update').show();
        })

        $("#update").on('click',function(){
            setTimeout(function(){
                $('.update').hide();
            },500);
        })
    }
        //to remove submit and login popup
    function removePopup() {
        setTimeout(function(){
            $('.submitPopup').fadeOut();
        },500);
        setTimeout(function(){
            $('.loginPopup').fadeOut();
        },500);
    }
    
    function displayLogoutPopup() {
        $(".container").addClass("doBlur");
        $('.logoutPopup').show();
    }

    
    
    function init() {
        removePopup();
        hideError();
        showHiddenPassword();
        recomandation();
        updateButtontoggle();
    }
    return {
        init:init,
        displayLogoutPopup:displayLogoutPopup,
    }
})(jQuery)