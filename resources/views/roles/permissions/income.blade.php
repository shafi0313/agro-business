<div class="form-row my-5">
    <div class="col-sm-3">
        <label for="title">Income @lang('app.moderation')</label>
    </div>
    <div class="col-sm-9">
        <p>@lang('role.do-you', ['plugin'=> 'Income'])</p>
        <div>
            <input type="checkbox" value="income-manage" class="flat-red hasChildOptions"
                data-child_id="childOfManageIncome" name="permissions[]" id="ManageIncome"
                @if($permissions['income-manage']==1) checked @endif>
            <label class="chk-label-margin mx-1" for="ManageIncome">
                @lang('role.yes-allow', ['attribute'=> 'Income'])
            </label>
        </div>
        <div style="@if($permissions['income-manage'] == 1) display:block @else display:none @endif"
            id="childOfManageIncome">
            <div>
                <input type="checkbox" value="income-add" class="flat-red " name="permissions[]" id="createIncome"
                    @if($permissions['income-add']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="createIncome">
                    @lang('app.create')
                </label>
            </div>
            <div>
                <input type="checkbox" value="income-show" class="flat-red " name="permissions[]" id="showIncome"
                    @if($permissions['income-show']==1) checked @endif>
                <label class="chk-label-margin mx-1" for="showIncome">
                    @lang('app.show')
                </label>
            </div>
        </div>
    </div>
</div>
