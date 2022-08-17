<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Sample Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Sample Report'])</p>
        <div>
            <input type="checkbox" value="sample-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSampleReport" name="permissions[]" id="ManageSampleReport"
                @if($permissions['sample-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSampleReport">
                @lang('role.yes-allow', ['attribute'=> 'Sample Report'])
            </label>
        </div>
    </div>
</div>
