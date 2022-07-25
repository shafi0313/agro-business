<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Pack Size @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Pack Size'])</p>
        <div>
            <input type="checkbox" value="pack-size-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManagePackSize" name="permissions[]" id="ManagePackSize"
                @if($permissions['pack-size-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManagePackSize">
                @lang('role.yes-allow', ['attribute'=> 'Pack Size'])
            </label>
        </div>
        <div style="@if($permissions['pack-size-manage'] == 1) display:block @else display:none @endif"
            id="childOfManagePackSize">
            <div>
                <input type="checkbox" value="pack-size-add" class="flat-red " name="permissions[]" id="createPackSize"
                    @if($permissions['pack-size-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createPackSize">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="pack-size-edit" class="flat-red " name="permissions[]" id="editPackSize"
                    @if($permissions['pack-size-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editPackSize">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="pack-size-delete" class="flat-red " name="permissions[]" id="deletePackSize"
                    @if($permissions['pack-size-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deletePackSize">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
