<?php

if(!defined('LAF_PATH')) {
    die('Direct access not permitted');
}

if(!isset($right)){
    $essential = new Essentials('');
    $essential->imposeRestrictAccess(0, 0);
    die;
}

include dirname(__FILE__) . '/../modules/header.php';

$page_title = array(
    'title' => 'Roles Management',
);
?>

<div class="container">
    <?php include dirname(__FILE__ ) . "/../modules/title-show.php"?>
    <button class="btn btn-success">&plus;</button>
    <div class="roles-show-wrapper py-2 row"></div>
</div>

<script type="text/html" class="role-display-template">
    <a href="role-manage-details.php?id={{:role_id}}" class="text-decoration-none col-12  py-5 my-2" style="border: 3px solid {{:tagcolor}}; border-radius: 24px;">
        <h2 class="mb-0 h3 font-weight-normal">{{:role_name}}</h2>
        <div>Right: <b>{{:rights}}</b></div>
    </a>
</script>

<script>
    getRoles();
    function getRoles(){
        $.ajax({
            url: <?php echo json_encode(BASE_URL . '/../api/admin/role-listing.php')?>,
            method: "GET",
            success: function(data){
                var tmpl = $.templates('.role-display-template');
                $('.roles-show-wrapper').html(tmpl.render(data));
            }
        });
    }
</script>

<?php
include_once dirname(__FILE__) . '/../modules/footer.php';