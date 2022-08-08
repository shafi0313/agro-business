<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Cashbook @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Cashbook'])</p>
        <div>
            <input type="checkbox" value="cashbook-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageCashbook" name="permissions[]" id="ManageCashbook"
                @if($permissions['cashbook-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageCashbook">
                @lang('role.yes-allow', ['attribute'=> 'Cashbook'])
            </label>
        </div>
        <div style="@if($permissions['cashbook-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageCashbook">
            <div>
                <input type="checkbox" value="cashbook-previous-add" class="flat-red" name="permissions[]" id="createCashbook"
                    @if($permissions['cashbook-previous-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createCashbook">
                    Cashbook Previous Add
                </label>
            </div>
        </div>
    </div>
</div>
