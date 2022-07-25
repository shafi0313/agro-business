<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Office Expense Category @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Office Expense Category'])</p>
        <div>
            <input type="checkbox" value="office-expense-category-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageOfficeExpenseCategory" name="permissions[]" id="ManageOfficeExpenseCategory"
                @if($permissions['office-expense-category-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageOfficeExpenseCategory">
                @lang('role.yes-allow', ['attribute'=> 'Office Expense Category'])
            </label>
        </div>
        <div style="@if($permissions['office-expense-category-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageOfficeExpenseCategory">
            <div>
                <input type="checkbox" value="office-expense-category-add" class="flat-red " name="permissions[]" id="createOfficeExpenseCategory"
                    @if($permissions['office-expense-category-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createOfficeExpenseCategory">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="office-expense-category-edit" class="flat-red " name="permissions[]" id="editOfficeExpenseCategory"
                    @if($permissions['office-expense-category-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editOfficeExpenseCategory">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="office-expense-category-delete" class="flat-red " name="permissions[]" id="deleteOfficeExpenseCategory"
                    @if($permissions['office-expense-category-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteOfficeExpenseCategory">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
