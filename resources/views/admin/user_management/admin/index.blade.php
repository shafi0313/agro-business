@extends('admin.layout.master')
@section('title', 'Admin User')
@section('content')
@php $p='admin'; $sm='adminIndex'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Admin user</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Admin User</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('admin-user.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Admin User
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
                                            <th>Permission</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:80 px">Action</th>
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
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1;@endphp
                                        @foreach($adminUsers as $adminUser)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>{{ $adminUser->name }}</td>
                                            <td>{{ ($adminUser->is_ == 1) ? 'Admin':'Editor' }}</td>
                                            <td>{{ $adminUser->photo }}</td>
                                            <td>{{ $adminUser->email }}</td>
                                            <td>{{ $adminUser->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin-user.edit', $adminUser->id) }}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    {{-- <a href="admin/users/destroy/{{$adminUser->id}}" data-toggle="tooltip" title="" class="btn btn-link btn-danger delete" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </a> --}}
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

