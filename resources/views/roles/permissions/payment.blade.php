<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Payment @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Payment'])</p>
        <div>
            <input type="checkbox" value="payment-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManagePayment" name="permissions[]" id="ManagePayment"
                @if($permissions['payment-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManagePayment">
                @lang('role.yes-allow', ['attribute'=> 'Payment'])
            </label>
        </div>
        <div style="@if($permissions['payment-manage'] == 1) display:block @else display:none @endif"
            id="childOfManagePayment">
            <div>
                <input type="checkbox" value="payment-add" class="flat-red " name="permissions[]" id="createPayment"
                    @if($permissions['payment-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createPayment">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="payment-show" class="flat-red " name="permissions[]" id="showPayment"
                    @if($permissions['payment-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showPayment">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="payment-delete" class="flat-red " name="permissions[]" id="deletePayment"
                    @if($permissions['payment-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deletePayment">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
