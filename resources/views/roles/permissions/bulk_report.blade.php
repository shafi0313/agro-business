<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bulk Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Bulk Report'])</p>
        <div>
            <input type="checkbox" value="bulk-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBulkReport" name="permissions[]" id="ManageBulkReport"
                @if($permissions['bulk-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBulkReport">
                @lang('role.yes-allow', ['attribute'=> 'Bulk Report'])
            </label>
        </div>
        <div style="@if($permissions['bulk-report-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBulkReport">
            <div>
                <input type="checkbox" value="bulk-report-sales" class="flat-red " name="permissions[]" id="salesBulkReport"
                    @if($permissions['bulk-report-sales']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="salesBulkReport">
                    Sales
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-report-purchase" class="flat-red " name="permissions[]" id="purchaseBulkReport"
                    @if($permissions['bulk-report-purchase']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="purchaseBulkReport">
                    Purchase
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-report-send-to-repack-unit" class="flat-red " name="permissions[]" id="sendToRepackUnitBulkReport"
                    @if($permissions['bulk-report-send-to-repack-unit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="sendToRepackUnitBulkReport">
                    Send to Repack Unit
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-report-send-sales-&-repack-unit-challan" class="flat-red " name="permissions[]" id="sendSalesRepackUnitChallanBulkReport"
                    @if($permissions['bulk-report-send-sales-&-repack-unit-challan']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="sendSalesRepackUnitChallanBulkReport">
                    Send Sales & Repack Unit Challan
                </label>
            </div>
        </div>
    </div>
</div>
