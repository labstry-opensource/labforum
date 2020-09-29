<?php

header('Content-Type: application/json; charset=utf-8');

session_start();

include dirname(__FILE__) . '/../autoload.php';

$users = new Users($connection, "");
$roles = new UserRoles($connection);
$roles->getUserRole(@$_SESSION['id']);


if(!@$_SESSION["id"] || $roles->rights < 90 || !@$_POST["id"]){
    header("HTTP/2.0 403 Forbidden");
    die('403 Forbidden');
}

$validate_code = password_hash(rand(1001, 9987)."#R$@%^%&Y$^".rand(1, 8982)."5^$#%GDS5$%",PASSWORD_DEFAULT);


$users->getUserPropById(@$_POST["id"]);

$to = $users->email ;
$subject = 'You have requested our @admin to reset your password';
$message = '
<html>
<body style="font-family: Tahoma, Arial">
<div>
    <div style="padding-bottom: 15px">Hi '.$users->username.',</div>
    <div>According to our records, you have sent a request to reset your password.
        <strong>Please click the button below to reset your password.</strong>
    </div>
</div>


<a style="text-decoration:none; display: inline-block; width: 300px;

border-radius: 25px; background: orange; color: white; padding: 25px; margin: 15px;"
   href="https://www.labstry.com/reset-password.php?c='.urlencode($validate_code).'">Reset my password</a>
<div>If you didn\'t request for a password reset, please notify us to keep your account save.</div>

<div style="margin-top: 10px; margin-bottom: 10px">Best Regards,</div>
<div>Labstry Forum</div>

</body>

</html>';
$headers = array(
    "From" => "Labstry Forum <noreply@labstry.com>",
    "Reply-To" => "noreply@labstry.com",
    "X-Mailer" => "PHP/".phpversion(),
    "X-Priority" => "1",
    "MIME-Version" => "1.0",
    "Content-type" => "text/html; charset=UTF-8",
    "Organization" => "Labstry Forum",
);


// Sending email
if(mail($to, $subject, $message, $headers)){
    $info["success"] = "Your mail has been sent successfully.";
    echo json_encode($info);
} else{
    echo 'Unable to send email. Please try again.';
}