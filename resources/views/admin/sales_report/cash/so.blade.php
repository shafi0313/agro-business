@extends('admin.layout.master')
@section('title', 'Employee Sales Report')
@section('content')
@php $p='report'; $sm="empReport"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Employee Sales Report</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Employee Sales Report</h4>
                                <button type="button" class="btn btn-primary btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('company-store.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Store
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="printableArea">
                                <br><br>
                                @php $pageTitle='Employee Sales Report' @endphp
                                @include('admin.include.print_page_heading')
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th rowspan="2" style="width:35px">SL</th>
                                            <th rowspan="2">Name</th>
                                            <th rowspan="2">Job Location</th>
                                            <th colspan="3">Sales</th>
                                            <th colspan="2">Collection</th>
                                            <th rowspan="2">Balance</th>
                                        </tr>
                                        <tr class="text-center">

                                            <th>Cash</th>
                                            <th>Credit</th>
                                            <th>Total Amt</th>
                                            <th>Cash</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($reports->groupby('so_id') as $report)
                                        @php $sReport = $report->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><span style="padding-left: 50px"></span>{{ $sReport->so->name }}</td>
                                            <td>{{ $sReport->user->job_loc }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->where('inv_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->where('inv_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->where('inv_type',1)->sum('amt') + $report->where('type',1)->where('inv_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('inv_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('inv_type',3)->sum('amt'),2) }}</td>
                                            @php
                                                $balance = 0;
                                                $b = ($report->where('type',1)->where('inv_type',1)->sum('amt') + $report->where('type',1)->where('inv_type',3)->sum('amt')) - $report->where('type',2)->sum('amt');
                                            @endphp
                                            <td class="text-right">{{ number_format($balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach

                                        @foreach($reports->groupby('customer_id') as $report)
                                        @php $sReport = $report->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><span style="padding-left: 70px"></span>{{ $sReport->customer->business_name }}</td>
                                            <td>{{ $sReport->user->job_loc }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->where('inv_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->where('inv_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->where('inv_type',1)->sum('amt') + $report->where('type',1)->where('inv_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('inv_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('inv_type',3)->sum('amt'),2) }}</td>
                                            @php
                                                $balance = 0;
                                                $b = ($report->where('type',1)->where('inv_type',1)->sum('amt') + $report->where('type',1)->where('inv_type',3)->sum('amt')) - $report->where('type',2)->sum('amt');
                                            @endphp
                                            <td class="text-right">{{ number_format($balance += $b,2) }}</td>
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
@include('admin.include.printJS')
@endpush
@endsection

