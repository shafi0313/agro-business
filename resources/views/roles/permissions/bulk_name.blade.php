<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Bulk Name @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Bulk Name'])</p>
        <div>
            <input type="checkbox" value="bulk-name-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageBulkName" name="permissions[]" id="ManageBulkName"
                @if($permissions['bulk-name-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageBulkName">
                @lang('role.yes-allow', ['attribute'=> 'Bulk Name'])
            </label>
        </div>
        <div style="@if($permissions['bulk-name-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageBulkName">
            <div>
                <input type="checkbox" value="bulk-name-add" class="flat-red " name="permissions[]" id="createBulkName"
                    @if($permissions['bulk-name-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createBulkName">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-name-edit" class="flat-red " name="permissions[]" id="editBulkName"
                    @if($permissions['bulk-name-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editBulkName">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="bulk-name-delete" class="flat-red " name="permissions[]" id="deleteBulkName"
                    @if($permissions['bulk-name-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteBulkName">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
