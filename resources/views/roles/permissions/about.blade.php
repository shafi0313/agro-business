<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">About @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'About'])</p>
        <div>
            <input type="checkbox" value="about-edit" class="flat-red hasChildOptions"
                data-child_id="childOfManageAbout" name="permissions[]" id="ManageAbout"
                @if($permissions['about-edit']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageAbout">
                @lang('role.yes-allow', ['attribute'=> 'About'])
            </label>
        </div>
    </div>
</div>
