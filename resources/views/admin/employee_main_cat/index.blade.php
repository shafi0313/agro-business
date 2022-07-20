@extends('admin.layout.master')
@section('title', 'Employee Category')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                    <a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Tools</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Employee Category</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Employee Category</h4>
                                <a class="btn btn-primary btn-round ml-auto text-light" data-toggle="modal" data-target="#addEmpCat"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th class="no-sort" style="text-align:center;width:80px" >Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach ($employeeMainCats as $employeeMainCat)
                                        <tr>
                                            <td class="text-center">{{ $x++ }} </td>
                                            <td>{{ $employeeMainCat->name }} </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('employee-main-cat.edit', $employeeMainCat->id) }}" title="Edit" class="btn btn-link btn-primary btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('employee-main-cat.destroy', $employeeMainCat->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Are you sure?')">
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


  @can('employee-category-add')
<!-- Modal -->
<div class="modal fade" id="addEmpCat" tabindex="-1" role="dialog" aria-labelledby="addEmpCatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEmpCatLabel">Add Employee Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('employee-main-cat.store')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Name <span class="t_r">*</span></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="name" placeholder="Enter Category Name" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
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

