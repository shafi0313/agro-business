<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bank Statement @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Bank Statement'])</p>
        <div>
            <input type="checkbox" value="bank-statement-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBankStatement" name="permissions[]" id="ManageBankStatement"
                @if($permissions['bank-statement-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBankStatement">
                @lang('role.yes-allow', ['attribute'=> 'Bank Statement'])
            </label>
        </div>
        <div style="@if($permissions['bank-statement-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBankStatement">
            <div>
                <input type="checkbox" value="bank-statement-previous-add" class="flat-red" name="permissions[]" id="createBankStatement"
                    @if($permissions['bank-statement-previous-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createBankStatement">
                    Bank Statement Previous Add
                </label>
            </div>
        </div>
    </div>
</div>
