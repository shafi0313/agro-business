@extends('admin.layout.master')
@section('title', 'Employee')
@section('content')
@php $p='admin'; $sm='empIndex'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Employee</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Employee</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('employee.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Employee
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Name</th>
                                            <th>ID</th>
                                            <th>Designation</th>
                                            <th>Permission</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:4%">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1;@endphp
                                        @foreach($employeeUsers as $employeeUser)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $employeeUser->name }}</td>
                                            <td>{{ $employeeUser->tmm_so_id }}</td>
                                            @if (isset($employeeUser->employeeInfo->designation->name ))
                                            <td>{{ $employeeUser->employeeInfo->designation->name }}</td>
                                            @else
                                            <td></td>
                                            @endif

                                            {{-- @if (isset($employee->permission->role_id))
                                                @php $role = $employee->permission->role_id @endphp
                                            @else
                                                @php $role = '' @endphp
                                            @endif --}}
                                            @if (isset($employeeUser->permission->role_id))
                                                @if ($employeeUser->permission->role_id == 1)
                                                @php $is = 'Admin' @endphp
                                                @elseif($employeeUser->permission->role_id == 2)
                                                @php $is = 'Editor' @endphp
                                                @elseif($employeeUser->permission->role_id == 3)
                                                @php $is = 'Viewer' @endphp
                                                @endif
                                            @else
                                                @php $is = 'No login permission' @endphp
                                            @endif

                                            <td>{{ $is }}</td>
                                            <td>0{{ $employeeUser->phone }}</td>
                                            <td>{{ $employeeUser->email }}</td>
                                            <td>{{ $employeeUser->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{route('employee.edit', $employeeUser->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('employee.destroy', $employeeUser->id) }}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Delete" onclick="return confirm('Are you sure?')">
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
    @include('admin.layout.footer')
</div>

@push('custom_scripts')
@include('admin.include.data_table_js')
@endpush
@endsection

