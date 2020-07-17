<?php

if(!defined('LAF_PATH')) {
    die('Direct access not permitted');
}


if(!isset($right)){
    $essential = new Essentials('');
    $essential->imposeRestrictAccess(0, 90);
    die;
}

$page_title = array(
    'title' => '版塊管理',
    'description' => '查看和管理你管理的版塊',
);

include dirname(__FILE__) . '/../modules/header.php';



?>

<style>
    .board-display-item:nth-child(2n+1){
        background-color: #6c6c6c;
        color: #fff;
    }
</style>

<div class="container">
    <?php include dirname(__FILE__ ) . "/../modules/title-show.php"?>
    <div class="board-display-wrapper">
    </div>

</div>

<script id="board-template" type="text/html">
    <a href="forum-manage.php?id={{:fid}}" class="d-flex py-4 text-decoration-none align-items-center board-display-item px-2">
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

<?php
include_once dirname(__FILE__) . '/../modules/footer.php';