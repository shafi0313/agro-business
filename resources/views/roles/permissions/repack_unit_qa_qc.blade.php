<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Repack Unit Qa/Qc @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Repack Unit Qa/Qc'])</p>
        <div>
            <input type="checkbox" value="repack-unit-qa/qc-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageRepackUnitQaQc" name="permissions[]" id="ManageRepackUnitQaQc"
                @if($permissions['repack-unit-qa/qc-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageRepackUnitQaQc">
                @lang('role.yes-allow', ['attribute'=> 'Repack Unit Qa/Qc'])
            </label>
        </div>
        <div style="@if($permissions['repack-unit-qa/qc-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageRepackUnitQaQc">
            <div>
                <input type="checkbox" value="repack-unit-qa/qc-show" class="flat-red " name="permissions[]" id="showRepackUnitQaQc"
                    @if($permissions['repack-unit-qa/qc-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showRepackUnitQaQc">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="repack-unit-qa/qc-accept-or-reject" class="flat-red " name="permissions[]" id="acceptOrRejectRepackUnitQaQc"
                    @if($permissions['repack-unit-qa/qc-accept-or-reject']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="acceptOrRejectRepackUnitQaQc">
                    Accept Or Reject
                </label>
            </div>
        </div>
    </div>
</div>
