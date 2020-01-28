<?php
include_once dirname(__FILE__) . '/../../laf-config.php';
include_once dirname(__FILE__ ) . '/../../classes/Essentials.php';

if(!isset($right)){
    $essential = new Essentials('');
    $essential->imposeRestrictAccess(90, 0);
    die;
}

$page_title = array(
    'title' => '預留用戶名',
    'description' => '管理用戶特權：防止用戶搶註帳戶',
);

include dirname(__FILE__) . '/../modules/header3.php';

?>

<div class="container">
    <?php include dirname(__FILE__ ) . "/../modules/title-show.php"?>
    <div class="reserved-username-wrapper">
        <form method="POST" class="username-reserve-form row no-gutters" action="<?php echo BASE_URL ?>/../api/admin/reserve-username.php">
                <div class="col-12 col-md-10 my-2">
                    <input type="text" class="form-control reserve-username" autocomplete="off" name="reserve_username" />
                    <div class="invalid-feedback username-invalid-feedback"></div>
                    <div class="valid-feedback username-valid-feedback"></div>
                </div>
                <input type="hidden" name="action" value="useradd"/>
                <div class="col-12 col-md-2 my-2">
                    <button type="submit" class="btn btn-success" name="submit">Reserve</button>
                </div>

        </form>
        <div class="no-gutters py-5 reserved-username-container"></div>
    </div>
</div>

<script class="reserve-username-module" type="text/x-template">
    <div class="row py-5">
        <div class="col-12 col-md-8">
            {{:reserved_username}}
        </div>
        <div class="col-12 col-md-4">
            <form method="POST" class="delete-form-post"  action="<?php echo BASE_URL ?>/../api/admin/reserve-username.php">
                <input type="hidden" name="action" value="userdelete"/>
                <input type="hidden" name="reserve_username" value="{{:reserved_username}}"/>
                <button class="btn btn-danger delete-btn" type="submit"><i class="fas fa-trash-alt"></i></button>
            </form>
        </div>
    </div>

</script>

<script>
    loadReserveUsername();
    function loadReserveUsername(){
        $.ajax({
            url: <?php echo json_encode(BASE_URL . '/../api/admin/my-reserved-username.php') ?>,
            method: "POST",
            success: function(data){
                var data = data.username;
                var tmpl = $.templates('.reserve-username-module');
                $('.reserved-username-container').html(tmpl.render(data));
            }
        });
    }

    $(document).on('submit', '.delete-form-post', function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(){
                loadReserveUsername();
            }
        });
    });

    $('.username-reserve-form').on('submit', function(e){
        e.preventDefault();
        $('.reserve-username').removeClass('is-invalid');
        $('.username-invalid-feedback').text();
        $('.username-valid-feedback').text();
        $.ajax({
           url: $(this).attr('action'),
           method: $(this).attr('method'),
           data: $(this).serialize(),
           success: function(data){
               if(data.error){
                   $('.username-invalid-feedback').text(data.error);
                   $('.reserve-username').addClass('is-invalid');
               }else if(data.success){
                   $('.username-valid-feedback').text(data.success);
                   $('.reserve-username').addClass('is-valid');
                   loadReserveUsername();
               }
           }
        });
    })
</script>