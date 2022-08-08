<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Factory @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Factory'])</p>
        <div>
            <input type="checkbox" value="factory-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageFactory" name="permissions[]" id="ManageFactory"
                @if($permissions['factory-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageFactory">
                @lang('role.yes-allow', ['attribute'=> 'Factory'])
            </label>
        </div>
        <div style="@if($permissions['factory-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageFactory">
            <div>
                <input type="checkbox" value="factory-add" class="flat-red " name="permissions[]" id="createFactory"
                    @if($permissions['factory-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createFactory">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="factory-edit" class="flat-red " name="permissions[]" id="editFactory"
                    @if($permissions['factory-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editFactory">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="factory-delete" class="flat-red " name="permissions[]" id="deleteFactory"
                    @if($permissions['factory-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteFactory">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
