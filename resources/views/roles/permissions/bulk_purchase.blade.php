<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bulk Purchase @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Bulk Purchase'])</p>
        <div>
            <input type="checkbox" value="bulk-purchase-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBulkPurchase" name="permissions[]" id="ManageBulkPurchase"
                @if($permissions['bulk-purchase-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBulkPurchase">
                @lang('role.yes-allow', ['attribute'=> 'Bulk Purchase'])
            </label>
        </div>
        <div style="@if($permissions['bulk-purchase-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBulkPurchase">
            <div>
                <input type="checkbox" value="bulk-purchase-purchase" class="flat-red" name="permissions[]" id="bulkPurchase"
                    @if($permissions['bulk-purchase-purchase']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="bulkPurchase">
                    Bulk Purchase
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-purchase-show" class="flat-red" name="permissions[]" id="showPurchase"
                    @if($permissions['bulk-purchase-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showPurchase">
                    Bulk Purchase Show
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-purchase-all-challan" class="flat-red" name="permissions[]" id="allChallanPurchase"
                    @if($permissions['bulk-purchase-all-challan']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allChallanPurchase">
                    Bulk Purchase All Challan
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-purchase-all-challan-by-date" class="flat-red" name="permissions[]" id="allChallanByDateBulkPurchase"
                    @if($permissions['bulk-purchase-all-challan-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allChallanByDateBulkPurchase">
                    Bulk Purchase All Challan By Date
                </label>
            </div>
        </div>
    </div>
</div>
