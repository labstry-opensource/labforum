<?php

include dirname(__FILE__) . '/../../laf-config.php';
include dirname(__FILE__) . '/../modules/header3.php';

?>

<style>
    .board-display-item:nth-child(2n+1){
        background-color: #6c6c6c;
        color: #fff;
    }
</style>

<div class="container">
    <div class="title-wrapper py-5">
        <h1 class="h3 font-weight-normal" style="color: #6c6c6c">版塊管理</h1>
        <div>查看和管理你管理的版塊</div>
    </div>
    <div class="board-display-wrapper">
    </div>

</div>

<script id="board-template" type="text/html">
    <a href="forum-manage-detail.php?id={{:fid}}" class="d-flex py-4 text-decoration-none align-items-center board-display-item px-2">
        <span>{{:fname}} (board id: {{:fid}})</span>
    </a>
</script>

<script>
    var BASE_URL = <?php echo json_encode(BASE_URL)?>;
    $.ajax({
       url: BASE_URL + '/../api/admin/show-managing-board.php',
       method: 'GET',
       success: function(data){
           var tmpl = $.templates('#board-template');
           $('.board-display-wrapper').html(tmpl.render(data));
       }
    });
</script>