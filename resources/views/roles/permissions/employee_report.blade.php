<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Employee Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Employee Report'])</p>
        <div>
            <input type="checkbox" value="employee-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageEmployeeReport" name="permissions[]" id="ManageEmployeeReport"
                @if($permissions['employee-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageEmployeeReport">
                @lang('role.yes-allow', ['attribute'=> 'Employee Report'])
            </label>
        </div>
        <div style="@if($permissions['employee-report-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageEmployeeReport">
            <div>
                <input type="checkbox" value="employee-report-show" class="flat-red " name="permissions[]" id="showEmployeeReport"
                    @if($permissions['employee-report-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showEmployeeReport">
                    @lang('app.show')
                </label>
            </div>
        </div>
    </div>
</div>
