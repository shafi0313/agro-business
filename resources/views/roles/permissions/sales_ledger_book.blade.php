<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sales Ledger Book @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sales Ledger Book'])</p>
        <div>
            <input type="checkbox" value="sales-ledger-book-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSalesLedgerBook" name="permissions[]" id="ManageSalesLedgerBook"
                @if($permissions['sales-ledger-book-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSalesLedgerBook">
                @lang('role.yes-allow', ['attribute'=> 'Sales Ledger Book'])
            </label>
        </div>
        <div style="@if($permissions['sales-ledger-book-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSalesLedgerBook">
            <div>
                <input type="checkbox" value="sales-ledger-book-edit" class="flat-red " name="permissions[]" id="editSalesLedgerBook"
                    @if($permissions['sales-ledger-book-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editSalesLedgerBook">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-ledger-book-show-all" class="flat-red " name="permissions[]" id="showAllSalesLedgerBook"
                    @if($permissions['sales-ledger-book-show-all']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showAllSalesLedgerBook">
                    Show All
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-ledger-book-show-by-date" class="flat-red " name="permissions[]" id="showByDateSalesLedgerBook"
                    @if($permissions['sales-ledger-book-show-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showByDateSalesLedgerBook">
                    Show By Date
                </label>
            </div>
            <div>
                <input type="checkbox" value="sales-ledger-book-all-ledger-book" class="flat-red " name="permissions[]" id="allLedgerBookSalesLedgerBook"
                    @if($permissions['sales-ledger-book-all-ledger-book']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="allLedgerBookSalesLedgerBook">
                    All Ledger Book
                </label>
            </div>
        </div>
    </div>
</div>
