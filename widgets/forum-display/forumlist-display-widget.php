<div class="forum py-5">
    <h2 class="h5 forum_name">{{:board_name}} <small>(gid: {{:board_id}})</small></h2>
    <div class="forum-show-wrapper row overflow-hidden">
        {{for forum}}
        <a class="forum-block d-block col-12 py-4 text-decoration-none" style="min-height: 120px" href="viewforum.php?id={{>fid}}">
            <h3 class="d-block h6 font-weight-normal mb-0">{{>fname}}</h3>
            <div>
                <span class="font-weight-bold">{{:num_of_threads}}</span>
                <span>{{if num_of_threads <= 1}} thread{{else}} threads{{/if}}.</span>
            </div>
        </a>
        {{/for}}
    </div>
</div>