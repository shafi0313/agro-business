<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Store Stock @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Store Stock'])</p>
        <div>
            <input type="checkbox" value="store-stock-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageStoreStock" name="permissions[]" id="ManageStoreStock"
                @if($permissions['store-stock-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageStoreStock">
                @lang('role.yes-allow', ['attribute'=> 'Store Stock'])
            </label>
        </div>
        <div style="@if($permissions['store-stock-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageStoreStock">
            <div>
                <input type="checkbox" value="store-stock-add" class="flat-red " name="permissions[]" id="createStoreStock"
                    @if($permissions['store-stock-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createStoreStock">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-stock-edit" class="flat-red " name="permissions[]" id="editStoreStock"
                    @if($permissions['store-stock-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editStoreStock">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-stock-stock-close" class="flat-red " name="permissions[]" id="stockCloseStoreStock"
                    @if($permissions['store-stock-stock-close']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="stockCloseStoreStock">
                    Stock Close
                </label>
            </div>
        </div>
    </div>
</div>
