@extends('admin.layout.master')
@section('title', 'Sales ledger Book All')
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
                {{-- <a href="{{ route('purchaseLedgerBook.showInvoicePdf', [$supplierInfo->supplier->id, $form_date, $to_date]) }}" class="btn btn-round btn-success ml-auto btn-sm" style="width:150px">PDF <i class="fas fa-download"></i></a> --}}
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Invoice. No.</th>
                                            <th>Sales Amount</th>
                                            <th>Category</th>
                                            <th>Received By<//th>
                                            <th>Note</th>
                                            <th style="width:150px">Received</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($invoices as $invoice)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $invoice->customer->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>

                                            @case(0)
                                                @php $invoiceText = 'Previous' @endphp
                                                @break
                                            @case(1)
                                                @php $invoiceText = 'Cash Sales' @endphp
                                                @break
                                            @case(2)
                                                @php $invoiceText = 'Cash Return' @endphp
                                                @break
                                            @case(3)
                                                @php $invoiceText = 'Credit Sales' @endphp
                                                @break
                                            @case(4)
                                                @php $invoiceText = 'Credit Return' @endphp
                                                @break
                                            @case(5)
                                                @php $invoiceText = 'Sample' @endphp
                                                @break
                                            @case(7)
                                                @php $invoiceText = 'Bulk Sales' @endphp
                                                @break
                                            @case(16)
                                                @php $invoiceText = 'Bulk Ca. Sales' @endphp
                                                @break
                                            @case(17)
                                                @php $invoiceText = 'Bulk Ca. Return' @endphp
                                                @break
                                            @case(18)
                                                @php $invoiceText = 'Bulk Cr. Sales' @endphp
                                                @break
                                            @case(19)
                                                @php $invoiceText = 'Bulk Cr. Return' @endphp
                                                @break
                                            @case(25)
                                                @php $invoiceText = 'Collection' @endphp
                                                @break
                                            @default
                                                @php $invoiceText = 'Error' @endphp
                                            @endswitch

                                            <td>{{ $invoiceText }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>
                                            <td class="text-right">{{ number_format(abs($invoice->sales_amt),2) }}</td>
                                            <td class="text-center">
                                                @if (isset($invoice->accEntity->name))
                                                {{ $invoice->accEntity->name }}
                                                @else

                                                @endif
                                            </td>
                                            <td class="text-center">{{ $invoice->payment_by }}</td>
                                            <td>{{ $invoice->note }}</td>
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
                                            <td colspan="5">Total Amount: </td>
                                            <td>{{ number_format($salesAmt->sum('sales_amt'),2) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($salesAmt->sum('payment'),2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div>
                                    <h2 class="text-right"><strong>Total Due: {{ number_format($salesAmt->sum('sales_amt') - $payment->sum('payment'),2) }}</strong></h2>
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

