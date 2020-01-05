<?php
session_start();
if(@$_SESSION['username']){
    session_destroy();
    $data['sucess'] = ture;
    header('Content-Type: application/json');
    echo json_encode($data);
}