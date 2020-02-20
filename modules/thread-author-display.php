<?php
if(!isset($roles_arr)){
    $roles_arr['r_edit'] = 0;
    $roles_arr['r_manage'] = 0;
    $roles_arr['r_del'] = 0;
}
?>
<section class="thread-show">
    <div class="thread-op" style="background-color:#3458eb; border-radius: 25px">
        <div class="row no-gutters py-3">
            <div class="col-12 d-flex flex-column justify-content-center text-light"
                 style="min-height: 100px; border-radius: 25px">
                <div class="container">
                    <div class="arrangement-tag float-right" style="right: 0; ">#{{:reply_id ? reply_id : 'OP'}}</div>
                    {{if fname}}
                    <a class="btn btn-light my-3"
                       style="border-radius: 25px"
                       href="viewforum.php?id={{:fid}}">
                        {{:fname}}
                    </a>
                    {{/if}}
                    <h1 class="h2">
                        {{:(topic_name) ? topic_name : (reply_topic) ? reply_topic : ''}}
                    </h1>
                    <div class="time">{{:date}}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="container">
                    <div style="max-width: 250px; border-radius: 25px" class="d-flex ml-auto bg-light p-3">
                        <div class="thread-user-avatar overflow-hidden mx-2" style="width: 60px">
                            <div class="embed-responsive embed-responsive-1by1">
                                <div class="embed-responsive-item avatar-holder"
                                     style="background-position: center center;
                         background-repeat: no-repeat; background-size: cover;
                        background-image: url('{{:profile_pic}}')">
                                </div>
                            </div>
                        </div>
                        <div class="user-roles-holder text-center py-2">
                            <div class="username">{{:username}}</div>
                            <div class="role_name" style="color: {{:(role_color) ? role_color: tag_color}}">{{:role}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container py-4 pushed-el-cards" data-title="{{:topic_name}}"
         id="thread-content" style="border-radius: 25px;">
        <div class="thread-content" style="word-wrap: break-word;  min-height: 250px;">{{: (topic_content) ? topic_content : ((reply_content)? reply_content : "The author hasn't written any content")}}</div>
        <div class="action-btn-wrapper text-center">
            <button class="btn btn-light" type="button" style="border-radius: 25px" data-toggle="modal" data-target="#historyModal">
                <!-- inline history svg -->
                <svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1664 896q0 156-61 298t-164 245-245 164-298 61q-172 0-327-72.5t-264-204.5q-7-10-6.5-22.5t8.5-20.5l137-138q10-9 25-9 16 2 23 12 73 95 179 147t225 52q104 0 198.5-40.5t163.5-109.5 109.5-163.5 40.5-198.5-40.5-198.5-109.5-163.5-163.5-109.5-198.5-40.5q-98 0-188 35.5t-160 101.5l137 138q31 30 14 69-17 40-59 40h-448q-26 0-45-19t-19-45v-448q0-42 40-59 39-17 69 14l130 129q107-101 244.5-156.5t284.5-55.5q156 0 298 61t245 164 164 245 61 298zm-640-288v448q0 14-9 23t-23 9h-320q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h224v-352q0-14 9-23t23-9h64q14 0 23 9t9 23z"/></svg>
                History
            </button>
            <?php if(@$roles_arr['r_edit'] === '1' || @$_SESSION['id'] === $thread->getAuthor(@$_GET['id'])){ ?>
                <a href="post.php?id=<?php echo $_GET['id']?>{{if reply_id}}&reply={{:reply_id}}{{/if}}" class="btn btn-primary" style="border-radius: 25px">
                    Edit
                </a>
            <?php } ?>
            <?php if(@$roles_arr['r_manage'] === '1'){ ?>
                <a href="<?php echo BASE_URL . '/admin/thread-manage.php?id=' . @$_GET['id']?>{{if reply_id}}&reply={{:reply_id}}{{/if}}" class="btn btn-danger" style="border-radius: 25px">
                    Manage Thread
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="Thread Modifying History" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 25px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editing History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-0">
                    {{for history}}
                    <div class="thread-history row py-3 align-items-center" id="history-{{:#index}}">
                        <div class="col-12 col-md-6">
                            <div>{{:datetime}}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div>{{:description_zh_hk}}</div>
                            <div class="username">{{:username}}</div>
                        </div>
                    </div>
                    {{/for}}
                    {{if !history || !history.length}}
                    <div style="color: #c4c4c4" class="py-3 text-center">No editing history</div>
                    {{/if}}
                </div>
            </div>
        </div>
    </div>
</section>



