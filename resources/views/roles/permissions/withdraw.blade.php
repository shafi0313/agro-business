<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Withdraw @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Withdraw'])</p>
        <div>
            <input type="checkbox" value="withdraw-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageWithdraw" name="permissions[]" id="ManageWithdraw"
                @if($permissions['withdraw-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageWithdraw">
                @lang('role.yes-allow', ['attribute'=> 'Withdraw'])
            </label>
        </div>
        <div style="@if($permissions['withdraw-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageWithdraw">
            <div>
                <input type="checkbox" value="withdraw-add" class="flat-red " name="permissions[]" id="createWithdraw"
                    @if($permissions['withdraw-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createWithdraw">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="withdraw-show" class="flat-red " name="permissions[]" id="showWithdraw"
                    @if($permissions['withdraw-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showWithdraw">
                    @lang('app.show')
                </label>
            </div>
        </div>
    </div>
</div>
