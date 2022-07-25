<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Customer @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Customer'])</p>
        <div>
            <input type="checkbox" value="customer-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageCustomer" name="permissions[]" id="ManageCustomer"
                @if($permissions['customer-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageCustomer">
                @lang('role.yes-allow', ['attribute'=> 'Customer'])
            </label>
        </div>
        <div style="@if($permissions['customer-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageCustomer">
            <div>
                <input type="checkbox" value="customer-add" class="flat-red " name="permissions[]" id="createCustomer"
                    @if($permissions['customer-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createCustomer">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="customer-edit" class="flat-red " name="permissions[]" id="editCustomer"
                    @if($permissions['customer-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editCustomer">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="customer-delete" class="flat-red " name="permissions[]" id="deleteCustomer"
                    @if($permissions['customer-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteCustomer">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
