<?php

$users = new Users($connection);
$role = new UserRoles($connection);
$sign = new Sign($connection);
//Modules

if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Labstry is a general topics forum. Discussions ranging from programming to lifestyle.',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}
if (! isset($opt_in_script)) {
    $opt_in_script = array(
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.7/jquery.timeago.min.js'
    );
}

if (@$_SESSION['username']) {
    $users->getUserPropById(@$_SESSION['id']);
    $user_details = array(
        'profile' => $users->profilepic,
        'username' => @$_SESSION['username'],
        'rank_name' => $role->role_name,
        'signed_in_today' => $sign->checkIfSigned(@$_SESSION['id']),
        'rights' => 0,
        'continuous_checkin' => $sign->checkContinousSign(@$_SESSION['id'])
    );
    // For links in the greetings card.
    $display_links = array(
        array(
            'href'=> 'forumlist.php',
            'description' => 'Forum Lists'
        ),
        array(
            'href'=> 'post.php',
            'description' => 'Post New Thread'
        ),
        array(
            'href' => 'active.php',
            'decription' => 'Sign',
        )
    );
}
$thread_details = array(
    'thread-url' => 'api/threads-engine.php?page=home',
    'title' => 'Featured',
);
$latest_user = new Users($connection);
$users = new Users($connection);
$latest_user->getNewestUser();

$footer_details = array(
    'statistic' => array(
        'num_users' => $users->getUserCount(),
        'new_comer' =>  $latest_user->username,
        'new_comer_id' => $latest_user->userid,
    ),
    'links'=> array(
        //One array stands for a column
        0 => array(
            array(
                'href' => '/login3.php',
                'name' => 'Login',
            )
        ),
        1 => array(
            array(
                'href' => '/register.php',
                'name' => 'Register',
            )
        )
    )
);



$essentials = new Essentials($meta, null, $opt_in_script, $footer_details);

if (@$_SESSION['id']){
    $role->getUserRole(@$_SESSION['id']);
}


$essentials->getHeader();
?>


<div class="standard-wrapper home-content-wrapper">
    <?php
    include "widgets/landing-greetings-card.php";
    include "modules/thread-display.php";
    ?>
</div>
<?php
$essentials->getFooter();
?>
</body>
</html>

