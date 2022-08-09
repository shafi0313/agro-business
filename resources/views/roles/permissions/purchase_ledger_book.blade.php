<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Purchase Ledger Book @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Purchase Ledger Book'])</p>
        <div>
            <input type="checkbox" value="purchase-ledger-book-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManagePurchaseLedgerBook" name="permissions[]" id="ManagePurchaseLedgerBook"
                @if($permissions['purchase-ledger-book-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManagePurchaseLedgerBook">
                @lang('role.yes-allow', ['attribute'=> 'Purchase Ledger Book'])
            </label>
        </div>
        <div style="@if($permissions['purchase-ledger-book-manage'] == 1) display:block @else display:none @endif"
            id="childOfManagePurchaseLedgerBook">
            <div>
                <input type="checkbox" value="purchase-ledger-book-show-all" class="flat-red " name="permissions[]" id="showAllPurchaseLedgerBook"
                    @if($permissions['purchase-ledger-book-show-all']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showAllPurchaseLedgerBook">
                    Show All
                </label>
            </div>
            <div>
                <input type="checkbox" value="purchase-ledger-book-show-by-date" class="flat-red " name="permissions[]" id="showByDatePurchaseLedgerBook"
                    @if($permissions['purchase-ledger-book-show-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showByDatePurchaseLedgerBook">
                    Show By Date
                </label>
            </div>
            <div>
                <input type="checkbox" value="purchase-ledger-book-all-ledger-book" class="flat-red " name="permissions[]" id="allLedgerBookPurchaseLedgerBook"
                    @if($permissions['purchase-ledger-book-all-ledger-book']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allLedgerBookPurchaseLedgerBook">
                    All Ledger Book
                </label>
            </div>
        </div>
    </div>
</div>
