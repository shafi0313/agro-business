<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Expense Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Expense Report'])</p>
        <div>
            <input type="checkbox" value="expense-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageExpenseReport" name="permissions[]" id="ManageExpenseReport"
                @if($permissions['expense-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageExpenseReport">
                @lang('role.yes-allow', ['attribute'=> 'Expense Report'])
            </label>
        </div>
    </div>
</div>
