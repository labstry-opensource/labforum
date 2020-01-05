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

<section class="landing-greetings-card text-white" style="margin-top: -50px; position: relative">
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
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="position: absolute; bottom: 0">
          <path d="m-3.4536e-7 289.71c0-24.805 0.28461-31.863 1.2848-31.864 0.70664-5.3e-4 23.949-3.0194 51.649-6.7087 201.78-26.874 304.66-35.385 428.09-35.416 52.389-0.013 78.18 0.76366 170.11 5.1226 109.21 5.1782 118.77 5.4766 176.79 5.5144 70.915 0.0461 110.11-2.1374 165.48-9.2178 81.614-10.437 180.67-33.082 282.66-64.617 26.304-8.1335 115.97-37.392 140.66-45.899 12.92-4.4509 23.905-8.0926 24.411-8.0926 0.5363 0 0.9204 46.541 0.9204 111.52v111.52h-1442.1z" fill="#fff"/>
    </svg>
</section>
