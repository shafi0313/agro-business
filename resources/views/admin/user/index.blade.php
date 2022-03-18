@extends('admin.layout.master')
@section('title', 'Business Person/Factory')
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
                    <li class="nav-item active">Business Person/Factory</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Business Person/Factory</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('user.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Business Person/Factory
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Business Name</th>
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
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>

                                            @if ($user->role==2)
                                            @php $role = 'Customer' @endphp
                                            @elseif($user->role==3)
                                            @php $role = 'Supplier' @endphp
                                            @elseif($user->role==4)
                                            @php $role = 'Factory' @endphp
                                            @elseif($user->role==6)
                                            @php $role = 'Store' @endphp
                                            @endif

                                            <td>{{ $role }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->business_name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('user.edit', $user->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.destroy',$user->id)}}" style="display: initial;" method="POST">
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

