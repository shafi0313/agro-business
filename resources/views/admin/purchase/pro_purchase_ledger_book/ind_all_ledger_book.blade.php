@extends('admin.layout.master')
@section('title', 'Product Purchase Ledger Book')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Factory</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Bulk</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('purchaseLedgerBook.index') }}">Product Purchase Ledger Book</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Report</li>
                </ul>
                {{-- <a href="{{ route('purchaseLedgerBook.showInvoiceAllPdf', $supplierInfo->supplier->id) }}" class="btn btn-round btn-success ml-auto btn-sm" style="width:150px">PDF <i class="fas fa-download"></i></a> --}}
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                {{-- <h4 class="card-title">Stock</h4> --}}
                                <button type="button" class="btn btn-success btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>

                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2><strong>Supplier Name: </strong>{{$supplierInfo->supplier->business_name}}</h2>
                                    <h2><strong>Proprietor: </strong>{{$supplierInfo->supplier->name}}</h2>
                                    <p>
                                        <span><strong>Supplier Phone: </strong>{{$supplierInfo->supplier->phone}}</span><br>
                                        <span><strong>Supplier Address: </strong>{{$supplierInfo->supplier->address}}</span><br>
                                    </p>

                                </div>
                                <div class="col-md-6 text-right my-auto">
                                    {{-- <h3 style="font-weight:bold;">Form: {{ \Carbon\Carbon::parse($form_date)->format('d/m/Y') }} To: {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}</h3> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th style="width:35px">SL</th>
                                            <th>Date</th>
                                            <th>Cha. No.</th>
                                            <th>TRN/Type & Desc</th>
                                            <th>Purchase Amt</th>
                                            <th>Pymt Date</th>
                                            <th>Pymt Vouc. No</th>
                                            <th>Payment By</th>
                                            <th>Particulars</th>
                                            <th style="width:150px">Pymt. Amount</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        <tr>
                                            <th colspan="4">Opening</th>
                                            <th class="text-right">{{ number_format($openingBl->purchase_amt,2) }}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-right">{{ number_format($openingBl->payment,2) }}</th>
                                            @php
                                                $openingBlCal = $openingBl->purchase_amt - $openingBl->payment;
                                            @endphp
                                            <th class="text-right">{{ number_format($openingBlCal,2) }}</th>
                                        </tr>
                                        @foreach($invoices as $invoice)
                                        <tr class="{{ ($invoice->invoice_status == "1")? 'text-danger' : '' }}">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>

                                            @php $invoiceText = '' @endphp
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
                                            @elseif($invoice->type == "26")
                                            @php $invoiceText = 'Payment' @endphp
                                            @endif

                                            @php
                                                $m_r_no = '';
                                                $note = '';
                                            @endphp

                                            @if (isset($invoice->account_id))
                                                @php $m_r_no = $invoice->account->m_r_no @endphp
                                                @php $note = $invoice->account->note @endphp
                                            @endif

                                            <td>{{ $invoiceText }}</td>
                                            <td class="text-right">{{ number_format(abs($invoice->purchase_amt),2) }}</td>

                                            @if (isset($invoice->account_id))
                                                <td>{{ \Carbon\Carbon::parse($invoice->account->m_r_date)->format('d/m/Y') }}</td>
                                            @else
                                                <th></th>
                                            @endif

                                            <td>{{ $m_r_no }}</td>
                                            @if(isset($invoice->account->payment_by))
                                                <td class="text-center">{{ $invoice->account->payment_by }}</td>
                                            @else
                                                <th></th>
                                            @endif

                                            <td>{{ $note }}</td>
                                            <td class="text-right">{{ number_format($invoice->payment,2) }}</td>

                                            @php $b = $invoice->purchase_amt - $invoice->payment;@endphp
                                            <td class="text-right">{{ number_format($openingBlCal + $balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: right;font-weight: bold; font-size: 14px !important}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Total Amount: </td>
                                            <td>{{ number_format($openingBlCal+$invoices->sum('purchase_amt'),2) }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ number_format($invoices->sum('payment'),2) }}</td>
                                            <td>{{ number_format($openingBlCal+$invoices->sum('purchase_amt') - $invoices->sum('payment'),2) }}</td>

                                        </tr>
                                    </tfoot>
                                </table>
                                @include('admin.include.footer_signature2')
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
@include('admin.include.printJS')

@endpush
@endsection

