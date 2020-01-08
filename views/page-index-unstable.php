<?php

$users = new Users($pdoconnect, "");
$role = new UserRoles($pdoconnect);
$sign = new Sign($pdoconnect);
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
if(!isset($footer_details)){
    $latest_user = new Users($pdoconnect, '');
    $users = new Users($pdoconnect, '');
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
}




$essentials = new Essentials($meta, null, $opt_in_script);

if (@$_SESSION['id']){
    $role->getUserRole(@$_SESSION['id']);
}


$essentials->getHeader();
?>


  <div class="standard-wrapper home-content-wrapper">
      <?php
      include "widgets/landing-greetings-card3.php";
      include "modules/thread-display.php";
      ?>
  </div>
<?php
$essentials->getFooter();
?>
</body>
</html>
<?php
if (@$_GET['action'] == 'checkin') {
    // deprecated for finding id through database !!!!

    // We should protect our code by checking whether user have signed
    // We MUST USE PREPARED STATEMENT HERE TO PREVENT INJECTION
    $id = @$_SESSION['id'];
    $signstatsql = "SELECT COUNT(*) FROM checkin WHERE id = ? AND TO_DAYS(checkindate) = TO_DAYS(NOW())";
    $times = $pdotoolkit->rowCounterWithPara($pdoconnect, $signstatsql, $id);
    if (! $times) {
        $signstmt = $pdoconnect->prepare("INSERT INTO checkin(id, checkindate) VALUES(?, NOW())");
        $signstmt->bindParam(1, $id);
        $signstmt->execute();
        $checkincount = $pdotoolkit->rowCounterWithLimit($pdoconnect, "continuouscheckin", "id=" . $id);

        // When we found a continuous record for checkin, then our action is to update it. Otherwise, we will insert a new record
        if (! $checkincount)
            $contstmt = "INSERT INTO continuouscheckin(id, times) VALUES(?, '1')";
        else
            $contstmt = "UPDATE continuouscheckin SET times = times + 1 WHERE id = ?";

        $contchkin = $pdoconnect->prepare($contstmt);
        $contchkin->bindParam(1, $id);
        $contchkin->execute();
    }
    echo "<script>window.location='index.php';</script>";
    header("Location: index.php");
}
if (@$_GET['action'] == "logout") {
    session_destroy();
    echo "<script>window.location='index.php';</script> ";
}
?>
