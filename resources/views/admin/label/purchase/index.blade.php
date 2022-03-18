@extends('admin.layout.master')
@section('title', 'Label Purchase')
@section('content')
@php $p='factory'; $sm="labelPurchase"; $ssm = 'packaging' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Label Purchase</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Supplier</h4>
                                <a class="btn btn-success btn-sm  ml-auto" href="{{ route('labelPurchase.selectDate') }}">
                                    All Challan By Date
                                </a>
                                <a class="btn btn-primary btn-sm ml-3" href="{{ route('labelPurchase.allInvoice') }}">
                                    All Challan
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
                                            <th>Supplier Id</th>
                                            <th>Proprietor</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:150px;text-align:center">Invoice</th>
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
                                        @foreach($suppliers as $supplier)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $supplier->business_name }}</td>
                                            <td>{{ $supplier->tmm_so_id }}</td>
                                            <td>{{ $supplier->name }}</td>
                                            <td>0{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('labelPurchase.create',$supplier->id) }}">Purchase</a>
                                                <span>||</span>
                                                <a href="{{ route('label-purchase.show',$supplier->id)}}">Show</a>
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

