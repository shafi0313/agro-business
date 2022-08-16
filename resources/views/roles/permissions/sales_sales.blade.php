<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sales Sales @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sales Sales'])</p>
        <div>
            <input type="checkbox" value="sales-sales-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSalesSales" name="permissions[]" id="ManageSalesSales"
                @if($permissions['sales-sales-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSalesSales">
                @lang('role.yes-allow', ['attribute'=> 'Sales Sales'])
            </label>
        </div>
        <div style="@if($permissions['sales-sales-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSalesSales">
            <div>
                <input type="checkbox" value="sales-sales-sales" class="flat-red " name="permissions[]" id="salesSalesSales"
                    @if($permissions['sales-sales-sales']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="salesSalesSales">
                    Sales
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-cancel-invoice" class="flat-red " name="permissions[]" id="cancelInvoiceSalesSales"
                    @if($permissions['sales-sales-cancel-invoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="cancelInvoiceSalesSales">
                    Cancel Invoice
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-reinvoice" class="flat-red " name="permissions[]" id="reinvoiceSalesSales"
                    @if($permissions['sales-sales-reinvoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="reinvoiceSalesSales">
                    Reinvoice
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-all-challan-and-invoice" class="flat-red " name="permissions[]" id="allChallanAndInvoiceSalesSales"
                    @if($permissions['sales-sales-all-challan-and-invoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allChallanAndInvoiceSalesSales">
                    All Challan and Invoice
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-all-challan-and-invoice-by-date" class="flat-red " name="permissions[]" id="allChallanAndInvoiceByDateSalesSales"
                    @if($permissions['sales-sales-all-challan-and-invoice-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allChallanAndInvoiceByDateSalesSales">
                    All Challan and Invoice By Date
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-show" class="flat-red " name="permissions[]" id="showSalesSales"
                    @if($permissions['sales-sales-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showSalesSales">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-challan" class="flat-red " name="permissions[]" id="challanSalesSales"
                    @if($permissions['sales-sales-challan']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="challanSalesSales">
                    Challan
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sales-invoice" class="flat-red " name="permissions[]" id="invoiceSalesSales"
                    @if($permissions['sales-sales-invoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="invoiceSalesSales">
                    Invoice
                </label>
            </div>
        </div>
    </div>
</div>
