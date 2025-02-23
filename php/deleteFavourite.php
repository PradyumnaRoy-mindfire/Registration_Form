<?php 
    if(session_status() == PHP_SESSION_NONE){ 
        session_start();
    }
        //if the session expired or the user log  out
    if( !$_SESSION['userId']) {
        header("Location: http://".$_SERVER['SERVER_NAME']."/login",true,301);
        exit();
    }

    include __DIR__.'/database.php';

         //For deleteing the favourite data
    if(isset($_GET['action']) && $_GET['action'] == 'delete') {
        $rowId = (int)$_GET['id']; 
        $userId = $_SESSION['userId'];

        $sqlDelete = "DELETE FROM favourites WHERE id='$rowId';";

        if (mysqli_query($conn,$sqlDelete)) {
            // Removing the favourite item from the user's array
            echo "favourite removed";
        } else {
            echo "Somthing error";
        }

    }
 ?>