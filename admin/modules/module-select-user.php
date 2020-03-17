<div class="modal fade" id="modChooser" tabindex="-1" role="dialog" aria-labelledby="Choose a Moderator" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius: 24px; overflow: hidden">
            <div class="modal-header text-light" style="background-color: #377796">
                <h5 class="modal-title" id="exampleModalLabel">Choose moderators</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_ROOT_URL . '/api/admin/user-search.php'?>" class="user-search-form">
                    <div class="row no-gutters">
                        <div class="col-12 col-md-10">
                            <input type="text" class="form-control username"
                                   style="border: none; border-bottom: 1px solid #377796; border-radius: 0" name="username">
                        </div>
                        <button class="btn btn-primary col-12 col-md-2" style="border-radius: 24px">
                            <i class="fa fa-search"></i>
                        </button>
                        <div class="text-danger d-block">
                            <small class="username-invalid-feedback">
                            </small>
                        </div>
                    </div>
                    <div class="user-list-render" style="min-height: 300px"></div>
                    <input type="hidden" name="fid" value="<?php echo $_GET['id']?>">
                    <div class="form-group">
                        <label for="password">
                            Enter your password to continue
                        </label>
                        <input type="password" class="form-control password" name="password">
                        <div class="invalid-feedback password-invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">
                            Enter password again
                        </label>
                        <input type="password" class="form-control repassword" name="repassword">
                        <div class="invalid-feedback repassword-invalid-feedback"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-save-moderator">OK</button>
            </div>
        </div>
    </div>
</div>


<script id="user-list" type="text/html">
    <?php
    $type = 'select';
    include LAF_ROOT_PATH . '/admin/widget/widget-user-display.php' ?>
</script>



<script>
    var LAF_BASE_URL = <?php echo json_encode(BASE_ROOT_URL); ?>;
    $('.user-search-form').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method : 'POST',
            data: $(this).serialize(),
            success: function(data){
                if(data.error){
                    $('.username-invalid-feedback').html(data.error);
                }else{
                    $(".user-list-render input[type=checkbox]:not(:checked)").each(function(){
                        //Remove unselected users
                        $(this).parents('.user-display-row').remove();
                        $('label[for=' + $(this).attr('id') + ']').remove();
                    });
                    for(key in data){
                        data[key].type = 'select';
                    }
                    var tmpl = $.templates('#user-list');
                    $('.user-list-render').append(tmpl.render(data));
                }
            }
        });
    });
    $('.btn-save-moderator').on('click', function(e){
        var users = [];
        $.each($("input[name='users']:checked"), function(){
            users.push($(this).val());
        });
        e.preventDefault();
        $.ajax({
            url: LAF_BASE_URL + '/api/admin/add-moderators.php',
            method: 'POST',
            data:{
                username : users,
                fid: $("input[name='fid']").val(),
                password: $("input[name='password']").val(),
                repassword: $("input[name='repassword']").val(),
            },
            success: function(data){
                if(data.error){
                    for(key in data.error){
                        $('.' + key).addClass('is-invalid');
                        $('.' + key + '-invalid-feedback').html(data.error[key]);
                    }
                }else if(data.success){
                    $('#modChooser').modal('toggle');
                    getModerators();
                }
            }
        });
    });
</script>