<?php

if(!isset($top_link)){
    $top_link = array(
        array(
            'src' =>  BASE_URL .'/../assets/product_logo.svg',
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
            'link' => BASE_URL . '/reserve-username.php',
        ),
        array(
            'title' => '用戶管理',
            'link' => BASE_URL . '/user-manage.php',
        ),
        array(
            'title' => '版塊管理',
            'link' => BASE_URL . '/forum.php',
        ),
        array(
            'title' => 'Roles Management',
            'link' => BASE_URL . '/user-roles-manage.php',
        ),

    );
}
if(!isset($opt_in_script)){
    $opt_in_script = array();
}

if(!isset($opt_in_css)){
    $opt_in_css = array();
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
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo BASE_URL . '/../css/stylesheets/admin.css'?>">
    <link rel="stylesheet" href="https://unpkg.com/@simonwep/pickr@1.5.1/dist/themes/nano.min.css">
    <?php foreach ($opt_in_css as $css){ ?>
        <link rel="stylesheet" href="<?php echo $css?>">
    <?php } ?>

    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrender/1.0.5/jsrender.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/fontawesome.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/solid.min.js"></script>
    <script src="https://unpkg.com/@simonwep/pickr@1.5.1/dist/pickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script src="https://unpkg.com/invert-color@2.0.0/lib/invert.min.js"></script>
    <?php foreach ($opt_in_script as $script){ ?>
        <script src="<?php echo $script;?>"></script>
    <?php } ?>


    <title>Administration Panel - Labstry Forum </title>
</head>
<style>
    .list-group-item-action{
        background-color: transparent;
        color: white;
    }
</style>
<body>
<div style="background-color: #377796;">
    <div class="admin-manage-titlecard d-flex align-items-center" style="z-index:2">
        <button type="button" class="btn menu-btn">
            <i class="fas fa-bars text-white"></i>
        </button>
        <?php foreach($top_link as $link_item){?>
            <a class="header-link" href="<?php echo $link_item['link']?>">
                <?php if(!empty($link_item['title'])){ echo $link_item['title']; }
                      else if(!empty($link_item['src'])){ ?>
                          <img class="svg" src="<?php echo $link_item['src']?>" alt=""/>
                <?php }?>
            </a>
        <?php } ?>
    </div>
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
    $('img.svg').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        $.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });
</script>
<div style="height:  50px"></div>