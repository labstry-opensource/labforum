<?php

if(!defined('LAF_PATH')) {
    die('Direct access not permitted');
}


$page_title = array(
    'title' => $forum_arr['fname'],
    'description' => '查看和管理你管理的版塊',
);


include dirname(__FILE__) . '/../modules/header3.php';
?>
<style>
    .ql-container {
        font-size: 1rem;
    }
</style>
<div class="container">
    <form class="moderator-edit" action="<?php echo BASE_ROOT_API_URL . '/admin/edit-forum.php?id=' . $forum_arr['fid'];?>" method="POST" enctype="multipart/form-data">
        <div class="pb-4">
            <button type="button" class="btn btn-primary btn-save-prompt-password" style="border-radius: 24px">Save</button>
        </div>

        <div class="form-group">
            Cover Image:
            <label for="forumHeroImage" class="btn btn-light ml-2">
                Select an image
            </label>
            <div class="embed-responsive embed-responsive-16by6">
                <div class="embed-responsive-item hero-image-display"
                     style="background-image: url(<?php echo BASE_ROOT_URL?>/images/system/forum-placeholder-banner.png);
                         background-position: center center;
                         background-size: cover;
                         background-repeat: no-repeat;">
                    <div class="py-2 position-absolute d-none d-md-block" style="bottom: 2rem; left: 2rem;">
                        <h1 class="forum-name forum-text font-weight-normal h3 d-inline pr-2"><?php echo $forum_arr['fname'];?></h1>
                        <span class="d-inline forum-text">(fid: <?php echo $forum_arr['fid'];?>)</span>
                    </div>
                </div>
            </div>
            <div class="py-2 d-block d-md-none" style="bottom: 2rem; left: 2rem;">
                <h1 class="forum-name forum-text font-weight-normal h4 d-inline pr-2"><?php echo $forum_arr['fname'];?></h1>
                <span class="d-inline forum-text">(fid: <?php echo $forum_arr['fid'];?>)</span>
            </div>

            <input type="file" class="d-none" id="forumHeroImage" name="forum-hero-image" accept="image/x-png,image/gif,image/jpeg">
            <div class="invalid-feedback forum-hero-image-invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label class="rules-label" for="rules-editor">Forum Rules: </label>
            <?php
                $text_data = $forum_arr['rules'];
                include LAF_ROOT_PATH . '/admin/modules/module-wysiwyg.php';
            ?>
            <textarea class="d-none" id="forum_rules" name="forum_rules"
            style="min-height: 300px;"></textarea>

        </div>
        <div class="form-group">
            <label for="readPermission">Read permission</label>
            <input class="form-control" id="readPermission" type="number" min="0" max="255" value="<?php echo $forum_arr['rights'];?>"/>
        </div>
        <div class="form-group">
            <div class="d-flex align-items-center">
                <div class="moderator-tag">Moderators</div>
                <button type="button" data-toggle="modal" data-target="#modChooser" class="btn btn-call-to-action ml-auto" style="border-radius: 24px">Add Moderators</button>
            </div>
            <div class="mod-show" style="pointer-events: none; min-height: 200px;">
                <div class="d-flex justify-content-center align-items-center mod-hint text-secondary" style="height: 200px">
                    Loading moderators...
                </div>
            </div>
        </div>
        <div class="modal fade" id="passwordModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="Enter your password" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 24px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter your password</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="password" class="form-control password" autocomplete="off" name="password" placeholder="Password...">
                            <div class="invalid-feedback password-invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control repassword" autocomplete="off"  name="repassword" placeholder="Enter password again...">
                            <div class="invalid-feedback repassword-invalid-feedback"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-round">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include LAF_ROOT_PATH . '/admin/modules/module-select-user.php'?>

<script id="mod-module" type="text/html">
    <?php include LAF_ROOT_PATH . '/admin/widget/widget-user-display.php' ?>
</script>

<script>
    //Events
    $('#forumHeroImage').on('change', function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.hero-image-display').css('background-image', 'url(' + e.target.result + ')');
                loadHeroInverts();
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    //Simulate label
    $('.rules-label').on('click', function(){
        var target = $('#' + $(this).attr('for')).children('.ql-editor');
        target.focus();
    });

    $('.btn-save-prompt-password').on('click', function(){
        $('.is-invalid').removeClass('is-invalid');
        $('#passwordModal').modal('toggle');
    })

    $('.moderator-edit').on('submit', function(e){
        e.preventDefault();
        submitForumChanges();
    });

    function submitForumChanges(){
        $.ajax({
            url: $('.moderator-edit').attr('action'),
            method: $('.moderator-edit').attr('method'),
            data: $('.moderator-edit').serialize(),
            success: function(data){
                if(data.error){
                    for(key in data.error){
                        $('.' + key).addClass('is-invalid');
                        $('.' + key + '-invalid-feedback').html(data.error[key]);
                    }
                }

            }
        });
    }
    //functions
    function getModerators(){
        $.ajax({
           url:  base_dir + '/api/forum-engine.php?fid=' + fid,
           method: 'GET',
           success: function(data){
               if(data.moderators.length !== 0){
                   for(key in data.moderators){
                       data.moderators[key].type = 'show';
                   }
                   var tmpl = $.templates('#mod-module');
                   $('.mod-show').html(tmpl.render(data.moderators));
               }else{
                   $('.mod-hint').html('No moderators in this forum :|');
               }
           }
        });
    }

    function loadHeroInverts(){
        var hero_img = $('.hero-image-display').css('background-image').replace('url(','').replace(')','').replace(/\"/gi, "");
        var image = new Image;
        image.src = hero_img;
        image.onload = function() {
            var colorThief = new ColorThief();
            var dominantColor = colorThief.getColor(image);
            $('.forum-text').css('color', (invert(dominantColor, true)));

        }
    }

    loadHeroInverts();
    getModerators();

</script>


