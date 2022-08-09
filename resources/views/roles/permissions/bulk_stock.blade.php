<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bulk Stock @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'BulkStock'])</p>
        <div>
            <input type="checkbox" value="bulk-stock-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBulkStock" name="permissions[]" id="ManageBulkStock"
                @if($permissions['bulk-stock-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBulkStock">
                @lang('role.yes-allow', ['attribute'=> 'Bulk Stock'])
            </label>
        </div>
        <div style="@if($permissions['bulk-stock-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBulkStock">
            <div>
                <input type="checkbox" value="bulk-stock-add" class="flat-red " name="permissions[]" id="createBulkStock"
                    @if($permissions['bulk-stock-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createBulkStock">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-stock-edit" class="flat-red " name="permissions[]" id="editBulkStock"
                    @if($permissions['bulk-stock-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editBulkStock">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-stock-stock-close" class="flat-red " name="permissions[]" id="closeBulkStock"
                    @if($permissions['bulk-stock-stock-close']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="closeBulkStock">
                    Stock Close
                </label>
            </div>
        </div>
    </div>
</div>
