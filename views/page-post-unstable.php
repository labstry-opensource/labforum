<?php

if (! isset($meta)) {
    $meta = array(
        'keywords' => 'Labstry, 論壇, AI, Android ROM, 生活方式, 分享, 討論, 電腦, 程式開發',
        'description' => 'Post Threads',
        'viewport' => 'width=device-width, initial-scale=1.0'
    );
}
$opt_in_script = array(
    'https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js',
    'https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js',
    'https://unpkg.com/quill-emoji@0.1.7/dist/quill-emoji.js',
);
$opt_in_css = array(
    'https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css',
    'https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap',
    'https://unpkg.com/quill-emoji@0.1.7/dist/quill-emoji.css',
);

$essentials = new Essentials($meta, '', $opt_in_script, '', $opt_in_css);
if(isset($_GET['id'])){
    $mode = 'edit';
    $essentials->setTitle('Edit Thread - Labstry Forum');
}else{
    $mode = 'add';
    $essentials->setTitle('Post New Thread - Labstry Forum');
}
$essentials->getHeader();
?>
<form action="<?php echo BASE_URL . '/api/post-thread.php'?>" method="POST" class="thread-post-edit">
    <div class="title-holder" style="min-height: 300px;">
        <div class="container  position-relative">
            <div>
                <button class="btn btn-light btn-action mx-2">
                    <svg class="d-inline" width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M512 1536h768v-384h-768v384zm896 0h128v-896q0-14-10-38.5t-20-34.5l-281-281q-10-10-34-20t-39-10v416q0 40-28 68t-68 28h-576q-40 0-68-28t-28-68v-416h-128v1280h128v-416q0-40 28-68t68-28h832q40 0 68 28t28 68v416zm-384-928v-320q0-13-9.5-22.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 22.5v320q0 13 9.5 22.5t22.5 9.5h192q13 0 22.5-9.5t9.5-22.5zm640 32v928q0 40-28 68t-68 28h-1344q-40 0-68-28t-28-68v-1344q0-40 28-68t68-28h928q40 0 88 20t76 48l280 280q28 28 48 76t20 88z" fill="#0088ff"/></svg>
                    <span class="d-inline px-3">Save</span>
                </button>
                <button class="btn btn-light btn-action mx-2" type="button" data-toggle="modal" data-target="#threadSettingsModal">
                    <svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1152 896q0-106-75-181t-181-75-181 75-75 181 75 181 181 75 181-75 75-181zm512-109v222q0 12-8 23t-20 13l-185 28q-19 54-39 91 35 50 107 138 10 12 10 25t-9 23q-27 37-99 108t-94 71q-12 0-26-9l-138-108q-44 23-91 38-16 136-29 186-7 28-36 28h-222q-14 0-24.5-8.5t-11.5-21.5l-28-184q-49-16-90-37l-141 107q-10 9-25 9-14 0-25-11-126-114-165-168-7-10-7-23 0-12 8-23 15-21 51-66.5t54-70.5q-27-50-41-99l-183-27q-13-2-21-12.5t-8-23.5v-222q0-12 8-23t19-13l186-28q14-46 39-92-40-57-107-138-10-12-10-24 0-10 9-23 26-36 98.5-107.5t94.5-71.5q13 0 26 10l138 107q44-23 91-38 16-136 29-186 7-28 36-28h222q14 0 24.5 8.5t11.5 21.5l28 184q49 16 90 37l142-107q9-9 24-9 13 0 25 10 129 119 165 170 7 8 7 22 0 12-8 23-15 21-51 66.5t-54 70.5q26 50 41 98l183 28q13 2 21 12.5t8 23.5z" fill="#0088ff"/></svg>
                    <span class="d-inline px-3">Settings</span>
                </button>
            </div>
        </div>
        <div class="container py-5">
            <div class="row align-items-center">
                <select name="forum" class="custom-select fid-select d-none col-12 col-md-4" id="">

                </select>
                <div class="col-12 col-md-8 mb-3">
                    <input type="text" name="thread_topic" placeholder="輸入主題" class="form-control thread-topic thread_topic text-white">
                    <div class="thread_topic-invalid-feedback invalid-feedback bg-light"></div>
                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <?php include LAF_PATH . '/modules/thread-composer.php'?>
        <noscript>
            <textarea name="thread_content" class="form-control thread-content" placeholder="Happy foruming..."></textarea>
        </noscript>
    </div>
    <textarea name="thread_content" class="form-control thread-content d-none" placeholder="Happy foruming..."></textarea>
    <div class="modal fade" id="threadSettingsModal" tabindex="-1" role="dialog" aria-labelledby="Thread Settings..." aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 25px; overflow: hidden">
                <div class="modal-header text-light align-items-center" style="background-color: #4BD2B0;">
                    <h5 class="modal-title" id="thread-settings">Thread Settings</h5>
                    <button type="button" class="btn btn-light btn-action ml-auto" style="padding: 0;
                    border-radius: 50%; font-size: 1.5rem;width: 42px; height: 42px" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="settings-list py-2">
                        <label for="draft" class="d-flex align-items-center">
                            <span class="">草稿模式:</span>
                            <div class="ml-auto custom-checkbox">
                                <input type="checkbox" id="draft" name="draft" class="d-none">
                                <div class="right-toggle"></div>
                            </div>
                        </label>
                    </div>
                    <div class="settings-list py-2">
                        <label for="readPermission" class="d-flex align-items-center">
                            <span>閱讀權限:</span>
                            <input type="text" class="form-control ml-auto" style="max-width: 4em" id="readPermission" name="read_permission" value="0" />
                        </label>
                        <div class="text-danger read-permission-invalid-feedback"></div>
                    </div>
                    <div class="settings-list py-3">
                        <label for="introduction">Introduction</label>
                        <textarea class="form-control" id="introduction" name="introduction" style="min-height: 200px"></textarea>
                        <div class="text-danger read-permission-invalid-feedback"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="Upload Files" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Uploading files</h5>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="Thread Posted" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content overflow-hidden" style="border-radius: 25px;">
            <div class="modal-body" style="background-color:#4BD2B0; color: #fff">
                <div class="h2 py-3">Thread posted...</div>
                <span>Redirecting to your thread.</span>
            </div>
        </div>
    </div>
