<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Customer Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Customer Report'])</p>
        <div>
            <input type="checkbox" value="customer-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageCustomerReport" name="permissions[]" id="ManageCustomerReport"
                @if($permissions['customer-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageCustomerReport">
                @lang('role.yes-allow', ['attribute'=> 'Customer Report'])
            </label>
        </div>
    </div>
</div>
