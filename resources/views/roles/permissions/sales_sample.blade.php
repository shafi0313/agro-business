<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sales Sample @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sales Sample'])</p>
        <div>
            <input type="checkbox" value="sales-sample-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSalesSample" name="permissions[]" id="ManageSalesSample"
                @if($permissions['sales-sample-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSalesSample">
                @lang('role.yes-allow', ['attribute'=> 'Sales Sample'])
            </label>
        </div>
        <div style="@if($permissions['sales-sample-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSalesSample">
            <div>
                <input type="checkbox" value="sales-sample-sample" class="flat-red " name="permissions[]" id="createSalesSample"
                    @if($permissions['sales-sample-sample']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createSalesSample">
                    Sample
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sample-show" class="flat-red " name="permissions[]" id="showSalesSample"
                    @if($permissions['sales-sample-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showSalesSample">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sample-challan" class="flat-red " name="permissions[]" id="challanSalesSample"
                    @if($permissions['sales-sample-challan']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="challanSalesSample">
                    Challan
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-sample-invoice" class="flat-red " name="permissions[]" id="invoiceSalesSample"
                    @if($permissions['sales-sample-invoice']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="invoiceSalesSample">
                    Invoice
                </label>
            </div>
        </div>
    </div>
</div>
