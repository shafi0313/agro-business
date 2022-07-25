<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Employee @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Employee'])</p>
        <div>
            <input type="checkbox" value="employee-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageEmployee" name="permissions[]" id="ManageEmployee"
                @if($permissions['employee-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageEmployee">
                @lang('role.yes-allow', ['attribute'=> 'Employee'])
            </label>
        </div>
        <div style="@if($permissions['employee-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageEmployee">
            <div>
                <input type="checkbox" value="employee-add" class="flat-red " name="permissions[]" id="createEmployee"
                    @if($permissions['employee-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createEmployee">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="employee-edit" class="flat-red " name="permissions[]" id="editEmployee"
                    @if($permissions['employee-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editEmployee">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="employee-delete" class="flat-red " name="permissions[]" id="deleteEmployee"
                    @if($permissions['employee-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteEmployee">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
