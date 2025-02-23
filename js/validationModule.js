var validationModule = (function () {
    let isValid = true; 
    function validation() {
        let fnameErr = $('#fname-err');
        let lnameErr = $('#lname-err');
        let passErr = $('#pass-err');
        let phnoErr = $('#phno-err');
        let emailErr = $('#email-err');
        let genderErr = $('#gender-err');
        let pinErr = $('#pin-err');
        let termsErr = $('#terms-err');

        fnameErr.text("");
        lnameErr.text("");
        passErr.text("");
        phnoErr.text("");
        emailErr.text("");
        genderErr.text("");
        pinErr.text("");
        termsErr.text("");

        // Firstname validation
        let enteredFname = $("#fname").val();
        if (enteredFname === "") {
            fnameErr.text("**This field is required...");
            $("#fname").addClass('errorEffect');
            isValid = false;
        } else if (/\d/.test(enteredFname)) {
            fnameErr.text("**First name should not contain any digit...");
            $("#fname").addClass('errorEffect');
            isValid = false;
        } 

        // Lastname validation
        let enteredLname = $("#lname").val();
        if (/\d/.test(enteredLname)) {
            lnameErr.text("**Last name should not contain any digit...");
            $("#lname").addClass('errorEffect');
            isValid = false;
        } 

        // Email validation
        let emailRegx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/;
        let enteredEmail = $("#email").val();
        if (enteredEmail === "") {
            emailErr.text("**This field is required...");
            $("#email").addClass('errorEffect');
            isValid = false;
        } else if (!emailRegx.test(enteredEmail)) {
            emailErr.text("**Email is not valid...");
            $("#email").addClass('errorEffect');
            isValid = false;
        } 

        // Phone number validation
        let enteredPhno = $("#phno").val();
        if (enteredPhno === "") {
            phnoErr.text("**This field is required...");
            $("#phno").addClass('errorEffect');
            isValid = false;
        } else if (!/^\d{10}$/.test(enteredPhno)) {
            phnoErr.text("**Phone no should be exactly 10 digits...");
            $("#phno").addClass('errorEffect');
            isValid = false;
        } 

            //password validation
        if(passwordValidation("#pass",passErr) == null) {
            isValid =  true
        }
        else {
            isValid = passwordValidation("#pass",passErr);
        }

        // Pincode validation
        let enteredPin = $("#pin").val();
        if (enteredPin === "") {
            pinErr.text("**This field is required...");
            $("#pin").addClass('errorEffect');
            isValid = false;
        } else if (!/^\d{6}$/.test(enteredPin)) {
            pinErr.text("**Pin code should be exactly 6 digits...");
            $("#pin").addClass('errorEffect');
            isValid = false;
        } 
        // Terms & Condition validation
        if (!$("#terms").prop("checked")) {
            termsErr.text("**Accept the terms and conditions...");
            $("#terms").addClass('errorEffect');
            isValid = false;
        } 

        return isValid;
    }
    async function submit() {
        $("#fname, #lname, #email, #phno, #pin").on("keyup", validation);

        $("#terms").on("change", validation);

        $("#submit").on("click", function (e) {
            let formValid = validation(); 

            if (!formValid) {
                e.preventDefault(); 
                window.location.assign('../php/registration.php');
            }
        });

    }
    submit()





    function passwordValidation(passSelecter, passErrSelecter) {
        let isValid = true;
        $(`${passSelecter}`).keyup(function () {
            let enteredInput = $(`${passSelecter}`).val();
            if (enteredInput == "") {
                passErrSelecter.text("**This field is required...");
                $(`${passSelecter}`).addClass('errorEffect');
                isValid = false;
            }
            else if (enteredInput.length > 10) {
                passErrSelecter.text("**Password is too large...");
                $(`${passSelecter}`).addClass('errorEffect');
                isValid = false;
            }
            else if (!enteredInput.match(/\d/)) {
                passErrSelecter.text("**Password has no digit...");
                $(`${passSelecter}`).addClass('errorEffect');
                isValid = false;
            }
            else if (!enteredInput.match(/[a-z]/)) {
                passErrSelecter.text("**Password has no small character...");
                $(`${passSelecter}`).addClass('errorEffect');
                isValid = false;
            }
            else if (!enteredInput.match(/[A-Z]/)) {
                passErrSelecter.text("**Password has no capital character...");
                $(`${passSelecter}`).addClass('errorEffect');
                isValid = false;
            }
            else if (enteredInput.length < 6) {
                passErrSelecter.text("**Password is too small...");
                $(`${passSelecter}`).addClass('errorEffect');
                isValid = false;
            }
            return isValid;

        });
    }

    function init() {
        validation(formData);
    }
    return {
        init: init,
        validation: validation
    }
}(jQuery))