
<?php
include_once dirname(__FILE__) . '/../../autoload.php';

$data = array();

$error_msg = array(
    'input-username' => 'Please input a username',
    'conflict-names' => 'Oops. Same name but different members. Any different name we can call you? ',
    'length-exceeded' => 'Your name is hard to remember. Any abbrv? Please keep it between 3 and 15 characters',
);
$username = @$_GET['username'];


if(!@$_GET['username']){
    $data['error'] = $error_msg['input-username'];
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
$username = @$_GET['username'];

$users = new Users($pdoconnect, '');
if($users->isUsernameExists($username) || $users->checkIfUsernameReserved($username)){
    $data['error']['username'] = $error_msg['conflict-names'];
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if(strlen($username) < 3 || strlen($username) > 15){
    $data['error']['username'] = $error_msg['length-exceeded'] ;
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}


$data['success'] = 'Hooray. Let\'s proceed';
header('Content-Type: application/json');
echo json_encode($data);