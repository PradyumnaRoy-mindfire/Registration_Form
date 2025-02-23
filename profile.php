<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/profile.css">
    <title>Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php 
       if(session_status() == PHP_SESSION_NONE) {
            session_start();
       }

       if(isset($_SESSION['login']) ) { ?>
            <div class="loginPopup">
                <div class="loginContent">
                    <span><i class="fa-regular fa-circle-check fa-beat" style="color: #31ed47;" id="successIcon"></i></span>
                    <h4>THANK YOU</h4>
                    <p>Loginned successfully...</p>
                </div>
            </div>

        <?php } 
      unset($_SESSION['login']);   
    ?>



    <?php
        include __DIR__.'/php/exception.php';
            //if session expired redirect to the login page
        if( !$_SESSION['userId']) {
            header("Location: http://".$_SERVER['SERVER_NAME']."/login",true,301);
            exit();
        }
        $jsonFile = $_SERVER['DOCUMENT_ROOT'] . '/data.json';
        try{
            if (file_exists($jsonFile) && file_get_contents($jsonFile)) {
                $jsonData = file_get_contents($jsonFile);
                $data = json_decode($jsonData, true);
            } else {
                $data = [];
                throw new Exception("File not found.....");
                file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        catch(Exception $e){
            my_error_log('FATAL', $e->getMessage(),$e->getFile(),$e->getLine());
        }
        

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $fname = isset($_POST['fname']) ? $_POST['fname'] : $_SESSION['fname'];
            $lname = isset($_POST['lname']) ? $_POST['lname'] : $_SESSION['lname'];
            $email = isset($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
            $phno = isset($_POST['phno']) ? $_POST['phno'] : $_SESSION['phno'];
            $address = isset($_POST['address']) ? $_POST['address'] : $_SESSION['address'];
            $i = 0;

            $isValid = true;
            $nameErr = "";
            $emailErr = "";
            $phnoErr = "";

                //validations for favourite input (name and item) both can't be null ,name will have only characters
            if(empty($fname) || preg_match('/\d/',$fname) || preg_match('/\d/',$lname)) {
                $nameErr = "**First name and last name should not be empty or not contain any digits";
                $isValid = false;
            }
            $emailRegx = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/';
            if(empty($email) || preg_match($emailRegx,$email) == false) {
                $emailErr = "**Email is not valid...";
                $isValid = false;
            }
            if(empty($phno) || preg_match("/^\d{10}$/",$phno) == false) {
                $phnoErr = "**Phno should contain exactly ten digits..";
                $isValid = false;
            }

            if($isValid == true) {
                $i = $_SESSION['userId'];
                    if ($data[$i]['email'] == $_SESSION['email']) {
                        $data[$i]['fname'] = $fname;
                        $data[$i]['lname'] = $lname;
                        $data[$i]['email'] = $email;
                        $data[$i]['phno'] = $phno;
                        $data[$i]['address'] = $address;
                        //Update both session data and data.json
                        $_SESSION['fname'] = $fname;
                        $_SESSION['lname'] = $lname;
                        $_SESSION['email'] = $email;
                        $_SESSION['phno'] = $phno;
                        $_SESSION['address'] = $address;
                        
                    }
            }
                //click update button For reindexing SL no of the favourite data 
            if($data[$_SESSION['userId']]['favourite']) {
                    //copying the values to the favourites array with default index(if we had deleted before)
                $favourites = array_values($data[$_SESSION['userId']]['favourite']); 
                $newFavourites = [];
                    //$index => $fav works like key value pair index and correspoding favourite
                foreach ($favourites as $index => $fav) {
                    $newFavourites[$index + 1] = [
                        'id' => $index + 1, 
                        'name' => $fav['name'],
                        'item' => $fav['item']
                    ];
                }
                    //update the new indexed array to the old
                $data[$_SESSION['userId']]['favourite'] = $newFavourites;
                    //update also to the session to get current indexed in js from the hidden input
                $_SESSION['totalFavourite'] = count($newFavourites);
            }

            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($jsonFile, $jsonData);

            
        }


            // For favourite data store request coming from ajax (favourite.js)
        if(isset($_GET['action']) && $_GET['action'] == 'storeFavouriteData') {
            $favouriteName = $_GET['favData']['name'];
            $favouriteItem = $_GET['favData']['item'];
            $rowId = $_GET['rowId'];

            $j = $_SESSION['userId'];

                if ($data[$j]['email'] == $_SESSION['email']) {
                    
                    $data[$j]['favourite'][$rowId] = [
                        'id'=> $rowId,
                        'name' => $favouriteName,
                        'item' => $favouriteItem
                    ];
                    $_SESSION['totalFavourite'] = $rowId;

                    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
                }
            
        }


            //log out request coming from ajax (favourite.js)
        if(isset($_GET['action']) && $_GET['action'] == 'logout') {
            session_destroy();
        }

    ?>


    <title>Profile</title>
</head>

<body>
    <div class="container">
        <div class="login-box">

            <form action="/profile.php" id="profile-form" method="POST">
                <div class="profileIcon">
                    <i class="fa-solid fa-circle-user fa-flip fa-2xl" style="color: #f37932;"></i>
                    
                    <img src="<?php echo substr($_SESSION['photo'], 13) ?>" alt="" class="photo fa-circle-user  fa-2xl ">
                </div>
                <h3>My Profile </h3>
                <!--For Favourite Item -->
                <div class="favourite">
                    <i class="fa-regular fa-heart fa-xl favouriteIcon" style="color: #f53d1c;" title="Favourite"></i>
                </div>

                <div class="inpDiv " id="username">
                    <i class="fa-solid fa-user  fa-lg icon"></i>
                    <input type="text" name="fname" id="fnameProfile" class="profileInput" value="<?php echo $_SESSION['fname'] ?>">
                    <input type="text" name="lname" id="lnameProfile" class="profileInput" value="<?php echo $_SESSION['lname'] ?>">
                </div>
                <span class="err-msg" id="pfname-err"><?php if(isset($fname) && isset($lname)) echo $nameErr?></span>

                <div class="inpDiv" id="phnopf">
                    <i class="fa-solid fa-square-phone  fa-lg icon "></i>
                    <input type="number" name="phno" id="phnoProfile" class="profileInput" value="<?php echo $_SESSION['phno'] ?>">
                </div>
                <span class="err-msg" id="pfphno-err"> <?php if(isset($phno)) echo $phnoErr?></span>

                <div class="inpDiv" id="emailpf">
                    <i class="fa-solid fa-envelope  fa-lg icon"></i>
                    <input type="email" name="email" id="emailProfile" class="profileInput" value="<?php echo $_SESSION['email'] ?>">
                </div>
                <span class="err-msg" id="pfemail-err"> <?php if(isset($email)) echo $emailErr?></span>

                <div class="inpDiv" id="addresspf">
                    <i class="fa-solid fa-location-dot fa-lg icon"></i>
                    <input type="text" name="address" id="addressProfile" class="profileInput" value="<?php echo $_SESSION['address'] ?>">
                </div>
                

                <!-- for lo g out -->
                <div class="logout">
                    <i class="fa-solid fa-right-from-bracket fa-lg logoutIcon" style="color: #f53d1c;" title="Log out"></i>
                </div>

                <div class="update inpDiv">
                    <input type="submit" value="Update" id="btnUpdate">
                </div>
            </form>

        </div>


    </div>
    <div class="container2">
        <div class="closeIconDiv">
            <i class="fa-solid fa-xmark fa-xl closeFavourite" style="color: #ffffff;" title="Hide favourite"></i>
        </div>
        <h2>Favourites</h2>
        <table id="table">
            <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Name</th>
                    <th>Item</th>
                    <th>Action</th>
                </tr>
                <?php
                $k = $_SESSION['userId'];
                
                if(isset($data[$k]['favourite'])) {
                    foreach ($data[$k]['favourite'] as $row){ ?>
                        <tr>
                            <td> <?php echo htmlspecialchars($row['id']) ?></td>
                            <td> <?php echo htmlspecialchars($row['name']) ?></td>
                            <td> <?php echo htmlspecialchars($row['item']) ?></td>
                            <td> <i class="fa-solid fa-trash  btnDelete" style="color: #ff0a0a;"></i></td>
                        </tr>
                <?php } } ?>



            </thead>

            <tbody>
                <!-- Prepend to this row -->
                <tr class="emptyRow" style="background-color: black;">
                    <td colspan="4" style=" text-align: center;" ><button id="openForm">New</button></td>
                </tr>
            </tbody>
        </table>
        <div class="dropdown-form">
            <form id="favouriteForm" method="POST">
                        <!-- for getting current index in js from server -->
                <input type="hidden" value="<?php echo $_SESSION['totalFavourite'] + 1;?> " id="favouriteId" >

                <input type="text" id="favouriteName" class="favouriteFormInput" name="favouriteName" required placeholder="Name"><br><br>
                <span class="err-msg error" id="favNameErr"></span>

                <input type="text" id="favouriteItem" class="favouriteFormInput" name="favouriteItem" required placeholder="Item"><br><br>
                <span class="err-msg error" id="favItemErr"></span>

                <button type="submit" class="Favourite-btn" >Add to Favourite</button>
            </form>
        </div>
    </div>


    <div class="logoutPopup">
        <div class="logoutContent">
            <span><i class="fa-solid fa-circle-exclamation fa-shake" id="logoutWarnIcon"style="color: #f56224;" title="Logout"></i></i></span>
            <h4>Log Out</h4>
            <p>Are you sure, you want to log out?</p>
            <div class="btn">
                <button id="btnLogoutPopup"><b>Yes,Logout</b></button>
                <button id="btnCancelPopup"><b>CANCEL</b></button>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
    <script src="./js/favouriteModule.js"></script>
    <script src="./js/validationModule.js"></script>
    <script src="./js/pageModule.js"></script>
</body>

</html>

    
   