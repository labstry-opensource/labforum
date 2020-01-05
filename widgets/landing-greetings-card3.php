<?php
if(!isset($_SESSION)) session_start();
if(!isset($user_details) || !@$_SESSION['username']) {
    $is_logged_in = false;
    $user_details = array(
        'profile' => '',
        'username' => 'Guest',
        'rank_name' => '<a href="/login.php">Login</a>',
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
            'description' => 'Forum Lists'
        ),
        array(
            'href'=> 'account.php',
            'description' => 'Account Settings'
        ),
        array(
            'href'=> 'post.php',
            'description' => 'Post new thread',
        )
    );
    if($user_details && $role->rights >=90){
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

<section class="landing-greetings-card text-white" style="margin-top: -50px;">
    <div class="greeting-content d-flex align-items-center" style="background-color: #0099ff; min-height: 500px; padding-bottom: 5rem">
        <div class="container">
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
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
          <path fill="#0099ff" fill-opacity="1" d="M0,224L80,197.3C160,171,320,117,480,101.3C640,85,800,107,960,106.7C1120,107,1280,85,1360,74.7L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
    </svg>
</section>
