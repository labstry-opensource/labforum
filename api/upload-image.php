<?php
include_once dirname(__FILE__) . '/../autoload.php';

$apitools = new APITools();

$allowed_format = array();

if(!isset($_SESSION['id'])){
    http_response_code(403);
    print_r('403 Forbidden');
    exit;
}

if(empty($_FILES)){
    $data['error']['msg'] = "No files has been posted";
    $apitools->outputContent($data);
}
$roles = new UserRoles($pdoconnect);
$roles->getUserRole($_SESSION['id']);

if($roles->rights >= 90){
    $allowed_format = ['jpg', 'png', 'jpeg', 'gif', 'mp4'];
}else{
    $allowed_format = ['jpg', 'png', 'jpeg', 'gif'];
}

$filename = $_FILES['file']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array($ext, $allowed_format, true)){
    $data['error']['msg'] = "The file format is not accepted";
    $apitools->outputContent($data);
}


if($_FILES['file']['error'] != UPLOAD_ERR_OK){
    if($_FILES['file']['error'] == '1' || $_FILES['file']['error'] == '2'){
        $data['error']['msg'] = "The file cannot be uploaded. The file exceeded file limit.";
    }
    if($_FILES['file']['error'] == '4'){
        $data['error']['msg'] = "The file cannot be uploaded";
    }
    $apitools->outputContent($data);
}

$tmp_name = crc32(hash_file('crc32', $_FILES['file']['tmp_name']) . '-'.  $_SESSION['id']);
$dest_dir = dirname(__FILE__) . '/../images/post';

$target_file = $dest_dir . '/' . $tmp_name . '.' . $ext;

if(!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)){
    $data['error']['msg'] = "The file cannot be moved";
    $apitools->outputContent($data);
}
else{
    $data['success']= array(
        'msg' => "The file has been uploaded successfully",
        'uploaded_file' => $tmp_name . '.' .$ext,
    );
    $apitools->outputContent($data);
}