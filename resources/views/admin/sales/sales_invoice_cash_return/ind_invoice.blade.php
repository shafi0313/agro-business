@extends('admin.layout.master')
@section('title', 'Sales of Cash Return Invoice')
@section('content')
@php $p='sales'; $sm='salesCashRe' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Sales of Cash Return Invoice</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">All Invoice List</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h2><strong>Customer Name: </strong>{{$customerInfo->customer->business_name}}</h2>
                                    <h2><strong>Proprietor: </strong>{{$customerInfo->customer->name}}</h2>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw text-center">
                                        <tr>
                                            <th style="width:40px">SL</th>
                                            <th>Challan No</th>
                                            <th>Invoice No</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th class="no-sort text-center" style="width:120px">Print</th>
                                            {{-- <th class="no-sort text-center" style="width:60px">Report</th> --}}
                                            {{-- <th class="no-sort text-center" style="width:60px">Action</th> --}}
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
                                        @foreach($customerInvoices as $customerInvoice)
                                        <tr class="text-center">
                                            @php $invoice = $customerInvoice->first();@endphp

                                            <td class="text-center">{{ $x++ }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>
                                            <td class="text-center">{{ $invoice->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-right">{{ number_format($customerInvoice->sum('amt'),2) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('salesInvoiceCashReturn.printInvoice', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Invoice</a>

                                                <span> | </span>
                                                <a href="{{ route('salesInvoiceCashReturn.printChallan', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Challan</a>

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

