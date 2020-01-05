<?php
if (session_id() === '' || ! isset($_SESSION)) {
    // Session might not be started. Check before starting it.
    session_start();
}
if (! isset($home_url))
    $home_url = '/labstry_forum/';

if (! isset($links)) {
    $links = array(
        'title' => array(
            'name' => 'Labstry Forum',
            'link' => $home_url
        ),
        'page_links' => array(
            array(
                "title" => "Labstry FocusSight",
                "link" => "/focussight/index.php"
            ),
            array(
                "title" => "Labstry General",
                "link" => "/forum/viewforum.php"
            )
        )
    );
    if (! isset($_SESSION['username'])) {
        array_push($links['page_links'], array(
            "title" => "Login",
            "link" => "/login.php?target=/forum/index.php"
        ));
        array_push($links['page_links'], array(
            "title" => "Register",
            "link" => "/register.php?target=forum"
        ));
    } else {
        // The user is logged in, thus session is set
        array_push($links['page_links'], array(
            "title" => $_SESSION["username"],
            "link" => "/forum/account/profile.php?id=" . $_SESSION["id"]
        ));
        array_push($links['page_links'], array(
            "title" => "Logout",
            "link" => "/forum/index.php?action=logout"
        ));
    }
}
if( ! isset($optional_paras)){
    $optional_paras = array(
        'opt_in_script' => null,
        'title' => 'Homepage - Labstry Forum'
    );
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="<?php

        echo (isset($meta['viewport'])) ? $meta['viewport'] : 'width=device-width, initial-scale=1.0'?>">
    <meta name="keywords"
          content="<?php

        echo (isset($meta['keywords'])) ? $meta['keywords'] : ''?>">
    <meta name="description"
          content="<?php

        echo (isset($meta['description'])) ? $meta['description'] : ''?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $optional_paras['title']?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrender/1.0.5/jsrender.min.js"></script>
    <script src="<?php

    echo $home_url?>js/toggle.js?<?php

    echo filemtime(dirname(__FILE__) . '/../js/toggle.js')?>"></script>
    <?php
    if($optional_paras['opt_in_script']){
        foreach ($optional_paras['opt_in_script'] as $script) {
            ?><script src="<?php

            echo $script;
            ?>"></script><?php
        }
    }

    ?>

    <!-- css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php

    echo $home_url?>css/stylesheets/main.css?<?php

    echo filemtime(dirname(__FILE__) . '/../css/stylesheets/main.css')?>"/>
    <link rel="stylesheet" href="<?php

    echo $home_url?>css/stylesheets/header.css?<?php

    echo filemtime(dirname(__FILE__) . '/../css/stylesheets/header.css')?>"/>
</head>
<body>
<div class="nav-search-wrapper w-100" style="position:fixed; top: 0; overflow-x: hidden; z-index: 1400">
    <nav class="header-wrapper position-relative overflow-hidden">
        <header class="" style="">
            <div class="container header-el-wrapper">
                <div class="h-100 d-flex align-items-center">
                    <a href="#nav" class="dropdown-btn">
                        <div class="burger-icon">
                            <span class="icon-dash icon-dash-1"></span>
                            <span class="icon-dash icon-dash-2"></span>
                        </div>
                    </a>
                    <a href="/forum/index.php" class="title-name text-decoration-none">
                        <h1 class="h6 mb-0 font-weight-normal">Labstry Forum</h1>
                    </a>
                </div>
                <div class="header-right-btn-wrapper position-absolute" style="">
                    <?php

                    if (! @$_SESSION['username']) {
                        ?>
                        <a class="btn d-inline" style="color: white" href="/login.php">
                            <!-- user inline img -->
                            <svg class="svg-inline--fa fa-user fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                <path fill="#fff" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path>
                            </svg>
                        </a>
                    <?php
                    }
                    ?>
                    <a href="<?php

                    echo $home_url?>/register.php" class="btn d-inline">
                        <svg class="svg-inline--fa fa-user-plus fa-w-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="#fff" d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg>
                    </a>

                    <a href="#" class="search-btn-toggle btn d-inline">
                        <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="#fff" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
                    </a>
                </div>
            </div>
            <ul class="container link-container mb-0">
                <?php

                foreach ($links['page_links'] as $page_link) {
                    ?>
                    <li class="d-block d-md-inline-block color-white p-3 px-lg-5">
                        <a href="<?php

                    echo $page_link['link']?>" style="color:#fff" class="text-decoration-none"><?php

                    echo $page_link['title']?></a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </header>
    </nav>
    <div class="search-toggle-modal">
        <div class="container h-100 search-toggle-container">
            <form action="/forum/api/search.php" class="d-flex rGf align-items-center" method="GET">
                <button type="button" class="btn search-btn-toggle" style="color: white; font-size: 1.5rem; width: 50px">&times;</button>
                <input type="text" class="search-input-text" name="keyword" placeholder="Search Threads/ Forums or Users"/>
                <button type="submit" class="btn search-submit-btn" style="width: 50px; height: 50px" >
                    <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="#fff" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
                </button>
            </form>
        </div>
        <div class="modal-wrapper search-result-outer-container real-vh-100" style="">
            <div class="container py-2">
                <div class="search-result-container"></div>
            </div>
        </div>
    </div>
</div>
<div class="header-placeholder"></div>
<script id="sRBar" type="text/x-jsrender">
    <?php include dirname(__FILE__) . '/../widgets/thread-display/simple-thread-widget.php'; ?>
</script>


<script>
    //On scroll must be inline
    var n = $('nav');
    var currentId = '';
    var previousPosition = '';
    
    $(window).on('scroll', function(){
        handleScrollDown($(window));

    });

    $(window).on('scroll.scrollspy', function(){
        var scrollTop = $(this).scrollTop();
        var pushedel = $('.pushed-el-cards');

        if(scrollTop - previousPosition >=0){
            for(var i = pushedel.length - 1; i>=0 ; i--){
                var el_id = $(pushedel[i]).attr('id');
                if($('#' + el_id).offset().top <= scrollTop){
					currentId = el_id;
					setTitle($('#'+ el_id).data('title'));
					break;
                }
            }
        }else{
            $.each(pushedel, function(item) {
                var el_id = $(this).attr('id');

                if($('#' + el_id).offset().top >= scrollTop){
                    currentId =  el_id;
                    resetTitle();
                    return false;
                }
            });
        }
        previousPosition = $(this).scrollTop();
    });
    
    $('.search-result-outer-container').on('scroll', function() {
        var r = $('.search-result-outer-container');
        handleScrollDown(r);
    });
    function handleScrollDown(el){
        var scrollTop = el.scrollTop();
        var h = $('.header-el-wrapper');
        var n = $('nav');
        var s = $('.search-toggle-modal');
        if(window.matchMedia('(min-width : 768px)').matches){return;}
        if(scrollTop > 0 && scrollTop < 250){
            h.height(300 - scrollTop);
            n.height(300 - scrollTop);
            s.css('top', 250 - scrollTop);
            el.height($(window).innerHeight());
        }
        if(scrollTop === 0){
            el.height($(window).innerHeight());
            h.css('height', '');
            n.css('height', '');
            s.css('top', 250);
        }
        if(scrollTop >= 250){
            h.height(50);
            n.height(50);
            s.css('top', 0);
            el.height($(window).innerHeight() - 50);
        }
    }
   
</script>
