<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Deposit @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Deposit'])</p>
        <div>
            <input type="checkbox" value="deposit-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageDeposit" name="permissions[]" id="ManageDeposit"
                @if($permissions['deposit-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageDeposit">
                @lang('role.yes-allow', ['attribute'=> 'Deposit'])
            </label>
        </div>
        <div style="@if($permissions['deposit-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageDeposit">
            <div>
                <input type="checkbox" value="deposit-add" class="flat-red " name="permissions[]" id="createDeposit"
                    @if($permissions['deposit-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createDeposit">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="deposit-show" class="flat-red " name="permissions[]" id="showDeposit"
                    @if($permissions['deposit-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showDeposit">
                    @lang('app.show')
                </label>
            </div>
        </div>
    </div>
</div>
