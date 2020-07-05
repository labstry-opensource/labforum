<?php
if(!isset($_SESSION)) session_start();
if(!isset($user_details) || !@$_SESSION['username']) {
    $is_logged_in = false;
    $user_details = array(
        'profile' => '',
        'username' => 'Guest',
        'rank_name' => '<a class="text-white" href="/login.php">Login</a>',
        'signed_in_today' => true,
        'rights' => 0,
        'continuous_checkin' => 0,
    );
    $display_links = array(
        array(
            'href'=> 'forumlist.php',
            'description' => 'Forum Lists',
            'image' => '/forum/images/menu/discussion.png'
        ),
    );
}else if(@$_SESSION['username']){
    $is_logged_in = true;
    $display_links = array(
        array(
            'href'=> 'forumlist.php',
            'description' => 'Forum Lists',
            'image' => '/forum/images/menu/discussion.png'
        ),
        array(
            'href'=> 'account.php',
            'description' => 'Account Settings',
            'image' => '/forum/images/menu/discussion.png'
        ),
        array(
            'href'=> 'post.php',
            'description' => 'Post new thread',
            'image' => '/forum/images/menu/discussion.png'
        )
    );
    if($user_details && $roles_arr['rights'] >=90){
        array_push($display_links,
            array(
                'href'=> 'admin/index.php',
                'description' => '用戶和論壇管理',
                'image' => '/forum/images/menu/discussion.png'
            )
        );
    }
}

?>

<style>
    /*
    .greeting-content{
        border-radius: 90% 90% 90% 90% /15em;
    } */
</style>

<section class="landing-greetings-card text-white" style="margin-top: -50px">
    <div class="greeting-content  embed-responsive embed-responsive-16by6" style="min-height: 600px;">
        <div class="embed-responsive-item"
             style="background-image : url('<?php echo BASE_URL . '/images/system/photo_of_the_month.jpg'?>');
                     background-position: center center; background-size: cover; background-repeat: no-repeat; padding-bottom: 300px">
            <div class="container h-100 d-flex align-items-center position-relative" style="padding-top: 150px; z-index: 9">
                <div class="row">
                    <div class="col-12">
                        <h2 class="h3">Welcome, <span><?php echo $user_details['username']?></span>.</h2>
                        <div><?php echo $user_details['rank_name']?></div>
                    </div>
                    <div class="col-12 pt-5">
                        <div class="row">
                            <?php foreach ($display_links as $link){ ?>
                                <a href="<?php echo $link['href']; ?>" class="d-flex col-12 col-md align-items-center text-decoration-none">
                                    <img style="height: 50px" class="align-center" src="<?php echo $link['image'] ?>" alt="">
                                    <div class="align-middle text-white"><?php echo $link['description'] ?></div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <img src="<?php echo BASE_URL . '/images/system/wave.svg'?>" alt="" style="position:absolute; bottom: 0;
             left: 0; width: 100%;  ">
        </div>

    </div>
</section>
