<div class="modal fade" id="operationDialog" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="Are you sure?" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 24px">
            <div class="modal-header">
                <h5 class="modal-title operation-label"></h5>
                <button type="button" class="close disappear" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                如要進行<span class="operation-label"></span>操作，請先輸入密碼：
                <form class="thread-operation-form">
                    <input type="hidden" value="" name="action" class="action-field">
                    <input type="hidden" value="<?php echo $_SESSION['id']; ?>" name="id">
                    <input type="hidden" value="<?php echo $_GET['id']?>" name="thread_id">
                    <div class="form-group">
                        <input type="password" class="form-control password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control repassword" name="repassword" placeholder="Enter password again...">
                        <div class="invalid-feedback repassword-invalid-feedback"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger operation-label submit-operation disappear" style="border-radius: 24px;"></button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.operation-btn').on('click', function(e){
        e.preventDefault();
        var action = $(this).data('action');
        var description = $(this).text();
        $('.action-field').val(action);
        $('.operation-label').text(description);
        $('#operationDialog').modal('toggle');


        var special_field;
        switch (action) {
            case 'promote':
            case 'demote':
                special_field = '<div class="form-group operation-specific-fields">' +
                    '<label for="level">提升 / 下沉：</label>' +
                    '<select class="form-control level" id="level" name="level">' +
                    '<option value="1">Sticky to homepage</option>' +
                    '<option value="2">Sticky to board only</option>' +
                    '<option value="3">Demote to normal thread</option>' +
                    '</select><div class="invalid-feedback level-invalid-feedback"></div></div>';
                break;
            case 'hiddeni':
                special_field = '<div class="form-group operation-specific-fields">' +
                    '<label for="reason">屏蔽理由：</label>' +
                    '<textarea name="reason" id="reason" class="form-control" style="min-height: 200px"></textarea>' +
                    '<div class="invalid-feedback reason-invalid-feedback"></div></div>';
        }
        $('.thread-operation-form').append(special_field);
    });

    $('.submit-operation').on('click', function(e){
        $('.is-invalid').removeClass('is-invalid');
        $.ajax({
            url: BASE_URL + '/../api/admin/thread-operation.php',
            method: 'POST',
            data: $('.thread-operation-form').serialize(),
            success: function(data){
                if(data.error){
                    for(key in data.error){
                        $('.' + key).addClass('is-invalid');
                        if(data.error.repassword){
                            $('.password').addClass('is-invalid');
                        }
                        $('.' + key + '-invalid-feedback').text(data.error[key]);
                    }
                }else if(data.success){
                    $('#operationDialog').modal('toggle');
                }

            }
        });
    });
</script>