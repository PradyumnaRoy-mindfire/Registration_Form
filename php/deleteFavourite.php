<?php 
        if(session_status() == PHP_SESSION_NONE){ 
            session_start();
        }
            //if the session expired or the user log  out
        if( !$_SESSION['userId']) {
            header("Location: http://".$_SERVER['SERVER_NAME']."/login",true,301);
            exit();
        }

        $jsonFile = $_SERVER['DOCUMENT_ROOT'] . '/data.json';

        if (file_exists($jsonFile) && file_get_contents($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            $data = json_decode($jsonData, true);
        } else {
            $data = [];
        }
            //For deleteing the favourite data
        if(isset($_GET['action']) && $_GET['action'] == 'delete') {
            $rowId = (int)$_GET['id']; 
            $userId = $_SESSION['userId'];

            if (isset($data[$userId])) {
                if (isset($data[$userId]['favourite'][$rowId])) {
                    // Removing the favourite item from the user's array
                    unset($data[$userId]['favourite'][$rowId]);
                }
            }
    
            file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
        }
 ?>