
<?php

if(!isset($is_search_enabled)) $is_search_enabled = true;

if(!isset($header_title))
    $header_link  = array(
        "title" => "Labstry Forum",
        "link" => "/forum/index.php",
    );

if(!isset($data["links"])){
    $data["links"] = array(
        array(
            "title" => "Labstry FocusSight",
            "link" => "/focussight/index.php",
            "top_level" => "true",
        ),
        array(
            "title" => "Labstry General",
            "link" => "/forum/viewforum.php",
            "top_level" => "true",
        ),
    );
    if(!@$_SESSION){
        array_push($data["links"],
            array(
                "title" => "Login",
                "link" => "/login.php?target=/forum/index.php",
                "top_level" => "true",
            )
        );
        array_push($data["links"],
            array(
                "title" => "Register",
                "link" => "/register.php?target=forum",
                "top_level" => "true",
            )
        );
    }else{
        array_push($data["links"],
            array(
                "title" => @$_SESSION["username"],
                "link" => "/forum/account/profile.php?id=".@$_SESSION["id"],
                "top_level" => "true",
            ),
            array(
                "title" => "Logout",
                "link" => "index.php?action=logout",
                "top_level" => "true",
            )
        );
    }
}

if(!isset($search_target)){
    $search_target = array(
        "target_action" => "search.php?action=search",
        "method" => "GET",
    );
}

?>

<div class="header-wrapper show-when-loaded">
    <div class="link-wrapper">
        <div class="hamburger-layer">
            <button type="button" class="btn dropdown-btn">
                <div class="burger-icon" tabindex="-1">
                    <span class="icon-dash icon-dash-1"></span>
                    <span class="icon-dash icon-dash-2"></span>
                </div>
            </button>
            <div class="hamburger-title t-left">
                <a href="<?php echo $header_link["link"]?>"><?php echo $header_link["title"];?></a>
            </div>
        </div>
        <div class="under-hamburger-layer" style="">
            <div class="fake-search d-desk-none">
                <!-- mobile instance -->
                <form class="search-bar" method="<?php echo $search_target["method"]?>" action="<?php echo $search_target["target_action"] ?>">
                    <div class="d-block" style="width: 100%; position: relative">
                        <button type="button" class="header-search-close-btn">&times;</button>
                        <input type="text" name="keywords" class="search-input" autocomplete="off"
                               placeholder="Search for threads/forum contents..."
                               aria-label="Search for threads/forum contents"
                        >
                        <button type="button" class="search-submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="menu-relative-holder" style="position: relative">
                <div style="position:static">
                    <div class="header-link-wrapper d-tab-flex d-desk-flex">
                        <div class="all-primary-link-wrapper d-tab-flex d-desk-flex">
                            <?php foreach($data["links"] as $link){
                                if(!@$link["top_level"]) continue; ?>
                                <div class="link-horizontal-item">
                                    <a href="<?php echo $link["link"]?>"><?php echo $link["title"]?></a>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if($is_search_enabled){?>
                            <button type="button" data-toggle="collapse"
                                    class="btn transparent-btn search-div
                                header-menu-btn search-div-btn d-none d-desk-inline-block">
                                <i class="fas fa-search"></i> <span class="search-hint">Search <span class="d-inline d-desk-none">and more...</span></span>
                            </button>
                        <?php } ?>
                        <div class="general-header-content-wrapper">
                            <?php foreach($data["links"] as $link){
                                if(@$link["top_level"]) continue; ?>
                                <a class="link-horizontal-item d-inline-block">
                                    <?php echo $link["title"]?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-result-provider d-desk-none"></div>

        </div>
    </div>
    <div class="fake-search-desktop-instance d-none d-desk-block">
        <form class="search-bar" method="<?php echo $search_target["method"]?>" action="<?php echo $search_target["target_action"] ?>">
            <div class="d-block" style="width: 100%; position: relative">
                <button type="button" class="header-search-close-btn">&times;</button>
                <input type="text" name="keywords" class="search-input" autocomplete="off"
                       placeholder="Search for threads/forum contents..."
                       aria-label="Search for threads/forum contents"
                >
                <button type="button" class="search-submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <div class="search-result-provider d-none d-desk-block"></div>
    </div>
</div>
<div id="toggleSearchOverlay" class="toggle-search-overlay"></div>


<!--<script src="js/toggle.js?v=<?php echo filemtime("js/toggle.js")?>"></script>-->

<script>
    var isSearchToggled = false;
    var mobileWidth = 767;

    validateSearchBar();


    $('.search-bar').on('submit', function(e){
        e.preventDefault();
        $('.fake-search').addClass('search-result-active');
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            xhrFields: {
                withCredentials: true,
            },
            success: function (data) {
                $('.search-result-provider').html(data);
            }
        })
    });
    $('.search-bar-tab').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            xhrFields: {
                withCredentials: true,
            },
            success: function (data) {
                $('.search-result-provider').html(data);
            }
        })
    });

    $(window).on('resize.checksearchBarLayout',  function () {
        validateSearchBar();
    });
    function  validateSearchBar() {
        if($(document).width() < mobileWidth){
        }
    }


</script>
