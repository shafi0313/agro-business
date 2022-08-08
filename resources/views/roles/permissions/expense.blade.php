<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Expense @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Expense'])</p>
        <div>
            <input type="checkbox" value="expense-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageExpense" name="permissions[]" id="ManageExpense"
                @if($permissions['expense-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageExpense">
                @lang('role.yes-allow', ['attribute'=> 'Expense'])
            </label>
        </div>
        <div style="@if($permissions['expense-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageExpense">
            <div>
                <input type="checkbox" value="expense-add" class="flat-red " name="permissions[]" id="createExpense"
                    @if($permissions['expense-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createExpense">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="expense-show" class="flat-red " name="permissions[]" id="showExpense"
                    @if($permissions['expense-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showExpense">
                    @lang('app.show')
                </label>
            </div>
        </div>
    </div>
</div>
