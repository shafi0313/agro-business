<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Store @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Store'])</p>
        <div>
            <input type="checkbox" value="store-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageStore" name="permissions[]" id="ManageStore"
                @if($permissions['store-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageStore">
                @lang('role.yes-allow', ['attribute'=> 'Store'])
            </label>
        </div>
        <div style="@if($permissions['store-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageStore">
            <div>
                <input type="checkbox" value="store-add" class="flat-red " name="permissions[]" id="createStore"
                    @if($permissions['store-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createStore">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-edit" class="flat-red " name="permissions[]" id="editStore"
                    @if($permissions['store-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editStore">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="store-delete" class="flat-red " name="permissions[]" id="deleteStore"
                    @if($permissions['store-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteStore">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
