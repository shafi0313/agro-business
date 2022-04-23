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
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            <div class="row">
                                <style>

                                </style>
                                <div class="col-md-12">
                                    @include('admin.include.ledger_header')
                                </div>
                            </div>
                            <div class="table-responsive" id="printJS-form">
                                <table  class="table table-bordered table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th style="width:35px">SL</th>
                                            <th width="80px">Date</th>
                                            <th class="text-center">Inv.No.</th>
                                            <th width="80px">TRN/Type & Desc</th>
                                            <th>Sales Amt</th>
                                            <th>Dis. %</th>
                                            <th>Dis. Amt</th>
                                            <th>Net Amt</th>
                                            <th width="80px">Pymt/Rcpt Date</th>
                                            <th width="80px">Money Rcpt. No</th>
                                            <th width="60px">Collection By</th>
                                            <th>Particulars</th>
                                            <th width="30px">Pymt Alert</th>
                                            <th style="width:150px">Coll. Amount</th>
                                            <th>Balance</th>
                                            <th width="30px" class="no-print">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($invoices as $invoice)
                                        @php
                                            $pAlart = '';
                                            $date = date('Ymd');
                                            $payment_date = \Carbon\Carbon::parse($invoice->payment_date)->format('Ymd') ;
                                            $c_status = $invoice->c_status;
                                            if ($payment_date < $date && $c_status== 0 && $invoice->inv_cancel==0) {
                                                $pAlart = 'Dft.';
                                            }
                                        @endphp
                                        {{-- {{($invoice->inv_cancel!=0)?'text-danger':''}} --}}
                                        <tr class="{{($invoice->c_status==1)?'text-primary':''}} {{($pAlart!='')? 'text-danger':''}}">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>

                                            @if ($invoice->invoice_no==0 || $invoice->invoice_no==-1)
                                                @php $inv = '' @endphp
                                            @else
                                                @php $inv = $invoice->invoice_no @endphp
                                            @endif

                                            {{-- Invoice symble --}}
                                            @if ($invoice->inv_cancel==1)
                                                @php $inv_cancel = "<i class='far fa-times-circle'></i>" @endphp
                                            @elseif ($invoice->inv_cancel==2)
                                                @php $inv_cancel = "<i class='far fa-question-circle'></i>" @endphp
                                            @elseif($invoice->c_status==1)
                                                @php $inv_cancel = '<i class="far fa-check-circle"></i> '  @endphp
                                            @else
                                                @php $inv_cancel = ''  @endphp
                                            @endif
                                            <td class="text-center"> {!! $inv_cancel !!}{{ $inv }}</td>

                                            @switch($invoice->type)
                                            @case(0)
                                                @php $invoiceText = 'Previous' @endphp
                                                @break
                                            @case(1)
                                                @php $invoiceText = 'Cash Sales' @endphp
                                                @break
                                            @case(2)
                                                @php $invoiceText = 'Return Cash Sales' @endphp
                                                @break
                                            @case(3)
                                                @php $invoiceText = 'Credit Sales' @endphp
                                                @break
                                            @case(4)
                                                @php $invoiceText = 'Return Credit Sales' @endphp
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

                                            <td> {{ $invoiceText }} </td>

                                            <td class="text-right">{{ number_format(abs($invoice->sales_amt),2) }}</td>

                                            @if ($invoice->type=="25")
                                                @php $pro_dis = 0  @endphp
                                            @else
                                                @php $pro_dis = $invoice->invoice->avg('pro_dis')  @endphp
                                            @endif
                                            <td class="text-center">{{ number_format($invoice->discount + $pro_dis,2) }}</td>
                                            <td class="text-right">{{ number_format($invoice->discount_amt,2)}}</td>
                                            @if ($invoice->invoice_no==0)
                                            @php $net_amt = 0; @endphp
                                            @else
                                            @php $net_amt = $invoice->net_amt; @endphp
                                            @endif
                                            <td class="text-right">{{ number_format(abs($net_amt),2) }}</td>

                                            @if(isset($invoice->account->m_r_date))
                                                <td>{{ \Carbon\Carbon::parse($invoice->account->m_r_date)->format('d/m/Y') }}</td>
                                            @else
                                                <td>{{ \Carbon\Carbon::parse($invoice->payment_date)->format('d/m/Y') }}</td>
                                            @endif

                                            @if(isset($invoice->account->m_r_no))
                                                <td class="text-center">{{ $invoice->account->m_r_no }}</td>
                                            @else
                                                <th></th>
                                            @endif

                                            @if(isset($invoice->account->payment_by))
                                                <td class="text-center">{{ $invoice->account->payment_by }}</td>
                                            @else
                                                <th></th>
                                            @endif
                                            <td>{{$invoice->inv_cancel==1?'Invoice Cancel':($invoice->inv_cancel==2?'Reinvoice':'')}} {{ $invoice->account->note ??'' }}</td>
                                            <th title="Defaulter">{{ $pAlart }} </th>
                                            <td class="text-right">{{ number_format($invoice->payment,2) }}</td>
                                            @php
                                                $b = $invoice->net_amt - $invoice->payment;
                                            @endphp
                                            <td class="text-right" style="font-weight: bold">{{ number_format($balance += $b,2) }}</td>
                                            @if (($invoice->type != 25) && ($invoice->invoice_no != 0))
                                            <td class="text-center no-print">
                                                <div class="form-button-action">
                                                    <a href="{{ route('salesLedgerBook.ledgerReportEdit', $invoice->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: right;font-weight: bold; font-size: 14px !important}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Total Amount: </td>
                                            <td>{{ number_format($invoices->sum('sales_amt'),2) }}</td>
                                            <td></td>
                                            <td>{{ number_format($invoices->sum('discount_amt'),2) }}</td>
                                            @php $net_amtTotal = $invoices->sum('net_amt') - $invoices->where('invoice_no', 0)->sum('net_amt'); @endphp
                                            <td>{{ number_format($net_amtTotal,2) }}</td>
                                            <td colspan="5"></td>
                                            <td>{{ number_format($invoices->sum('payment'),2) }}</td>
                                            <td>{{ number_format($invoices->sum('net_amt') - $payment,2) }}</td>
                                        </tr>
                                    </tfoot>
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
@include('admin.include.printJS')

@endpush
@endsection

