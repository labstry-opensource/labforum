<?php
if(!isset($forum_listing_url)){
    $forum_listing_url = GLOB_API_DIR . '/forum-engine.php';
}
?>

<div class="forum-display-wrapper">

</div>

<script type="text/js-template" id="thread-instance">
    <div class="forum">
        <div class="forum_name">{{:fname}}</div>
    <div class="forum_description">{{:frules}}</div>
    </div>
</script>

<script>
    $.ajax({
        url: <?php echo json_encode($forum_listing_url);?>,
        method: 'GET',
        success: function(data){
            console.log(data);
        }
    })
</script>