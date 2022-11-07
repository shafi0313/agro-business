@extends('admin.layout.master')
@section('title', 'Sales of Cash')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Sales</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Sales</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Customer</h4>
                                <a class="btn btn-success btn-sm  ml-auto" href="{{ route('salesInvoiceCash.selectDate') }}">
                                    All Challan & Invoice By Date
                                </a>
                                <a class="btn btn-primary btn-sm ml-3" href="{{ route('salesInvoiceCash.allInvoice') }}">
                                    All Challan & Invoice
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:40px">SN</th>
                                            <th>Customer Name</th>
                                            <th>Proprietor</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:130px;text-align:center">Invoice</th>
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
                                            <td>{{ $supplier->name }}</td>
                                            <td>0{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('purchaseProduct.Create',$supplier->id) }}">Purchase</a>
                                                <span>||</span>
                                                <a href="{{ route('product-purchase.show', $supplier->id)}}">Show</a>
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

