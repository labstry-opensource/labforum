<?php
if(!isset($forumlist)){
    $forumlist = array(
        array(
            'title' => 'Labstry General',
            'href' => '#',
        ),
        array(
            'title' => 'New Functions',
            'href' => '',
        )
    );
}
?>

<div class="row forum-push-card-item" data-title="Forum Lists">
    <?php foreach($forumlist as $f_list){?>
        <a class="col-12 col-md-6 d-block" href="<?php echo $f_list['href']?>"><?php echo $f_list['title']?></a>
    <?php } ?>
</div>
