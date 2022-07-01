@extends('admin.layout.master')
@section('title', 'Author Ledger Book')
@section('content')
@php $p = 'account'; $sm='autherLedger' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('authorLedgerBook.index') }}">Author Ledger Book</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Report</li>
                </ul>
            </div>
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
                                @include('admin.include.author_ledger_header')
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Date</th>
                                            <th>By</th>
                                            <th>Note</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($reports as $report)
                                        <tr class="{{ ($report->invoice_status == "1")? 'bg-danger text-light' : '' }}">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ \Carbon\Carbon::parse($report->invoice_date)->format('d/m/Y') }}</td>
                                            <td>{{ $report->payment_by }}</td>
                                            <td class="text-center">{{ $report->note }}</td>
                                            <td class="text-right">{{ number_format($report->debit,2) }}</td>
                                            <td class="text-right">{{ number_format($report->credit,2) }}</td>
                                            @php
                                                $b = $report->credit - $report->debit;
                                            @endphp
                                            <td class="text-right">{{ number_format($balance +=$b,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: right;font-weight: bold; font-size: 14px !important}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Total: </td>
                                            <td>{{ number_format($reports->sum('debit'),2) }}</td>
                                            <td>{{ number_format($reports->sum('credit'),2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div>
                                    <h2 class="text-right"><strong>Total Dues: {{ number_format($reports->sum('credit') - $reports->sum('debit'),2) }}</strong></h2>
                                </div>
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

