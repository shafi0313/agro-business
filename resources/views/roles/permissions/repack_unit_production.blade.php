<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Repack Unit Production @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Repack Unit Production'])</p>
        <div>
            <input type="checkbox" value="repack-unit-production-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageRepackUnitProduction" name="permissions[]" id="ManageRepackUnitProduction"
                @if($permissions['repack-unit-production-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageRepackUnitProduction">
                @lang('role.yes-allow', ['attribute'=> 'Repack Unit Production'])
            </label>
        </div>
        <div style="@if($permissions['repack-unit-production-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageRepackUnitProduction">
            <div>
                <input type="checkbox" value="repack-unit-production-show" class="flat-red " name="permissions[]" id="showRepackUnitProduction"
                    @if($permissions['repack-unit-production-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showRepackUnitProduction">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="repack-unit-production-ongoing" class="flat-red " name="permissions[]" id="ongoingRepackUnitProduction"
                    @if($permissions['repack-unit-production-ongoing']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="ongoingRepackUnitProduction">
                    Ongoing
                </label>
            </div>
            <div>
                <input type="checkbox" value="repack-unit-production-complete" class="flat-red " name="permissions[]" id="completeRepackUnitProduction"
                    @if($permissions['repack-unit-production-complete']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="completeRepackUnitProduction">
                    Complete
                </label>
            </div>
            <div>
                <input type="checkbox" value="repack-unit-production-send-to-store" class="flat-red " name="permissions[]" id="sendToDtoreRepackUnitProduction"
                    @if($permissions['repack-unit-production-send-to-store']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="sendToDtoreRepackUnitProduction">
                    Send to Store
                </label>
            </div>
        </div>
    </div>
</div>
