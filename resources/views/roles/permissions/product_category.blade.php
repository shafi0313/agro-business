<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Product Category @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Product Category'])</p>
        <div>
            <input type="checkbox" value="product-category-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageProductCategory" name="permissions[]" id="ManageProductCategory"
                @if($permissions['product-category-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageProductCategory">
                @lang('role.yes-allow', ['attribute'=> 'Product Category'])
            </label>
        </div>
        <div style="@if($permissions['product-category-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageProductCategory">
            <div>
                <input type="checkbox" value="product-category-add" class="flat-red " name="permissions[]" id="createProductCategory"
                    @if($permissions['product-category-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createProductCategory">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="product-category-edit" class="flat-red " name="permissions[]" id="editProductCategory"
                    @if($permissions['product-category-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editProductCategory">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="product-category-delete" class="flat-red " name="permissions[]" id="deleteProductCategory"
                    @if($permissions['product-category-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteProductCategory">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
