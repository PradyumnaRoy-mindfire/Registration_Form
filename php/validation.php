<?php 
        // for checking in the required fields are left empty
    $isEmpty = false;

    $fname = isset($_POST['fname']) ? $_POST['fname'] : " ";
    $pass = isset($_POST['pass']) ? $_POST['pass'] : " " ;
    $phno = isset($_POST['phno']) ? $_POST['phno']:" " ;
    $email = isset($_POST['email']) ? $_POST['email']:" " ;
    $pin = isset($_POST['pin']) ? $_POST['pin']:" ";
    $terms = isset($_POST['terms']) ? true : false;

    $fnameErr = "";
    $lnameErr = "";
    $passErr = "";
    $phnoErr = "";
    $emailErr = "";
    $pinErr = "";
    $termsErr = "";

    if(empty($fname)){
        $fnameErr = "This field is required...";
        $isEmpty = true;
    }
    if(empty($pass)) {
        $passErr = "This field is required...";
        $isEmpty = true;
    }
    if(empty($phno)) {
        $phnoErr = "This field is required...";
        $isEmpty = true;
    }
    if(empty($email)) {
        $emailErr = "This field is required...";
        $isEmpty = true;
    }
    if(empty($pin)) {
        $pinErr = "This field is required...";
        $isEmpty = true;
    }
    if(empty($terms)) {
        $termsErr = "This field is required...";
        $isEmpty = true;
    }
   
        //checking email is unique or not
    
    $isUniqueUser = true;
    $jsonFile = $_SERVER['DOCUMENT_ROOT'] . '/data.json';

    if (file_exists($jsonFile) && file_get_contents($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
    } else {
        $data = [];
    
        file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    for($i = 1;$i <= sizeof($data);$i++) {
        if($email == $data[$i]['email']) {
            $isUniqueUser = false;
            $emailErr = "**This email is already registered..";
            break;
        }
    }

?>



