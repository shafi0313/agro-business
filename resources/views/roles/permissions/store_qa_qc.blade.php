<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Store QA/QC @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'StoreQaQc'])</p>
        <div>
            <input type="checkbox" value="store-qa/qc-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageStoreQaQc" name="permissions[]" id="ManageStoreQaQc"
                @if($permissions['store-qa/qc-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageStoreQaQc">
                @lang('role.yes-allow', ['attribute'=> 'Store QA/QC'])
            </label>
        </div>
        <div style="@if($permissions['store-qa/qc-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageStoreQaQc">
            <div>
                <input type="checkbox" value="store-qa/qc-show" class="flat-red " name="permissions[]" id="createStoreQaQc"
                    @if($permissions['store-qa/qc-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createStoreQaQc">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-qa/qc-accept-or-reject" class="flat-red " name="permissions[]" id="acceptOrRejectStoreQaQc"
                    @if($permissions['store-qa/qc-accept-or-reject']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="acceptOrRejectStoreQaQc">
                    Accept or Reject
                </label>
            </div>
        </div>
    </div>
</div>
