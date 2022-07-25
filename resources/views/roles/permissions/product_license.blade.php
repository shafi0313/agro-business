<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Product License @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Product License'])</p>
        <div>
            <input type="checkbox" value="product-license-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageProductLicense" name="permissions[]" id="ManageProductLicense"
                @if($permissions['product-license-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageProductLicense">
                @lang('role.yes-allow', ['attribute'=> 'Product License'])
            </label>
        </div>
        <div style="@if($permissions['product-license-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageProductLicense">
            <div>
                <input type="checkbox" value="product-license-add" class="flat-red " name="permissions[]" id="createProductLicense"
                    @if($permissions['product-license-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createProductLicense">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="product-license-show" class="flat-red " name="permissions[]" id="createProductLicense"
                    @if($permissions['product-license-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createProductLicense">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="product-license-edit" class="flat-red " name="permissions[]" id="editProductLicense"
                    @if($permissions['product-license-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editProductLicense">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="product-license-delete" class="flat-red " name="permissions[]" id="deleteProductLicense"
                    @if($permissions['product-license-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteProductLicense">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
