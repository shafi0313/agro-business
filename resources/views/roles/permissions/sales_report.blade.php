<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sales Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sales Report'])</p>
        <div>
            <input type="checkbox" value="sales-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSalesReport" name="permissions[]" id="ManageSalesReport"
                @if($permissions['sales-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSalesReport">
                @lang('role.yes-allow', ['attribute'=> 'Sales Report'])
            </label>
        </div>
    </div>
</div>
