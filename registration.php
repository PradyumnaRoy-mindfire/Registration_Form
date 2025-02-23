<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    
    <?php
        include __DIR__.'/php/exception.php';
        include __DIR__.'/php/database.php';

        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        try {
            //For empty field validations
            include $_SERVER['DOCUMENT_ROOT'].'/php/validation.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $isUniqueUser == true && $isEmpty == false) {
                $fname = $_POST['fname'];
                $lname = $_POST['lname'] ;
                $pass = $_POST['pass'] ;
                $phno = $_POST['phno'] ;
                $email = $_POST['email'] ;
                $gender = isset($_POST['gender']) ? $_POST['gender']:"";
                $adress = $_POST['adress'] ;
                $pin = $_POST['pin'] ;
                $terms = isset($_POST['terms']) ? true : false;
                $photoPath = ""; //For photo
                
                    // checking if the photo is uploaded or not
                if(isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                    $photo = $_FILES['photo'];
                        // Folder where to save
                    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/test/Form/profilePhoto/';
                        //creating unique name for each photo

                    if(!file_exists($uploadDir) || !is_writable($uploadDir)) {
                        throw new Exception("Uploadin g directory is not exist or file is not writable");
                    }


                    $photoName  = uniqid()."_".basename($photo['name']);
                    $photoTmpPath = $photo['tmp_name'];
                    $photoPath = $uploadDir . $photoName;

                    move_uploaded_file($photoTmpPath, $photoPath);
                }
            
                $sqlInsert = "INSERT INTO users (fname, lname, pass, phno, email, gender, pin, photo, terms, adress) VALUES ('$fname','$lname','$pass','$phno','$email','$gender','$pin','$photoPath','$terms','$adress')";

                mysqli_query($conn,$sqlInsert);
                

                    //for registration pop up
                $_SESSION['registration'] = "registered Successfully";
                // location will came back to this page itself ,it prevents from storing data in to json file while reloading
                header("Location: http://".$_SERVER['SERVER_NAME']."/login",true,301);
                exit();
            }
        }
        catch(Exception $e) {
            my_error_log('FATAL', $e->getMessage(),$e->getFile(),$e->getLine());
        }
    ?>


     

</head>

<body>
    <div class="container">

        <div class="container1">
            <h2>Registration Form</h2>
            <div class="form-container">

                    <!-- entype is encryption type used for security purpose -->
                <form  id="form" action="/registration.php" method="POST" enctype="multipart/form-data">  
                    <div class="input-name">
                        <label for="fname" class="redStar">First Name</label>

                        <div class="wrapper ">
                            <input type="text" name="fname" placeholder="Enter Firstname" class="inp-typ1 fullWidth" id="fname" >
                            <i class="fa-solid fa-circle-info warning" style="color: #FFD43B;" tabindex="0" id="fname-warn" ></i>
                        </div>

                        <span class="recomandation" id="fname-recom">Firstname doesn't contain any symbol or digit...</span>

                        <span id="fname-err" class="err-msg"> <?php if(isset($fname)) echo $fnameErr?> </span>

                    </div>

                    <div class="input-name">
                        <label for="lname">Last Name</label>
                        <div class="wrapper">
                            <input type="text" name="lname" placeholder="Enter Lastname" class="inp-typ1 fullWidth common" id="lname">
                            <i class="fa-solid fa-circle-info warning" style="color: #FFD43B;" tabindex="0" id="lname-warn"></i>
                        </div>

                        <span id="lname-err" class="err-msg"> <?php if(isset($lname)) echo $lnameErr?> </span>

                        <span class="recomandation" id="lname-recom">Lastname doesn't contain any symbol or digit...</span>
                    </div>

                    <div class="input-name">
                        <label for="password" class="redStar">Password</label>

                        <div class="wrapper">
                            <input type="password" name="pass" placeholder="Password" class="inp-typ1 redStar" id="pass">
                              <i class="fas fa-eye password-toggle-icon eye"></i>
                        </div>

                        <span class="recomandation" id="pass-recom">Password contains <b>atleast 6 and atmost 10 character</b> including <b>a symbol,a digit,capital and small character</b>...</span>


                        <span id="pass-err" class="err-msg"> <?php if(isset($pass)) echo $passErr?> </span>

                    </div>

                    <div class="input-name" id="phoneDiv">
                        <label for="phno" class="redStar">Phone Number</label>

                        <select id="countryCode" class="country-code">
                            <option value="+1">+1 (US)</option>
                            <option value="+91">+91 (India)</option>
                            <option value="+44">+44 (UK)</option>
                            <option value="+61">+61 (Australia)</option>
                            
                        </select>
                        <div class="wrapper">
                            <input type="number" name="phno" placeholder="eg:123456" class="inp-typ1 fullWidth" id="phno">
                            <i class="fa-solid fa-circle-info warning" style="color: #FFD43B;" tabindex="0" id="phno-warn"></i>
                        </div>

                        <span id="phno-err" class="err-msg"> <?php if(isset($phno)) echo $phnoErr?> </span>

                        <span class="recomandation" id="phno-recom">Phone no. contains only <b>10 digits...</b></span>
                    </div>

                    <div class="input-name">
                        <label for="email" class="redStar">Email</label>

                        <div class="wrapper">
                            <input type="email" name="email" placeholder="eg:example@email.com " class="inp-typ1 redStar fullWidth" id="email" >
                            <i class="fa-solid fa-circle-info warning" style="color: #FFD43B;" tabindex="0" id="email-warn"></i>
                        </div>

                        <span id="email-err" class="err-msg"><?php if(isset($email)) echo $emailErr?></span>

                        <span class="recomandation" id="email-recom">Input should be in email format...</span>

                    </div>

                    <div id="gender">
                        <label for="gender">Gender</label>

                        <input type="radio" name="gender" value="Male"  id="male">Male
                        <input type="radio" name="gender" value="Female" id="female">Female
                        <input type="radio" name="gender" value="Others" id="others">Others

                        <span id="gender-err" class="err-msg"></span>
                    </div>

                    

                    <div class="input-name">
                        <label for="">Address</label>
                        <input type="text" placeholder="Address" class="inp-addr" id="address" name="adress">
                    </div>

                    <div class="input-name">
                        <label for="" class="redStar">Pincode</label>

                        <div class="wrapper">
                            <input type="text" placeholder="Pincode" class="inp-addr fullWidth" name="pin" id="pin" >
                            <i class="fa-solid fa-circle-info warning" style="color: #FFD43B;" tabindex="0" id="pin-warn"></i>
                        </div>

                        <span id="pin-err" class="err-msg"> <?php if(isset($pin)) echo $pinErr?> </span>

                        <span class="recomandation" id="pin-recom">Pin code has only 5 or 6 digit...</span>
                    </div>

                    <div class="input-name">
                        <label for="photo">Upload Photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*">
                    </div>

                    <div id="check">
                        <input type="checkbox" name="terms" id="terms">

                        <label for="terms">I agree to the <a href="#">Terms & Condition</a></label>

                        <p><span id="terms-err" class="err-msg"></span></p>
                    </div>

                    

                    <div class="input-name">
                        <input type="submit" value="Submit" class="submit" id="submit" name="submit">
                    </div>

                </form>
            </div>

        </div>

        
    </div>
   
    

       <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
       
    <script src="./js/script.js"></script>
    <script src="./js/favouriteModule.js"></script>
    <script src="./js/validationModule.js"></script>
    <script src="./js/pageModule.js"></script>
    
</body>

</html>