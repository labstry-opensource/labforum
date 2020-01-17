<?php
if(!isset($forum_listing_url)){
    $forum_listing_url = GLOB_API_DIR . '/forum-engine.php';
}
?>

<style>
    .forum-block{
        background-color: palegoldenrod;
        color: #000;
        position: relative;
    }
    .forum-block:after{
        content: '';
        background-color: #000;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;

    }
    .forum-show-wrapper{
        border-radius: 25px;
    }
</style>

<div data-title="Forum Listing" id="forum-listing" class="pushed-el-cards forum-display-wrapper container"></div>

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