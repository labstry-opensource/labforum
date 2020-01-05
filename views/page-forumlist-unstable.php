<?php

if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Select a topic area that fits you.',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}

$essentials = new Essentials($meta);
$essentials->setTitle('Forum Listings - Labstry Forum');
$essentials->getHeader();

?>

<div class="container">

</div>


<?php

$essentials->getFooter();
