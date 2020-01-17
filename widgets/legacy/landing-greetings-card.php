<?php
if(!isset($user_details) || !@$_SESSION['username']) {
    $is_logged_in = false;
    $user_details = array(
      'profile' => '',
      'username' => 'Guest',
      'rank_name' => 'Guest',
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
$greetings= array(
    'Guest',
    '<a href="/login.php">Login</a>'
);
?>

<div class="card" style="height: auto">
    <div style="width: 100%; height: 100px; border-radius: 25px 25px 0 0; background-color:#add8e6; display:inline-block">
        <?php if($is_logged_in === true){?>
            <img class="oneliner" src="<?php echo $user_details['profile'] ?>" style="border-radius: 25px; height: 120px; width: 120px;" />
        <?php } ?>


        <div class="name oneliner">
            <div style="display: block;">
                <?php echo ($is_logged_in === true)? $user_details['username'] : $greetings[0];?>
            </div>
            <div style="display: block;">
                <?php echo ($is_logged_in === true)? $user_details['rank_name']: $greetings[1]; ?>
            </div>
        </div>
    </div>
    <div class="row py-3">
        <?php if($is_logged_in === true){ //Logged in ?>
            <div class="col-12 col-md-4 col-lg">
                <div class="cardlink p-4">
                    <?php if($user_details['signed_in_today']){ ?>
                        連續簽到 <span class="counter" data-count="<?php echo $user_details['continuous_checkin']; ?>">0</span> 次
                    <?php } else { ?>
                        <a href='<?php echo @$_SERVER['PHP_SELF']; ?>?action=checkin' class=''>簽到</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php foreach ($display_links as $link){?>
            <a href="<?php echo $link['href']?>"
               class="col-12 col-md-4 col-lg">
                <div class="cardtext p-4"><?php echo $link['description']?></div>
            </a>
        <?php }?>
    </div>
</div>