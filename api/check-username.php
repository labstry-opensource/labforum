
<?php
include_once dirname(__FILE__) . '/../../autoload.php';

$data = array();
$apitools = new APITools();

$error_msg = array(
    'input-username' => 'Please input a username',
    'conflict-names' => 'Oops. Same name but different members. Any different name we can call you? ',
    'length-exceeded' => 'Your name is hard to remember. Any abbrv? Please keep it between 3 and 15 characters',
);
$username = @$_GET['username'];


if(!@$_GET['username']){
    $data['error'] = $error_msg['input-username'];
    $apitools->outputContent($data);
}
$username = @$_GET['username'];

$users = new Users($connection);
if($users->isUsernameExists($username) || $users->checkIfUsernameReserved($username)){
    $data['error']['username'] = $error_msg['conflict-names'];
    $apitools->outputContent($data);
}

if(strlen($username) < 3 || strlen($username) > 15){
    $data['error']['username'] = $error_msg['length-exceeded'] ;
    $apitools->outputContent($data);
}


$data['success'] = 'Hooray. Let\'s proceed';
$apitools->outputContent($data);