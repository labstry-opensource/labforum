<?php
if(!isset($page_title)){
    $page_title = array(
        'title' => 'Title here...',
        'description' => 'Description here...',
    );
}
?>
<div class="title-wrapper py-5">
    <h1 class="h3 font-weight-normal" style="color: #6c6c6c"><?php echo $page_title['title']?></h1>
    <div><?php echo isset($page_title['description']) ? $page_title['description']: ''?></div>
</div>