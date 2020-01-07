<?php

if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Find topics that you are interested on.',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}

$essentials = new Essentials($meta);
$essentials->setTitle('Forum Listings - Labstry Forum');
$essentials->getHeader();

?>
    <div class="standard-wrapper">
        <section>
            <div class="forum-listing-title d-flex  align-items-center" style="background-color: #add8e6; min-height: 300px; ">
                <div class="container">
                    <div><h1>Forum Listings</h1></div>
                    "Find topics that you are interested on"
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#add8e6" fill-opacity="1" d="M0,64L34.3,96C68.6,128,137,192,206,186.7C274.3,181,343,107,411,90.7C480,75,549,117,617,133.3C685.7,149,754,139,823,138.7C891.4,139,960,149,1029,138.7C1097.1,128,1166,96,1234,74.7C1302.9,53,1371,43,1406,37.3L1440,32L1440,0L1405.7,0C1371.4,0,1303,0,1234,0C1165.7,0,1097,0,1029,0C960,0,891,0,823,0C754.3,0,686,0,617,0C548.6,0,480,0,411,0C342.9,0,274,0,206,0C137.1,0,69,0,34,0L0,0Z"></path>
            </svg>
        </section>
        <?php include dirname(__FILE__). "/../modules/forum-display.php" ?>
    </div>
<?php
$essentials->getFooter();
