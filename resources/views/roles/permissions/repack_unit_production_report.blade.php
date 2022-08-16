<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Repack Unit Production Report @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Repack Unit Production Report'])</p>
        <div>
            <input type="checkbox" value="repack-unit-production-report-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageRepackUnitProductionReport" name="permissions[]" id="ManageRepackUnitProductionReport"
                @if($permissions['repack-unit-production-report-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageRepackUnitProductionReport">
                @lang('role.yes-allow', ['attribute'=> 'Repack Unit Production Report'])
            </label>
        </div>
    </div>
</div>
