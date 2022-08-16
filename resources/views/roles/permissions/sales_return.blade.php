<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sales Return @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sales Return'])</p>
        <div>
            <input type="checkbox" value="sales-return-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSalesReturn" name="permissions[]" id="ManageSalesReturn"
                @if($permissions['sales-return-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSalesReturn">
                @lang('role.yes-allow', ['attribute'=> 'Sales Return'])
            </label>
        </div>
        <div style="@if($permissions['sales-return-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSalesReturn">
            <div>
                <input type="checkbox" value="sales-return-return" class="flat-red " name="permissions[]" id="salesReturnReturn"
                    @if($permissions['sales-return-return']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="salesReturnReturn">
                    Return
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-return-all-invoice" class="flat-red " name="permissions[]" id="allInvoiceSalesReturn"
                    @if($permissions['sales-return-all-invoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allInvoiceSalesReturn">
                    All Invoice
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-return-all-invoice-by-date" class="flat-red " name="permissions[]" id="allInvoiceByDateSalesReturn"
                    @if($permissions['sales-return-all-invoice-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allInvoiceByDateSalesReturn">
                    All Invoice By Date
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-return-show" class="flat-red " name="permissions[]" id="showSalesReturn"
                    @if($permissions['sales-return-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showSalesReturn">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-return-invoice" class="flat-red " name="permissions[]" id="invoiceSalesReturn"
                    @if($permissions['sales-return-invoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="invoiceSalesReturn">
                    Invoice
                </label>
            </div>
        </div>
    </div>
</div>
