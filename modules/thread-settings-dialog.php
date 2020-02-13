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
                            <input type="checkbox" id="draft" name="draft" class="d-none draft-checkbox">
                            <div class="right-toggle"></div>
                        </div>
                    </label>
                </div>
                <div class="settings-list py-2">
                    <label for="readPermission" class="d-flex align-items-center">
                        <span>閱讀權限:</span>
                        <input type="text" class="form-control ml-auto read-permission"
                               style="max-width: 4em" id="readPermission" name="read_permission" value="0" />
                    </label>
                    <div class="text-danger read_permission-invalid-feedback"></div>
                </div>
                <div class="settings-list py-3">
                    <label for="introduction">Introduction</label>
                    <textarea class="form-control introduction" id="introduction" name="introduction" style="min-height: 200px"></textarea>
                    <div class="text-danger read-permission-invalid-feedback"></div>
                </div>
            </div>

        </div>
    </div>
</div>