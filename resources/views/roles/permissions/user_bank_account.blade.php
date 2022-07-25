<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">User Bank Accounts @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'User Bank Accounts'])</p>
        <div>
            <input type="checkbox" value="user-bank-accounts-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageUserBankAccounts" name="permissions[]" id="ManageUserBankAccounts"
                @if($permissions['user-bank-accounts-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageUserBankAccounts">
                @lang('role.yes-allow', ['attribute'=> 'User Bank Accounts'])
            </label>
        </div>
        <div style="@if($permissions['user-bank-accounts-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageUserBankAccounts">
            <div>
                <input type="checkbox" value="user-bank-accounts-add" class="flat-red " name="permissions[]" id="createUserBankAccounts"
                    @if($permissions['user-bank-accounts-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createUserBankAccounts">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="user-bank-accounts-edit" class="flat-red " name="permissions[]" id="editUserBankAccounts"
                    @if($permissions['user-bank-accounts-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editUserBankAccounts">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="user-bank-accounts-delete" class="flat-red " name="permissions[]" id="deleteUserBankAccounts"
                    @if($permissions['user-bank-accounts-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteUserBankAccounts">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
