@extends('admin.layout.master')
@section('title', 'Office Expense')
@section('content')
@php $p = 'tools'; $sm='officeExCat'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Accounts</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Office Expense</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                {{-- <h4 class="card-title">Supplier Table</h4> --}}
                                <button type="button" class="btn btn-primary ml-auto btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    Add New
                                  </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SN</th>
                                            <th >Name</th>
                                            <th style="display: none"></th>
                                            <th class="no-sort text-center" style="width:80px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($officeExpenses as $officeExpense)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $officeExpense->name }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <span class="btn btn-link btn-success btn-lg addSub" data-toggle="modal" data-target="#add-sub" data-id="{{$officeExpense->id}}" data-name="{{$officeExpense->name}}"><i class="fas fa-plus"></i></span>
                                                    <span class="btn btn-link btn-primary edit" data-toggle="modal" data-target="#editModal" data-url="{{route('office-expense-cat.update', $officeExpense->id)}}" data-id="{{$officeExpense->id}}" data-name="{{$officeExpense->name}}"><i class="fa fa-edit"></i></span>
                                                    <form action="{{ route('office-expense-cat.destroy', $officeExpense->id) }}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        @if ($officeExpense->subCat->count() > 0)
                                            @php $xx=1; @endphp
                                            @foreach($officeExpense->subCat as $subOfficeExpense)
                                            <tr>
                                                <td class="text-right">{{ $xx++ }}</td>
                                                <td>{{ $subOfficeExpense->name }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <span class="btn btn-link btn-success btn-lg addSubEdit" data-toggle="modal" data-url="{{route('officeExpense.subCatEdit', $subOfficeExpense->id)}}" data-target="#add-sub-edit" data-id="{{$subOfficeExpense->id}}" data-name="{{$subOfficeExpense->name}}" data-parent_name="{{$subOfficeExpense->subCatName->name}}"><i class="fas fa-edit"></i></span>
                                                    <form action="{{ route('office-expense-cat.destroy', $subOfficeExpense->id) }}" style="display: initial;" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
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

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Add Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add New Office Expense</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="{{ route('office-expense-cat.store')}}" method="post" onSubmit="return validate()">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Name <span class="t_r">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModal">Edit Office Expense</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="editForm">
                <div class="modal-body">
                    @csrf @method('put')
                    <input type="hidden" id="office_expense_id" name="office_expense_id">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  id="edit-name" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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

<!-- Add Sub Cat Modal -->
<div class="modal fade" id="add-sub" tabindex="-1" role="dialog" aria-labelledby="add-subLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('officeExpense.subCatStore')}}" method="post">
            @csrf
            <input type="hidden" id="addId" name="parent_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-subLabel" style="color:red;">Add New Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Main Category Name</label>
                            <input type="text" id="addName" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Sub Category Name <span class="t_r">*</span></label>
                            <input name="name" type="text" class="form-control">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Sub Cat edit Modal -->
<div class="modal fade" id="add-sub-edit" tabindex="-1" role="dialog" aria-labelledby="add-sub-editLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="subEditForm">
            @csrf @method('put')
            <input type="hidden" id="subEditId" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-sub-editLabel" style="color:red;">Sub Category Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Sub Category Name <span class="t_r">*</span></label>
                            {{-- <input name="name" type="text" class="form-control" id="subEditParentName"> --}}
                            <select name="parent_id" id="" class="form-control">
                                <option id="subEditParentName"></option>
                                @foreach ($officeExpenses as $officeExpense)
                                <option value="{{ $officeExpense->id }}">{{ $officeExpense->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Sub Category Name <span class="t_r">*</span></label>
                            <input name="name" type="text" class="form-control" id="subEditName">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


@push('custom_scripts')

<script>
    $(".addSub").on('click', function(){
        $('#addId').val($(this).data('id'));
        $('#addName').val($(this).data('name'));
    });

    $(".addSubEdit").on('click', function(){
        $('#subEditForm').attr('action',$(this).data('url'));
        $('#subEditId').val($(this).data('id'));
        $('#subEditName').val($(this).data('name'));
        $('#subEditParentName').text($(this).data('parent_name'));
    });


    $(".edit").on('click', function(){
        $('#editForm').attr('action',$(this).data('url'));
        $('#edit-name').val($(this).data('name'));
        $('#office_expense_id').val($(this).data('id'));
    });
</script>

@include('admin.include.data_table_js')
@endpush
@endsection

