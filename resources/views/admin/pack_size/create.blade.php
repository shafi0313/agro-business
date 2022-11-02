@can('pack-size-add')
<!-- Modal -->
<div class="modal fade" id="addPackSize" tabindex="-1" role="dialog" aria-labelledby="addPackSizeLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPackSizeLabel">Add New Pack Size</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{route('pack-size.store')}}" method="POST">
                @csrf
                <div class="form-check">
                    <label>For <span class="t_r">*</span></label><br>
                    <label class="form-radio-label">
                        <input class="form-radio-input" type="radio" name="type" value="2">
                        <span class="form-radio-sign">For Balk Name</span>
                    </label>

                    <label class="form-radio-label ml-3">
                        <input class="form-radio-input" type="radio" name="type" value="1">
                        <span class="form-radio-sign">For Product</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="size" class="col-sm-2 control-label">Size <span class="t_r">*</span></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="size" name="size" placeholder="Enter Size"
                            required>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
    </div>
</div>
</div>
  @endcan
