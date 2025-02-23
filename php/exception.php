<?php


function my_error_log($error_level, $error_message, $fileName, $lineNo)
{
    $logFile = $_SERVER['DOCUMENT_ROOT'].'/Log/error.log';
    // echo $logFile;

    $timestamp = date('d-m-Y H:i:s');

    $logMessage = "[" . $timestamp . "] ";
    $logMessage .= "Level: " . $error_level . " - ";
    $logMessage .= "Message: " . $error_message ." ";
    $logMessage .=  $fileName." ";
    $logMessage .= "Line No. ".$lineNo."\n ";
    $logMessage .= "-----------------------------------------------------\n";

    file_put_contents($logFile, $logMessage, FILE_APPEND);
}





