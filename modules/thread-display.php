<?php
if(! isset($thread_details)){
    $thread_details = array(
            'thread-url' =>  BASE_ROOT_API_URL . '/threads-engine.php?page=thread&id=1',
            'title' => 'Featured',
    );
}

$thread_url  = $thread_details['thread-url'];
?>
<style>
    .thread-slide {
        min-height: 100px;
        width: 100%;
        position:relative;
    }
    .thread-container:nth-child(2n+1){
        background-color: #fff;
        color: #0099ff;
    }
    .thread-container:nth-child(2n){
        background-color: #ACACAC;
        color: #fff;
    }
    .thread-container:nth-child(2n+1) .forum-name:before{
        background-color: #0099ff;
    }
    .thread-container:nth-child(2n) .forum-name:before{
        background-color: #fff;
    }
    .thread-container .svg-top{
        transform: translateY(-100%);
        z-index: 2;
    }
    .thread-container .svg-bottom{
        z-index: 3;
    }
    .forum-name:before{
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 4px;
        
    }

</style>
<div data-title="Featured" id="featured" class="pushed-el-cards">
    <div class="container">
        <div class="text-center h1" style="color: hotpink"><large><?php echo $thread_details['title']?></large></div>
    </div>

    <div class="row no-gutters featured-thread-wrapper">
        <?php

        include dirname(__FILE__)."/../widgets/loading-circle.php" ?>
    </div>

</div>

<script id="thread_viewer" type="text/x-jsrender">
    <?php include dirname(__FILE__) . '/../widgets/thread-display/detail-thread-widget.php'; ?>
</script>


<script>
    $.ajax({
        url: <?php echo json_encode(htmlspecialchars($thread_url))?>,
        method: 'GET',
        success: function(d){
            var tmpl = $.templates('#thread_viewer');
            $('.featured-thread-wrapper').html(tmpl.render(d));
            $('time.timeago').timeago();
        }
    });
</script>