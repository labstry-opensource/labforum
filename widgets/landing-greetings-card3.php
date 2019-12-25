<?php
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
            'description' => 'Forum Lists'
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
                'description' => '用戶和論壇管理'
            )
        );
    }
}

?>
<style>
    .forum-shortcut{
        margin-top: -50px;
    }
    @media screen and (min-width: 576px) {
        .forum-shortcut{
            margin-top: -100px
        }
    }
    @media screen and (min-width: 768px){
        .forum-shortcut{
            margin-top: -125px
        }
    }
</style>

<section class="landing-greetings-card text-white">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#00c5ff" fill-opacity="1"
              d="M0,224L60,224C120,224,240,224,360,186.7C480,149,600,75,720,48C840,21,960,43,1080,48C1200,53,1320,43,1380,37.3L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
    <div class="greeting-content" style="background-color: #00c5ff; min-height: 100px; margin-top: -.25rem; margin-bottom: -.25rem">
        <div class=container>
            <div class="row">
                <div class="col-7 col-md-6">
                    <h2 class="h3">Welcome, <span><?php echo $user_details['username']?></span>.</h2>
                    <div><?php echo $user_details['rank_name']?></div>
                </div>
                <div class="col-5 col-md-6 forum-shortcut">
                    <div class="row">
                        <a href="forumlist.php" class="d-flex col-12 align-items-center text-decoration-none">
                            <img style="height: 50px" class="align-center" src="/forum/images/menu/discussion.png" alt="">
                            <div class="align-middle text-white">Forum Listing</div>
                        </a>
                    </div>

                </div>
            </div>


        </div>
    </div>

    <svg style="background-color: #00c5ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#fff" fill-opacity="1"
              d="M0,224L60,224C120,224,240,224,360,186.7C480,149,600,75,720,48C840,21,960,43,1080,48C1200,53,1320,43,1380,37.3L1440,32L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
    </svg>
</section>
