@extends('admin.layout.master')
@section('title', 'Purchase ledger Book All')
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
                    <li class="nav-item"><a href="{{ route('ledgerBook.index') }}">Purchase ledger Book</a></li>
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
                                            <th>Challan. No.</th>
                                            <th>Purchase Amount</th>
                                            <th>Category</th>
                                            <th>Payment By<//th>
                                            <th>Note</th>
                                            <th style="width:150px">Payment</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($invoices as $invoice)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $invoice->supplier->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>

                                            @if ($invoice->type == "7")
                                            @php $invoiceText = 'Bulk' @endphp
                                            @elseif($invoice->type == "9")
                                            @php $invoiceText = 'Bulk Send To Repack Unit' @endphp
                                            @elseif($invoice->type == "11")
                                            @php $invoiceText = 'Bulk Send To Repack Production' @endphp
                                            @elseif($invoice->type == "13")
                                            @php $invoiceText = 'Label' @endphp
                                            @elseif($invoice->type == "15")
                                            @php $invoiceText = 'Label Send To Repack Unit' @endphp
                                            @elseif($invoice->type == "25")
                                            @php $invoiceText = 'Payment' @endphp
                                            @endif

                                            <td>{{ $invoiceText }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>
                                            <td class="text-right">{{ number_format(abs($invoice->purchase_amt),2) }}</td>
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
                                                $b = $invoice->purchase_amt - $invoice->payment;
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
                                            <td>{{ number_format($purchaseAmt->sum('purchase_amt'),2) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($purchaseAmt->sum('payment'),2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div>
                                    <h2 class="text-right"><strong>Total Due: {{ number_format($purchaseAmt->sum('purchase_amt') - $payment->sum('payment'),2) }}</strong></h2>
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

