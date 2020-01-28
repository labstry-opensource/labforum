<?php
include_once dirname(__FILE__) . '/../../laf-config.php';
include_once dirname(__FILE__ ) . '/../../classes/Essentials.php';

if(!isset($right)){
    $essential = new Essentials('');
    $essential->imposeRestrictAccess(0, 90);
    die;
}

$page_title = array(
    'title' => 'Friend finder',
);

include dirname(__FILE__) . '/../modules/header3.php';
?>
<div class="container">
    <?php include dirname(__FILE__ ) . "/../modules/title-show.php"?>
    <form class='friend-finder' action='<?php echo BASE_URL.'/..'?>/api/admin/user-search.php' method="POST" autocomplete="off" style=''>
        <div class="row px-2">
            <input type="text" name="username" class="form-control col-12 col-md-10" >
            <input type="submit" name="submit" value="搜尋" class="btn btn-call-to-action col-12 col-md-2">
        </div>
    </form>
    <div class="search-result d-none">
        <?php include_once @$_SERVER["DOCUMENT_ROOT"]."/forum/widgets/loading-circle.php"?>
    </div>
</div>

<script id="usergen-template" type="text/html">
    <div class="no-gutters friend-listing">
        <div class="user-listing">
            <div class="row no-gutters align-items-center">
                <div class="col-12 col-md-7">
                    <div class="username-row">
                        {{:username}} (uid: {{:id}})
                    </div>
                    <div class="email">
                        {{:email}}
                    </div>
                </div>
                <div class="col-12 col-md-5 manage-link">
                    <a href="user-profile-admin-view.php?id={{:id}}" class="px-3">Manage</a>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
    $('.friend-finder').on('submit', function(e){
        $('.search-result').removeClass('d-none');
        e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            method : $(this).attr('method'),
            data: $(this).serialize(),
            success: function(data){
                var tmpl = $.templates('#usergen-template');
                $('.search-result').html(tmpl.render(data));
            }
        });
    })
</script>
