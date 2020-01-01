<?php
if (! isset($thread_url)) {
    $thread_url = '/forum/api/get-home-threads.php';
}
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
    <div class="row no-gutters featured-thread-wrapper">
        <?php

        include "loading-circle.php"?>
    </div>

</div>

<script id="thread_viewer" type="text/x-jsrender">
    <a class="thread-container col-12 d-block text-decoration-none"
    href="/forum/thread.php?id={{:topic_id}}">
        <div class="thread-slide container">
            <div class="row py-2">
                <div class="col-12 col-md-9 order-1 order-md-2">
                    <div class="thread-name">{{:topic_name}}</div>
                    <time class="timeago" datetime="{{:date}}">{{:date}}</time>
                    <div class="py-3 row">
                        <div class="views col"><b>{{:views}}</b> views</div>
                        <div class="replies col"><b>{{:number_of_replies}}</b> replies</div>
                        
                    </div>
                </div>
                <div class="col-12 col-md-3 order-2 order-md-1 forum-name">
                    <div>{{:forum_name}}</div>
                    <div>{{:username}}</div>
                </div>
            </div>
        </div>
    </a>
</script>


<script>
    $.ajax({
        url: <?php

        echo json_encode(htmlspecialchars($thread_url))?>,
        method: 'GET',
        success: function(d){
            var tmpl = $.templates('#thread_viewer');
            $('.featured-thread-wrapper').html(tmpl.render(d));
            $('time.timeago').timeago();
        }
    });
</script>