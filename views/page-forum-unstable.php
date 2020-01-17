<?php

if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Find topics that you are interested on.',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}

if (! isset($opt_in_script)) {
    $opt_in_script = array(
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.7/jquery.timeago.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js',
    );
}

$essentials = new Essentials($meta);
$essentials->setTitle('Forum - Labstry Forum');
$essentials->getHeader();

?>


<div class="container">
    <div class="position-relative">
        <div class="embed-responsive embed-responsive-16by6">
            <div class="embed-responsive-item" style="
                    background-image: url(<?php echo BASE_URL?>/images/system/forum-placeholder-banner.png);
                    background-position: center center;
                    background-size: cover;
                    background-repeat: no-repeat;">
                <div class="position-absolute d-flex align-items-center px-5" style="bottom: 0; height: 100px;left:0; right:0">
                    <h1 class="text-white forum-name">Loading...</h1>
                </div>
            </div>

        </div>

    </div>

</div>


<?php

$essentials->getFooter();

?>