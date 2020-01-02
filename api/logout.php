<?php

if(@$_SESSION['username']){
    session_destroy();
    $data['sucess'] = ture;
    return json_encode($data);
}