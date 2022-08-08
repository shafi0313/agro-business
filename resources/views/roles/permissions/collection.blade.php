<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Collection @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Collection'])</p>
        <div>
            <input type="checkbox" value="collection-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageCollection" name="permissions[]" id="ManageCollection"
                @if($permissions['collection-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageCollection">
                @lang('role.yes-allow', ['attribute'=> 'Collection'])
            </label>
        </div>
        <div style="@if($permissions['collection-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageCollection">
            <div>
                <input type="checkbox" value="collection-add" class="flat-red " name="permissions[]" id="createCollection"
                    @if($permissions['collection-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createCollection">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="collection-show" class="flat-red " name="permissions[]" id="showCollection"
                    @if($permissions['collection-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showCollection">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="collection-delete" class="flat-red " name="permissions[]" id="deleteCollection"
                    @if($permissions['collection-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteCollection">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
