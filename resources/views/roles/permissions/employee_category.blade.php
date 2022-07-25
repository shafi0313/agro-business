<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Employee Category @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Employee Category'])</p>
        <div>
            <input type="checkbox" value="employee-category-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageEmployeeCategory" name="permissions[]" id="ManageEmployeeCategory"
                @if($permissions['employee-category-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageEmployeeCategory">
                @lang('role.yes-allow', ['attribute'=> 'Employee Category'])
            </label>
        </div>
        <div style="@if($permissions['employee-category-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageEmployeeCategory">
            <div>
                <input type="checkbox" value="employee-category-add" class="flat-red " name="permissions[]" id="createEmployeeCategory"
                    @if($permissions['employee-category-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createEmployeeCategory">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="employee-category-edit" class="flat-red " name="permissions[]" id="editEmployeeCategory"
                    @if($permissions['employee-category-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editEmployeeCategory">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="employee-category-delete" class="flat-red " name="permissions[]" id="deleteEmployeeCategory"
                    @if($permissions['employee-category-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteEmployeeCategory">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
