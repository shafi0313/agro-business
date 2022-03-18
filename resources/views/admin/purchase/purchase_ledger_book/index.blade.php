@extends('admin.layout.master')
@section('title', 'Purchase ledger Book')
@section('content')
@php $p='factory'; $sm="purchaseLed"; $ssm='bulkShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Purchase ledger Book</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Suppliers</h4>
                                {{-- <a class="btn btn-success btn-sm  ml-auto" href="{{ route('LabelPurchase.selectDate') }}">
                                    All Challan By Date
                                </a> --}}
                                <a class="btn btn-primary btn-sm ml-3 ml-auto" href="{{ route('purchaseLedgerBook.allShowInvoice') }}">
                                    All Ledger Book
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Supplier Name</th>
                                            <th>Id</th>
                                            <th>Proprietor</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:170px;text-align:center">Report</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($suppliers as $supplier)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $supplier->business_name }}</td>
                                            <td>{{ $supplier->tmm_so_id }}</td>
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('purchaseLedgerBook.indAllLedgerBook', $supplier->id)}}">Show All</a>
                                                <span> || </span>
                                                <a href="{{ route('purchaseLedgerBook.SelectDate', $supplier->id)}}">Show By Date</a>
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

