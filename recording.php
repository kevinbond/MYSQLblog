<?php

// KLogger is a logging class from 
// http://codefury.net/projects/klogger/
require_once 'KLogger.php';

$log = new KLogger ( "log.txt", KLogger::DEBUG);
$log->LogInfo($_GET['name']);
// Change this path to match the location on your server where you want
// the file to be saved.
$target_path = $_GET['name'] . ".wav";
// $log->LogInfo(move_uploaded_file($_FILES['filename']['tmp_name'], $target_path));
$log->LogInfo($_FILES['filename']['tmp_name']);
$log->LogInfo($target_path);

if(move_uploaded_file($_FILES['filename']['tmp_name'], $target_path)) {
  $log->LogInfo("$target_path [{$_FILES['filename']['size']} bytes] was saved");
} else {
  $log->LogError("$target_path could not be saved.");
}

?>