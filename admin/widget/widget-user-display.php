<div class="user-group my-2">
    {{if type === 'select'}}
    <input type="checkbox" name="users"
           id="userid-{{:(id) ? id : moderator_id}}" class="d-none" value="{{:(id) ? id : moderator_id}}">
    {{/if}}
    <div class="row user-display-row">
        <div class="{{: (type === 'select')? 'col-12' : 'col-8'}} user-list-label">
            <label class="row no-gutters p-3" for="userid-{{:(id) ? id : moderator_id}}">
                <div style="width: 64px">
                    <div class="embed-responsive embed-responsive-1by1">
                        <div class="embed-responsive-item"
                             style="background-image: url(<?php echo BASE_ROOT_URL ?>/{{:profile_pic}});
                                 background-size: cover; background-repeat: no-repeat; background-position: center center">
                        </div>
                    </div>
                </div>
                <div class="username d-flex align-items-center px-4">
                    <div class="">
                        {{:username}} (id:{{:(id) ? id : moderator_id}})
                    </div>
                </div>
            </label>
        </div>

    </div>

</div>