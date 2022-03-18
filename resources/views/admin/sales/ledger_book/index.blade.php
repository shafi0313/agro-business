@extends('admin.layout.master')
@section('title', 'Sales ledger Book')
@section('content')
@php $p='sales'; $sm="salesLedger"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Sales ledger Book</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Customers</h4>
                                {{-- <a class="btn btn-success btn-sm  ml-auto" href="{{ route('LabelPurchase.selectDate') }}">
                                    All Challan By Date
                                </a> --}}
                                <a class="btn btn-primary btn-sm ml-3 ml-auto" href="{{ route('salesLedgerBook.allShowInvoice') }}">
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
                                            <th>Customer Name</th>
                                            <th>Proprietor</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Alert</th>
                                            <th class="no-sort" style="width:170px;text-align:center">Report</th>
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
                                        @foreach($customers as $customer)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $customer->business_name }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->address }}</td>

                                            @php $paymentAlert = $customer->invoice->count() @endphp
                                            <td class="text-center"><span class="{{$paymentAlert>0?'badge badge-danger':''}}">{{ $paymentAlert>0?$paymentAlert:'' }}</span></td>

                                            <td class="text-center">
                                                <a href="{{ route('salesLedgerBook.indAllLedgerBook', $customer->id)}}">Show All</a>
                                                <span> || </span>
                                                <a href="{{ route('salesLedgerBook.SelectDate', $customer->id)}}">Show By Date</a>
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

