<?php

$page = isset($_GET['page'])? $_GET['page'] : 1;
$fid = isset($_GET['id']) ? $_GET['id'] : 1;

if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Find topics that you are interested on.',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}

if (! isset($opt_in_script)) {
    $opt_in_script = array(
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.7/jquery.timeago.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js',
    );
}
if(!isset($_SESSION['id'])){
   $is_user_moderator = false;
}else{
    $moderator = new Moderator($pdoconnect);
    $is_user_moderator = $moderator->isUserForumModerator($_SESSION['id'], $fid);
    $has_right_to_author = $forum->hasRightsToAuthorInForum($_GET['id'], $roles_arr['rights']);
}


$essentials = new Essentials($meta, '', $opt_in_script);
$essentials->setTitle('Forum - Labstry Forum');
$essentials->getHeader();

?>
    <div class="container">
        <div class="position-relative">
            <div class="embed-responsive embed-responsive-16by6">
                <div class="embed-responsive-item" style="
                        background-image: url(<?php echo BASE_URL?>/images/system/forum-placeholder-banner.png);
                        background-position: center center;
                        background-size: cover;
                        background-repeat: no-repeat;">
                    <div class="position-absolute d-none d-md-flex align-items-center p-2 px-md-5" style="bottom: 0; height: 100px;left:0; right:0">
                        <h1 class="h3 text-white forum-name">Loading...</h1>
                        <div class="ml-auto">
                            <?php if(@$has_right_to_author){?>
                                <a href="post.php?posting_forum=<?php echo $_GET['id']?>" class="btn btn-call-to-action" style="border-radius: 24px">Post New Thread</a>
                            <?php } ?>
                            <?php if($is_user_moderator === true){?>
                                <a href="forum-manage.php" class="btn btn-primary"  style="border-radius: 24px">Manage</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="d-block d-md-none py-3">
            <h1 class="h3 forum-name">Loading...</h1>
            <?php if(@$has_right_to_author){ ?>
                <a href="post3.php" class="btn btn-call-to-action" style="border-radius: 24px">Post New Thread</a>
            <?php } ?>
            <?php if($is_user_moderator === true){?>
                <a href="forum-manage.php" class="btn btn-primary" style="border-radius: 24px">Manage</a>
            <?php } ?>
        </div>
        <div class="row align-items-center" style="min-height: 200px">
            <div class="col-12 col-md-6 my-4 px-md-5">
                <b>Rules :</b>
                <div class="forum-rules"></div>
            </div>
            <div class="col-12 col-md-6 my-4">
                <b>Moderators:</b>
                <div class="moderator-wrapper"></div>
                <?php include LAF_PATH. '/modules/moderator-display.php'?>
            </div>
        </div>
    </div>
    </div>
    <div class="">
        <?php include LAF_PATH. '/modules/dynamic-thread-display.php'?>
    </div>

    <script>
        var thread_data;
        var max_page;
        var current_page = <?php echo isset($_GET['page'])? json_encode(htmlspecialchars($_GET['page'])) : 1;?>;
        var fid = <?php echo $fid ;?>;
        var thread_api = <?php echo json_encode(htmlspecialchars(BASE_URL . '/api/threads-engine.php?'));?>;
        var forum_api = <?php echo json_encode(htmlspecialchars(BASE_URL . '/api/forum-engine.php?'));?>;
        var count = 10;

        <?php //Get forum details ?>
        $.ajax({
            url: forum_api + 'fid=' + fid,
            method: 'GET',
            success: function(d){
                $('.forum-name').text(d.fname);
                $('#forum-threads-wrapper').data('title', d.fname);
                if(!d.rules){
                    $('.forum-rules').html('The lazy moderator haven\'t setup any rules. Follow rules in generic forum rules');
                }else{
                    $('.forum-rules').html(d.rules);
                }
                var tmpl = $.templates('#moderator-show');
                $('.moderator-wrapper').html(tmpl.render(d.moderators));
            }
        });

        <?php //Get forum threads by page ?>
        var page = {
            'page' : current_page,
            'fid' : fid,
            'count' : count,
        };
        $.ajax({
            url: thread_api + $.param(page),
            method: 'GET',
            success: function(d){
                thread_data = d.data;
                var tmpl = $.templates('#thread_viewer');
                $('.featured-thread-wrapper').html(tmpl.render(thread_data));
                $('time.timeago').timeago();
                current_page = d.current_page;
                max_page = d.pages;
            }
        });

        $('.next-btn').on('click', function(e){
            e.preventDefault();
            if(current_page === max_page) return;
            var next_page = {
                'page' : current_page + 1,
                'count' : count,
                'fid' : fid,
            }
            $.ajax({
                url: thread_api +  $.param(next_page),
                method: 'GET',
                success: function(d){
                    $.merge(thread_data, d.data);
                    var tmpl = $.templates('#thread_viewer');
                    $('.featured-thread-wrapper').html(tmpl.render(thread_data));
                    $('time.timeago').timeago();
                    current_page = d.current_page;
                    if(current_page === max_page){
                        $('.next-btn').addClass('disabled').text('Showed all threads. Phew~');
                    }
                }
            });
        });
    </script>
<?php

$essentials->getFooter();

?>