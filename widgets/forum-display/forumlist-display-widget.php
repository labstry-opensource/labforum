<div class="forum">
    <h2 class="h4 forum_name">{{:board_name}} <small>(gid: {{:board_id}})</small></h2>
    <div class="forum-show-wrapper row">
        {{for forum}}
        <a class="d-block col-12 col-md-6 align-items-center py-4 text-decoration-none" style="min-height: 120px" href="viewforum.php?id={{>fid}}">
            <h3 class="d-block h5 font-weight-normal">{{>fname}}</h3>
        </a>
        {{/for}}
    </div>
</div>