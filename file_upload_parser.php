<?php
$fileName = $_FILES["local_url"]["name"]; // The file name
$fileTmpLoc = $_FILES["local_url"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["local_url"]["type"]; // The type of file it is
$fileSize = $_FILES["local_url"]["size"]; // File size in byte
$fileErrorMsg = $_FILES["local_url"]["error"]; // 0 for false... and 1 for true
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
if(move_uploaded_file($fileTmpLoc, "mp3/$fileName")){
    echo "$fileName upload is complete";
} else {
    echo "move_uploaded_file function failed";
}
?>