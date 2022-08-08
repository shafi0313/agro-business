<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Supplier @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Supplier'])</p>
        <div>
            <input type="checkbox" value="supplier-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSupplier" name="permissions[]" id="ManageSupplier"
                @if($permissions['supplier-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSupplier">
                @lang('role.yes-allow', ['attribute'=> 'Supplier'])
            </label>
        </div>
        <div style="@if($permissions['supplier-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSupplier">
            <div>
                <input type="checkbox" value="supplier-add" class="flat-red " name="permissions[]" id="createSupplier"
                    @if($permissions['supplier-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createSupplier">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="supplier-edit" class="flat-red " name="permissions[]" id="editSupplier"
                    @if($permissions['supplier-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editSupplier">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="supplier-delete" class="flat-red " name="permissions[]" id="deleteSupplier"
                    @if($permissions['supplier-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteSupplier">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
