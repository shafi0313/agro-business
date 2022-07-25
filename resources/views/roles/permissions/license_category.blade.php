<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">License Category @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'License Category'])</p>
        <div>
            <input type="checkbox" value="license-category-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageLicenseCategory" name="permissions[]" id="ManageLicenseCategory"
                @if($permissions['license-category-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageLicenseCategory">
                @lang('role.yes-allow', ['attribute'=> 'License Category'])
            </label>
        </div>
        <div style="@if($permissions['license-category-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageLicenseCategory">
            <div>
                <input type="checkbox" value="license-category-add" class="flat-red " name="permissions[]" id="createLicenseCategory"
                    @if($permissions['license-category-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createLicenseCategory">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="license-category-edit" class="flat-red " name="permissions[]" id="editLicenseCategory"
                    @if($permissions['license-category-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editLicenseCategory">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="license-category-delete" class="flat-red " name="permissions[]" id="deleteLicenseCategory"
                    @if($permissions['license-category-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteLicenseCategory">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
