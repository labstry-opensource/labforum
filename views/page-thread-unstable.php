<?php
//Use php to get thread head to prevent crawling issues in some search engines
$thread_head = json_decode(file_get_contents( PROTOCOL. '127.0.0.1.xip.io' . BASE_URL . '/api/thread-head.php?id=' . $_GET['id']), true);

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
    <div class="op-thread-container"></div>


    <script id="user-role-template" type="text/html">
        <?php include LAF_PATH . '/modules/thread-author-display.php';?>
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
                    $('.op-thread-container').html(tmpl.render(data));
                }
            });
        }
    </script>

<?php
$essentials->getFooter();