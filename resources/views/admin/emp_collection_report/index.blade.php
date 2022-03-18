@extends('admin.layout.master')
@section('title', 'Employee Collection Report')
@section('content')
@php $p='tools'; $sm="userIndex"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Employee Collection Report</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Employee Collection Report</h4>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('company-store.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Store
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Employee Name</th>
                                            <th>Designation </th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th class="no-sort text-center" style="width:40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($users->where('employee_main_cat_id',11) as $user)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $user->user->name }}</td>
                                            <td>{{ $user->designation  }}</td>
                                            <td>{{ $user->user->phone }}</td>
                                            <td>{{ $user->user->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('collectionReport.selectDate', $user->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        Select
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @foreach($users->where('employee_main_cat_id',12) as $user)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $user->user->name }}</td>
                                            <td>{{ $user->designation  }}</td>
                                            <td>{{ $user->user->phone }}</td>
                                            <td>{{ $user->user->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('collectionReport.selectDate', $user->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        Select
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @foreach($users->where('employee_main_cat_id',13) as $user)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $user->user->name }}</td>
                                            <td>{{ $user->designation  }}</td>
                                            <td>{{ $user->user->phone }}</td>
                                            <td>{{ $user->user->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('collectionReport.selectDate', $user->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        Select
                                                    </a>
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

@push('custom_scripts')
@include('admin.include.data_table_js')
@endpush
@endsection

