<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="./css/login.css">

                <!-- FontAwasome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <?php 
       if(session_status() == PHP_SESSION_NONE){ 
            session_start();
       }
       if(isset($_SESSION['registration']) ) { ?>
        <div class="submitPopup">
            <div class="submitContent">
                <span><i class="fa-regular fa-circle-check fa-beat" style="color: #31ed47;" id="successIcon"></i></span>
                <h4>THANK YOU</h4>
                <p>Your data has been saved successfully...</p>
            </div>
        </div>

    <?php } 
      unset($_SESSION['registration']);   
    ?>
   

    <?php
        include __DIR__.'/php/exception.php';

        try {
            $jsonFile = $_SERVER['DOCUMENT_ROOT'].'/data.json';

            if(!file_exists($jsonFile)) {
                throw new Exception("File not found.....");
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $jsonData = file_get_contents($jsonFile);
                $data = json_decode($jsonData, true);
                
                
                $length = sizeof($data);
                for($i = 1;$i <= $length;$i++) {
                    if($data[$i]['email'] == $email && $data[$i]['pass'] == $pass) {
                        $_SESSION['userId'] = $data[$i]['userId'];
                        $_SESSION['fname'] = $data[$i]['fname'];
                        $_SESSION['lname'] = $data[$i]['lname'];
                        $_SESSION['phno'] = $data[$i]['phno'];
                        $_SESSION['email'] = $data[$i]['email'];
                        $_SESSION['address'] = $data[$i]['address'];
                        $_SESSION['photo'] = $data[$i]['photo'];
                        $_SESSION['totalFavourite'] = count($data[$i]['favourite']);

                        $_SESSION['login'] = "Login successfull";
                        header("Location: http://".$_SERVER['SERVER_NAME']."/ /php/profile",true,302);   //301 for permanent redirection ,302 for temporary
                        exit();
                    }
                }
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
            <h2>Login Form</h2>
            <div class="form-container">

                <form action="/php/login.php" id="form" method="post">
                    <div class="input-name">
                        <label for="email" class="redStar">Email</label>

                        <div class="wrapper">
                            <input type="email" name="email" placeholder="eg:example@email.com " class="inp-typ1 redStar fullWidth" id="loginEmail" >
                            <i class="fa-solid fa-circle-info warning" style="color: #FFD43B;" tabindex="0" id="email-warn"></i>
                        </div>

                        <span id="loginEmail-err" class="err-msg"></span>

                        <span class="recomandation" id="email-recom">Input should be in email format...</span>

                    </div>


                    <div class="input-name">
                        <label for="password" class="redStar">Password</label>

                        <div class="wrapper">
                            <input type="password" name="pass" placeholder="Password" class="inp-typ1 redStar " id="loginPass">
                              <i class="fas fa-eye password-toggle-icon eye" ></i>
                        </div>

                        <span class="recomandation" id="pass-recom">Password contains <b>atleast 6 and atmost 10 character</b> including <b>a symbol,a digit,capital and small character</b>...</span>


                        <span id="loginPass-err" class="err-msg"></span>

                    </div>

                    <div class="input-name">
                        <input type="submit" value="Login" class="login">
                    </div>
                    <div class="input-name" id="account">
                        <span>Don't have an account?<a href="registration.php">Register now!!</a></span>
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