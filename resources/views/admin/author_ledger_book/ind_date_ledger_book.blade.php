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
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3><strong>Name: </strong>{{$authorInfo->name}}</h3>
                                    <p>
                                        <span><strong>ID: </strong>{{$authorInfo->tmm_so_id}}</span><br>
                                        <span><strong>Designation: </strong>{{$employeeInfo->designation->name}}</span><br>
                                        <span><strong>Job Location: </strong>{{$employeeInfo->job_loc}}</span><br>
                                        <span><strong>Phone: </strong>{{$authorInfo->phone}}</span><br>
                                        <span><strong>Address: </strong>{{$authorInfo->address}}</span><br>
                                    </p>
                                </div>
                                <div class="col-md-6 text-right my-auto">
                                    <h3 style="font-weight:bold;">Form: {{ \Carbon\Carbon::parse($form_date)->format('d/m/Y') }} To: {{ \Carbon\Carbon::parse($to_date)->format('d/m/Y') }}</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
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

