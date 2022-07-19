@extends('admin.layout.master')
@section('title', 'Product Pack Size')
@section('content')
@php $p = 'tools'; $sm="packSize"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                    <a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Product Pack Size</ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">All Size</h4>
                                <a class="btn btn-primary btn-round ml-auto text-light" data-toggle="modal" data-target="#addPackSize"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th style="width: 6%">SL</th>
                                            <th>For</th>
                                            <th>Size</th>
                                            <th class="no-sort" style="text-align:center;width:80px" >Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach ($PackSizes as $PackSize)
                                        <tr>
                                            <td class="text-center">{{ $x++ }} </td>
                                            <td>{{ ($PackSize->type=='1')?'Product':'Bulk' }} </td>
                                            <td>{{ $PackSize->size }} </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('pack-size.edit', $PackSize->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('pack-size.destroy', $PackSize->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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

@push('custom_scripts')
@include('admin.include.data_table_js')
@endpush
@endsection

