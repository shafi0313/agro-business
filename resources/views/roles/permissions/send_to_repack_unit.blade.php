<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Send to Repack Unit @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Send to Repack Unit'])</p>
        <div>
            <input type="checkbox" value="send-to-repack-unit-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageSendToRepackUnit" name="permissions[]" id="ManageSendToRepackUnit"
                @if($permissions['send-to-repack-unit-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageSendToRepackUnit">
                @lang('role.yes-allow', ['attribute'=> 'Send to Repack Unit'])
            </label>
        </div>
        <div style="@if($permissions['send-to-repack-unit-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageSendToRepackUnit">
            <div>
                <input type="checkbox" value="send-to-repack-unit-send" class="flat-red " name="permissions[]" id="createSendToRepackUnit"
                    @if($permissions['send-to-repack-unit-send']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createSendToRepackUnit">
                    Send
                </label>
            </div>
            <div>
                <input type="checkbox" value="send-to-repack-unit-show" class="flat-red " name="permissions[]" id="showSendToRepackUnit"
                    @if($permissions['send-to-repack-unit-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showSendToRepackUnit">
                    @lang('app.show')
                </label>
            </div>
            <div>
                <input type="checkbox" value="send-to-repack-unit-accept" class="flat-red " name="permissions[]" id="acceptSendToRepackUnit"
                    @if($permissions['send-to-repack-unit-accept']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="acceptSendToRepackUnit">
                    Accept
                </label>
            </div>
            <div>
                <input type="checkbox" value="send-to-repack-unit-reject" class="flat-red " name="permissions[]" id="rejectSendToRepackUnit"
                    @if($permissions['send-to-repack-unit-reject']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="rejectSendToRepackUnit">
                    Reject
                </label>
            </div>
        </div>
    </div>
</div>
