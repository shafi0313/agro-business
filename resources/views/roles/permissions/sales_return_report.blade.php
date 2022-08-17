<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sales Return Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sales Return Report'])</p>
        <div>
            <input type="checkbox" value="sales-return-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSalesReturnReport" name="permissions[]" id="ManageSalesReturnReport"
                @if($permissions['sales-return-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSalesReturnReport">
                @lang('role.yes-allow', ['attribute'=> 'Sales Return Report'])
            </label>
        </div>
    </div>
</div>
