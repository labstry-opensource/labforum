<?php
if(!isset($forum_listing_url)){
    $forum_listing_url = GLOB_API_DIR . '/forum-engine.php';
}
?>

<div class="forum-display-wrapper container"></div>

<script type="text/js-template" id="thread-instance">
    <?php include dirname(__FILE__) . '/../widgets/forum-display/forumlist-display-widget.php'; ?>
</script>

<script>
    $.ajax({
        url: <?php echo json_encode($forum_listing_url);?>,
        method: 'GET',
        success: function(d){
            var tmpl = $.templates('#thread-instance');
            $('.forum-display-wrapper').html(tmpl.render(d));
        }
    })
</script>