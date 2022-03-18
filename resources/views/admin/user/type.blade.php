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
                <div class="col-md-6">
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
                            <div class="form-group ">
                                <label for="">Type <span class="t_r">*</span></label>
                                <select class="form-control" name="role" onchange="location = this.value">
                                    <option selected value disble>Select</option>
                                    <option value="{{route('customer.create')}}">Customer</option>
                                    <option value="3">Supplier</option>
                                    <option value="4">Factory</option>
                                    <option value="5">Employee</option>
                                    <option value="6">Store</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom_scripts')
@endpush
@endsection

