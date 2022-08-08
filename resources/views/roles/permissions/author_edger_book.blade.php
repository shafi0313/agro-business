<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Author Ledger Book @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Author Ledger Book'])</p>
        <div>
            <input type="checkbox" value="author-ledger-book-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageAuthorLedgerBook" name="permissions[]" id="ManageAuthorLedgerBook"
                @if($permissions['author-ledger-book-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageAuthorLedgerBook">
                @lang('role.yes-allow', ['attribute'=> 'AuthorLedgerBook'])
            </label>
        </div>
        <div style="@if($permissions['author-ledger-book-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageAuthorLedgerBook">
            <div>
                <input type="checkbox" value="author-ledger-book-show-all" class="flat-red" name="permissions[]" id="showAllAuthorLedgerBook"
                    @if($permissions['author-ledger-book-show-all']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showAllAuthorLedgerBook">
                    Author Ledger Book Show All
                </label>
            </div>
            <div>
                <input type="checkbox" value="author-ledger-book-show-by-date" class="flat-red" name="permissions[]" id="showByDateAuthorLedgerBook"
                    @if($permissions['author-ledger-book-show-by-date']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showByDateAuthorLedgerBook">
                    Author Ledger Book Show By Date
                </label>
            </div>
        </div>
    </div>
</div>
