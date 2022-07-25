<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Slider @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Slider'])</p>
        <div>
            <input type="checkbox" value="slider-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSlider" name="permissions[]" id="ManageSlider"
                @if($permissions['slider-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSlider">
                @lang('role.yes-allow', ['attribute'=> 'Slider'])
            </label>
        </div>
        <div style="@if($permissions['slider-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSlider">
            <div>
                <input type="checkbox" value="slider-add" class="flat-red " name="permissions[]" id="createSlider"
                    @if($permissions['slider-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createSlider">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="slider-edit" class="flat-red " name="permissions[]" id="editSlider"
                    @if($permissions['slider-edit']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="editSlider">
                    @lang('app.edit')
                </label>
            </div>
            <div>
                <input type="checkbox" value="slider-delete" class="flat-red " name="permissions[]" id="deleteSlider"
                    @if($permissions['slider-delete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="deleteSlider">
                    @lang('app.delete')
                </label>
            </div>
        </div>
    </div>
</div>
