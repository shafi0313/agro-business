<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Main Account @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Main Account'])</p>
        <div>
            <input type="checkbox" value="main-account-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageMainAccount" name="permissions[]" id="ManageMainAccount"
                @if($permissions['main-account-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageMainAccount">
                @lang('role.yes-allow', ['attribute'=> 'Main Account'])
            </label>
        </div>
    </div>
</div>
