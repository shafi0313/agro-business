<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bank List @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Bank List'])</p>
        <div>
            <input type="checkbox" value="bank-list-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBankList" name="permissions[]" id="ManageBankList"
                @if($permissions['bank-list-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBankList">
                @lang('role.yes-allow', ['attribute'=> 'Bank List'])
            </label>
        </div>
        <div style="@if($permissions['bank-list-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBankList">
            <div>
                <input type="checkbox" value="bank-list-add" class="flat-red " name="permissions[]" id="createBankList"
                    @if($permissions['bank-list-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createBankList">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="bank-list-edit" class="flat-red " name="permissions[]" id="editBankList"
                    @if($permissions['bank-list-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editBankList">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="bank-list-delete" class="flat-red " name="permissions[]" id="deleteBankList"
                    @if($permissions['bank-list-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteBankList">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