</div>

<script id="forum-options" type="text/html">
    <option value="{{:forum_id}}">{{:forum_name}}</option>
</script>

<script>
    var modeTitle = <?php echo json_encode(($mode === 'edit') ? 'Edit Thread' : 'Post New Thread') ?>;
    var forum_engine = <?php echo json_encode(BASE_URL . '/api/forum-engine.php'); ?>;
    var BASE_URL = <?php echo json_encode(BASE_URL ); ?>;
    var thread_page = BASE_URL + '/thread.php';

    setTitle(modeTitle);

    //Get forums
    $.ajax({
        url: <?php echo json_encode(BASE_URL . '/api/forum-engine.php')?>,
        method: 'GET',
        success: function(data) {
            var forum_arr = [];
            for (var key in data) {
                for (var forum_key in data[key]['forum']) {
                    var forum_val = {
                        forum_id: data[key]['forum'][forum_key]['fid'],
                        forum_name: data[key]['forum'][forum_key]['fname'],
                    }
                    forum_arr.push(forum_val);
                }
            }
            var tmpl = $.templates('#forum-options');
            $('.fid-select').html(tmpl.render(forum_arr));
            initCustomSelect();
        }
    });

    function initCustomSelect(){

        $('.custom-select').wrap('<div class="select col-12 col-md-4 mb-3"></div>').after('<div class="form-control forum select-styled">Select forum</div>' +
            '<ul class="select-list position-absolute list-group list-group-flush overflow-hidden"></ul>' +
            '<div class="forum-invalid-feedback invalid-feedback bg-light"></div>');

        // Iterate over each select element
        var optionValues = [];
        $('.custom-select option').each(function (index) {
            if(index === 0){
                $('.select-styled').text($(this).html());
            }
            option_item = {value: $(this).val(), text: $(this).html()}
            optionValues.push(option_item);
        });

        for(var i = 0; i < optionValues.length; i++){
            var list_li = '<li class="list-group-item" data-value="'+ optionValues[i]['value']+'">' + optionValues[i]['text'] + '</li>';
            $('.select-list').append(list_li);
        }

        $('.select-styled').on('click', function(){
           $(this).siblings('.select-list').toggleClass('active');
        });

        $('.select-list li').on('click', function(){
            $('.custom-select').val($(this).data('value'));
            $(this).parent().removeClass('active');
            $(this).parent().siblings('.select-styled').text($(this).text());
        });
    }

    $('.thread-post-edit').on('submit', function (e) {
        e.preventDefault();
        $('.is-invalid').removeClass('is-invalid');
        $('.thread-content').val(editor.getHtml());
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(data){
                if(data.error){
                    var error = data.error;
                    for(var key in error){
                        $('.' + key+ '-invalid-feedback').text(error[key]);
                        $('.' + key).addClass('is-invalid');
                    }
                }else if(data.success){
                    $('#successModal').modal({backdrop: 'static', keyboard: false});
                    setTimeout(function(){
                        window.location = thread_page + '?id=' + data.success.thread_id;
                    }, 2000);
                }
            }
        });
    });

    $('.thread-topic').on('keyup', function(){
        setTitle($('.thread-topic').val());
    });


</script>


