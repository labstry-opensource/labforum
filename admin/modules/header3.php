<?php
if(!isset($top_link)){
    $top_link = array(
        array(
            'title' => 'Labfroum Homepage',
            'link' => BASE_URL . '/../index.php',
        ),
        array(
            'title' => '論壇管理主頁',
            'link' => BASE_URL . '/index.php',
        )
    );
}

if(!isset($link)){
    $link = array(
        array(
            'title' => '預留用戶名',
            'link' => BASE_URL . '/reserveuname.php',
        ),
        array(
            'title' => '用戶管理',
            'link' => BASE_URL . '/user-manage.php',
        ),
        array(
            'title' => '版塊管理',
            'link' => BASE_URL . '/forum-manage.php',
        ),

    );
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL . '/../css/stylesheets/admin.css'?>">

    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrender/1.0.5/jsrender.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/fontawesome.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/solid.min.js"></script>

    <title>Administration Panel - Labstry Forum </title>
</head>
<style>
    .list-group-item-action{
        background-color: transparent;
        color: white;
    }
</style>
<body>
<div class="admin-manage-titlecard d-flex position-fixed align-items-center">
    <button type="button" class="btn menu-btn">
        <i class="fas fa-bars text-white"></i>
    </button>
    <?php foreach($top_link as $link_item){?>
        <a class="header-link" href="<?php echo $link_item['link']?>"><?php echo $link_item['title']?></a>
    <?php } ?>
</div>
<div class="sidebar" style="  position: fixed; top: 50px; bottom: 0">
    <div class="list-group list-group-flush">
        <?php foreach ($link as $link_item) { ?>
            <a class="list-group-item list-group-item-action" href="<?php echo $link_item['link']?>">
                <?php echo $link_item['title']?>
            </a>
        <?php }?>
    </div>
</div>
<script>
    $(document).on('click', '.menu-btn', function(e){
        $('.sidebar').toggleClass('sidebar-active');
    });
</script>
<div style="height:  50px"></div>