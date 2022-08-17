<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Production Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Production Report'])</p>
        <div>
            <input type="checkbox" value="production-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageProductionReport" name="permissions[]" id="ManageProductionReport"
                @if($permissions['production-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageProductionReport">
                @lang('role.yes-allow', ['attribute'=> 'Production Report'])
            </label>
        </div>
    </div>
</div>
