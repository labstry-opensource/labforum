<?php
if(!defined('LAF_PATH')) {
    die('Direct access not permitted');
}

if(!isset($_SESSION)) session_start();

include dirname(__FILE__) . '/../modules/header3.php';

$token = isset($_SESSION['operation_token']) ? $_SESSION['operation_token'] : "";

?>

<div class="container">
    <div class="form-group pb-5">
        <button class="operation-btn btn btn-success" data-action="promote">提升</button>
        <button class="operation-btn btn btn-danger" data-action="demote">下沉</button>
        <button class="operation-btn btn btn-danger" data-action="hiddeni">屏蔽</button>
        <button class="operation-btn btn btn-light" data-action="show">解除屏蔽</button>
        <button class="operation-btn btn btn-warning" data-action="delete" disabled>標記為刪除</button>
        <button class="operation-btn btn btn-warning" data-action="warning" disabled>警告</button>
        <button class="operation-btn btn btn-primary" data-action="award" disabled>獎勵</button>
    </div>
    <form class="thread-property-form" method="post"
            action="<?php echo BASE_URL . '/../api/admin/thread-operation.php'?>">
        <input type="hidden" value="property_change" name="action">
        <div class="form-group">
            <button class="btn btn-success property-save mx-2" style="border-radius: 24px">Save</button>
            <a href="<?php echo BASE_ROOT_URL . '/post.php?id=' . $thread_arr['topic_id'] ?>" class="btn btn-primary mx-2" style="border-radius: 24px">
                <i class="fa fa-edit"></i>
                Edit
            </a>
        </div>
        <div class="form-group">

            <label for="fid">帖子內容</label>
            <div class="row">
                <div class="col-12 col-md-4">
                    <select name="fid" id="fid" class="form-control">
                        <?php foreach ($forum_arr as $forum_item) { ?>
                            <option value="<?php echo $forum_item['fid']?>"
                            <?php echo ($thread_arr['fid'] === $forum_item['fid']) ? 'selected': ''?>><?php echo $forum_item['fname']?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback fid-invalid-feedback"></div>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" name="thread_name" class="form-control" value="<?php echo $thread_arr['topic_name']?>" disabled>
                    <input type="hidden" name="thread_id" value="<?php echo $thread_arr['topic_id']?>">
                </div>
            </div>

        </div>
        <div class="form-group pt-2">
            設置高亮：
            <input type="text" class="highlight btn pickr" style="max-width: 150px; border-radius: 24px" name="highlight"/>
            <button type="button" class="clear-highlight btn btn-primary" style="border-radius: 24px">清除高亮</button>
        </div>
        <div class="form-group">
            內容預覽：
            <div class="thread-content p-4 bg-light">
                <?php echo $thread_arr['topic_content']?>
            </div>
        </div>

        <div class="modal fade" id="passwordInputModal" tabindex="-1" role="dialog" aria-labelledby="Input Password" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 24px">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">確認儲存嗎？</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">請輸入密碼：</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password...">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control"
                                   id="repassword" name="repassword"
                                   placeholder="Enter password again...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                                style="border-radius: 24px">確認</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
include LAF_PATH . '/modules/module-thread-operation-dialog.php';
?>

<script>
    var BASE_URL = <?php echo json_encode(BASE_URL); ?>;
    var thread_highlight_color = <?php echo json_encode($thread_arr['highlightcolor'])?>;


    $('#operationDialog').on('hidden.bs.modal', function(){
        $('.operation-specific-fields').remove();
    });

    $('.property-save').on('click', function(e){
        $('#passwordInputModal').modal('toggle');
    });
    $('.thread-property-form').on('submit', function(e){
        e.preventDefault();
       $.ajax({
           url : $(this).attr('action'),
           method: $(this).attr('method'),
           data: $(this).serialize(),
           success: function(){

           }
       })
    });


    $('.clear-highlight').on('click', function(){
        $(this).siblings('.pickr').val('');
    });
    var colorpicker = document.querySelector('.pickr');
    const pickr = new Pickr({
        el: colorpicker,
        useAsButton: true,
        default: '#00',
        theme: 'nano',
        autoReposition: false,
        swatches: [
            'rgba(244, 67, 54, 1)',
            'rgba(233, 30, 99, 0.95)',
            'rgba(156, 39, 176, 0.9)',
            'rgba(103, 58, 183, 0.85)',
            'rgba(63, 81, 181, 0.8)',
            'rgba(33, 150, 243, 0.75)',
            'rgba(3, 169, 244, 0.7)',
            'rgba(0, 188, 212, 0.7)',
            'rgba(0, 150, 136, 0.75)',
            'rgba(76, 175, 80, 0.8)',
            'rgba(139, 195, 74, 0.85)',
            'rgba(205, 220, 57, 0.9)',
            'rgba(255, 235, 59, 0.95)',
            'rgba(255, 193, 7, 1)'
        ],

        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                hsla: true,
                hsva: true,
                cmyk: true,
                input: true,
                clear: true,
                save: true,
            }
        }
    }).on('init', function(pickr){
        colorpicker.style.backgroundColor = '#00c5ff';
    }).on('save', function(color){
        colorpicker.value = color.toHEXA().toString(0);
        colorpicker.style.backgroundColor = colorpicker.value;
        pickr.hide();
    })

</script>

