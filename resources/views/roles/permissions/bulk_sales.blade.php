<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bulk Sales @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Bulk Sales'])</p>
        <div>
            <input type="checkbox" value="bulk-sales-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBulkSales" name="permissions[]" id="ManageBulkSales"
                @if($permissions['bulk-sales-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBulkSales">
                @lang('role.yes-allow', ['attribute'=> 'Bulk Sales'])
            </label>
        </div>
        <div style="@if($permissions['bulk-sales-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBulkSales">
            <div>
                <input type="checkbox" value="bulk-sales-sales" class="flat-red" name="permissions[]" id="bulkSales"
                    @if($permissions['bulk-sales-sales']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="bulkSales">
                    Bulk Sales
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-sales-show" class="flat-red" name="permissions[]" id="showSales"
                    @if($permissions['bulk-sales-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showSales">
                    Bulk Sales Show
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-sales-all-challan" class="flat-red" name="permissions[]" id="allChallanSales"
                    @if($permissions['bulk-sales-all-challan']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allChallanSales">
                    Bulk Sales All Challan
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-sales-all-challan-by-date" class="flat-red" name="permissions[]" id="allChallanByDateBulkSales"
                    @if($permissions['bulk-sales-all-challan-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allChallanByDateBulkSales">
                    Bulk Sales All Challan By Date
                </label>
            </div>
        </div>
    </div>
</div>
