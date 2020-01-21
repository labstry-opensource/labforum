<div data-title="" id="forum-threads-wrapper" class="pushed-el-cards">
    <div class="row no-gutters featured-thread-wrapper">
        <?php include dirname(__FILE__)."/../widgets/loading-circle.php" ?>
    </div>
</div>

<div class="d-flex justify-content-center py-4">
    <a href="#" class="btn btn-primary next-btn" style="background-color: #00c5ff;">Load Next 10 Threads...</a>


</div>
<script id="thread_viewer" type="text/x-jsrender">
    <?php include dirname(__FILE__) . '/../widgets/thread-display/detail-thread-widget.php'; ?>
</script>
