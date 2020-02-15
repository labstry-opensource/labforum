<?php
//Use php to get thread head to prevent crawling issues in some search engines
$thread_head = json_decode(file_get_contents( PROTOCOL. 'localhost' . BASE_URL . '/api/thread-head.php?id=' . $_GET['id']), true);

if (! isset($meta)) {
    $meta = array(
        'description' => $thread_head['seo'],
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}


$essentials = new Essentials($meta, null, null, null);
$essentials->setTitle($thread_head['topic_name'] . '- Labstry Forum ');
$essentials->getHeader();

?>
    <div class="op-thread-container"  style="padding-top: 50px; margin-top: -50px;">
        <div class="op-thread-contents-wrapper"></div>
    </div>
    <div class="reply-thread-container" style="padding: 100px 0"></div>


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
        var thread_id = <?php echo json_encode($_GET['id']);?>;
        getThreadProp();


        function getThreadProp(){
            $.ajax({
                url: BASE_URL + '/api/threads-engine.php?id=' + thread_id,
                method: 'GET',
                success: function(data){
                    var tmpl = $.templates('#user-role-template');
                    var reply_tmpl = $.templates('#thread-reply-template');
                    $('.op-thread-contents-wrapper').html(tmpl.render(data));
                    $('.reply-thread-container').html(reply_tmpl.render(data.replies));
                }
            });
        }
    </script>

<?php
$essentials->getFooter();