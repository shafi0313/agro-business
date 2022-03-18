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
                    <li class="nav-item"><a href="{{ route('salesLedgerBook.index') }}">Sales ledger Book</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Report</li>
                </ul>
                {{-- <a href="{{ route('purchaseLedgerBook.showInvoicePdf', [$customer_Info->customer->id, $form_date, $to_date]) }}" class="btn btn-round btn-success ml-auto btn-sm" style="width:150px">PDF <i class="fas fa-download"></i></a> --}}
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2><strong>Customer Name: </strong>{{$customer_Info->name}}</h2>
                                    <p>
                                        <span><strong>Customer Phone: </strong>{{$customer_Info->phone}}</span><br>
                                        <span><strong>Customer Address: </strong>{{$customer_Info->address}}</span><br>
                                        <span><strong>Credit Limit: </strong>{{$customer_Info->customerInfo->credit_limit}}</span><br>
                                    </p>
                                </div>
                                <div class="col-md-6 text-right my-auto">
                                    <h3 style="font-weight:bold;">Form: {{ \Carbon\Carbon::parse($form_date)->format('d/m/Y') }} To: {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Date</th>
                                            <th>Challan No.</th>
                                            <th>Amount</th>
                                            <th>Sales Name</th>
                                            <th>Received By</th>
                                            <th style="width:150px">Received</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($invoices as $invoice)
                                        <tr class="{{ ($invoice->invoice_status == "1")? 'text-danger' : '' }}">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>
                                            <td class="text-right">{{ number_format(abs($invoice->sales_amt),2) }}</td>
                                            <td class="text-center">{{ $invoice->note }}</td>
                                            <td class="text-center">{{ $invoice->payment_by }}</td>
                                            <td class="text-right">{{ number_format($invoice->payment,2) }}</td>
                                            @php
                                                $b = $invoice->sales_amt - $invoice->payment;
                                            @endphp
                                            <td class="text-right">{{ number_format($balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: right;font-weight: bold; font-size: 14px !important}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Total Amount: </td>
                                            <td>{{ number_format($salesInvoices->sum('sales_amt'),2) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($salesInvoices->sum('payment'),2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div>
                                    <h2 class="text-right"><strong>Total Due: {{ number_format($salesInvoices->sum('sales_amt') - $payment->sum('payment'),2) }}</strong></h2>
                                </div>
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

