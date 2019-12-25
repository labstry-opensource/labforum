<?php
if(!isset($thread_url)){
    $thread_url = '/api/forum/get-home-threads.php';
}
?>
<style>
    .thread-slide {
        min-height: 200px;
        width: 100%;
        position:relative;
    }
    .thread-container:nth-child(2n+1){background-color: #fff;color: #0099ff;}
    .thread-container:nth-child(2n){
        background-color: #0099ff;
        color: #fff;
    }
    .thread-container .svg-top{
        transform: translateY(-100%);
        z-index: 2;
    }
    .thread-container .svg-bottom{
        z-index: 3;
    }

</style>
<div data-title="Featured" class="pushed-el-cards">
    <div class="row no-gutters featured-thread-wrapper">
        <?php include "loading-circle.php"?>
    </div>

</div>

<script id="thread_viewer" type="text/x-jsrender">
    <a class="thread-container  col-12 d-block text-decoration-none"
    href="/forum/thread.php?id={{:topic_id}}">
       <svg class="svg-top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="{{if #index % 2 === 0}}#fff{{else}} #0099ff{{/if}}" fill-opacity="1" d="M0,64L48,74.7C96,85,192,107,288,112C384,117,480,107,576,90.7C672,75,768,53,864,64C960,75,1056,117,1152,117.3C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
        <div class="thread-slide container">
            <div class="thread-name">{{:topic_name}}</div>
        </div>
        <svg class="svg-bottom" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="{{if #index % 2 === 0}}#fff{{else}} #0099ff{{/if}}" fill-opacity="1" d="M0,288L48,256C96,224,192,160,288,133.3C384,107,480,117,576,112C672,107,768,85,864,80C960,75,1056,85,1152,106.7C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>

    </a>


</script>


<script>
    $.ajax({
        url: <?php echo json_encode(htmlspecialchars($thread_url))?>,
        method: 'GET',
        success: function(d){
            var tmpl = $.templates('#thread_viewer');
            $('.featured-thread-wrapper').html(tmpl.render(d));
        }
    });
</script>