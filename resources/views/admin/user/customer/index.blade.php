@extends('admin.layout.master')
@section('title', 'Customer')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Business Person/Factory/Store</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Customer</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Customer List</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('customer.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Customer
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Customer Name</th>
                                            <th>Customer ID</th>
                                            <th>Proprietor</th>
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
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $user->business_name }}</td>
                                            <td>{{ $user->tmm_so_id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('customer.edit', $user->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('customer.destroy',$user->id)}}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
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

@push('custom_scripts')
@include('admin.include.data_table_js')
@endpush
@endsection

