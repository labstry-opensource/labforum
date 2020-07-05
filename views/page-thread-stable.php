<?php
//Use php to get thread head to prevent crawling issues in some search engines
$thread_head = json_decode(file_get_contents( 'http://localhost' . BASE_URL . '/api/thread-head.php?id=' . $_GET['id']), true);

if (! isset($meta)) {
    $meta = array(
        'description' => $thread_head['seo'],
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}
$opt_in_script = array(
    'https://unpkg.com/moment@2.24.0/min/moment.min.js',
    'https://unpkg.com/nouislider@14.5.0/distribute/nouislider.min.js',
);

$opt_in_style = array(
    'https://unpkg.com/nouislider@14.5.0/distribute/nouislider.min.css',
);

$essentials = new Essentials($meta, '' , $opt_in_script, null, $opt_in_style);
$essentials->setTitle($thread_head['topic_name'] . '- Labstry Forum ');
$essentials->getHeader();

?>
    <div>
        <div class="op-thread-container"  style="padding-top: 50px; margin-top: -50px;">
            <div class="op-thread-contents-wrapper">
                <div class="d-flex justify-content-center align-items-center" style="min-height: 400px">
                    <?php
                    $loading_msg = "Loading thread, please wait...";
                    include LAF_PATH . '/widgets/loading-circle.php'?>
                </div>
            </div>
        </div>
        <div class="reply-thread-container" style="padding: 100px 0"></div>
        <div class="quick-reply" style="border-radius: 24px">
            <?php if(isset($_SESSION['id'])) {?>
                <form class="quick-reply-form" method="post"
                      action="<?php echo BASE_ROOT_API_URL . '/post-reply.php?id=' . @$_GET['id'] ?>">
                    <div class="d-flex align-items-center"
                         style="background-color:#3458eb; min-height: 200px; border-radius: 24px">
                        <div class="container">
                            <div class="form-group text-light">
                                <input type="hidden" name="thread_id" value="<?php echo @$_GET['id'] ?>">
                                <label for="replyTitle" class="h2 py-5">Quick Reply</label>
                                <input type="text" class="form-control my-5 quick-reply-title reply_topic" id="replyTitle"
                                       placeholder="Title" name="reply_topic">
                                <div class="invalid-feedback reply_topic-invalid-feedback"></div>
                            </div>

                        </div>
                    </div>
                    <div class="container form-group">
                <textarea name="reply_content" class="form-control my-2 quick-reply-content reply_content" style="min-height: 200px"
                          placeholder="Reply content here..."></textarea>
                        <div class="invalid-feedback reply_content-invalid-feedback"></div>
                    </div>
                    <div class="container">
                        <button class="btn btn-success" style="border-radius: 24px">
                            Submit
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>

    <script id="user-role-template" type="text/html">
        <?php
        $thread_type = 'op';
        include LAF_PATH . '/modules/thread-author-display.php';?>
    </script>
    <script id="thread-reply-template" type="text/html">
        <?php
        $thread_type = 'reply';
        include LAF_PATH . '/modules/thread-author-display.php';?>
    </script>
    <script>
        var BASE_URL = <?php echo json_encode(BASE_URL); ?>;
        var thread_id = <?php echo json_encode(@$_GET['id']);?>;
        var thread_prop = undefined;
        getThreadProp();

        function getThreadProp(){
            $.ajax({
                url: BASE_URL + '/api/threads-engine.php?id=' + thread_id,
                method: 'GET',
                success: function(data){
                    thread_prop = data;
                    var tmpl = $.templates('#user-role-template');
                    var reply_tmpl = $.templates('#thread-reply-template');
                    $('.op-thread-contents-wrapper').html(tmpl.render(data));
                    $('.reply-thread-container').html(reply_tmpl.render(data.replies));
                }
            });
        }

        $('.quick-reply-form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method:  $(this).attr('method'),
                data: $(this).serialize(),
                success: function(data){
                    if(data.error){
                        for(key in data.error){
                            $('.' + key).addClass('is-invalid');
                            $('.' + key + '-invalid-feedback').html(data.error[key]);
                        }
                    }else{
                        //window.location = window.location.href;
                    }

                }
            });

        });


    </script>

<?php
$essentials->getFooter();