<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Store Product @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'StoreProduct'])</p>
        <div>
            <input type="checkbox" value="store-product-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageStoreProduct" name="permissions[]" id="ManageStoreProduct"
                @if($permissions['store-product-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageStoreProduct">
                @lang('role.yes-allow', ['attribute'=> 'Store Product'])
            </label>
        </div>
        <div style="@if($permissions['store-product-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageStoreProduct">
            <div>
                <input type="checkbox" value="store-product-add" class="flat-red " name="permissions[]" id="createStoreProduct"
                    @if($permissions['store-product-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createStoreProduct">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-product-edit" class="flat-red " name="permissions[]" id="editStoreProduct"
                    @if($permissions['store-product-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editStoreProduct">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-product-delete" class="flat-red " name="permissions[]" id="deleteStoreProduct"
                    @if($permissions['store-product-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteStoreProduct">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
