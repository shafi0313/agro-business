<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Office Income Category @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Office Income Category'])</p>
        <div>
            <input type="checkbox" value="office-income-category-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageOfficeIncomeCategory" name="permissions[]" id="ManageOfficeIncomeCategory"
                @if($permissions['office-income-category-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageOfficeIncomeCategory">
                @lang('role.yes-allow', ['attribute'=> 'Office Income Category'])
            </label>
        </div>
        <div style="@if($permissions['office-income-category-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageOfficeIncomeCategory">
            <div>
                <input type="checkbox" value="office-income-category-add" class="flat-red " name="permissions[]" id="createOfficeIncomeCategory"
                    @if($permissions['office-income-category-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createOfficeIncomeCategory">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="office-income-category-edit" class="flat-red " name="permissions[]" id="editOfficeIncomeCategory"
                    @if($permissions['office-income-category-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editOfficeIncomeCategory">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="office-income-category-delete" class="flat-red " name="permissions[]" id="deleteOfficeIncomeCategory"
                    @if($permissions['office-income-category-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteOfficeIncomeCategory">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
