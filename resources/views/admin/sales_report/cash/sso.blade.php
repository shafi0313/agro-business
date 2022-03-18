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
            <style>
                /* .dataTables_info, .dataTables_paginate, .paging_simple_numbers, .dataTables_length {
                    display: none !important;
                } */
            </style>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Employee Sales Report</h4>
                                <button type="button" class="btn btn-primary btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
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
                                            <th colspan="4">Sales</th>
                                            <th colspan="4">Collection</th>
                                            <th rowspan="2">Balance</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Cash</th>
                                            <th>Credit</th>
                                            <th>Dis</th>
                                            <th>Total Amt</th>
                                            <th>Cash</th>
                                            <th>Credit</th>
                                            <th>Dis %</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($reports->groupBy('sso_id') as $report)
                                        @php
                                            $sReport = $report->first();

                                            if($report->where('type',1)->count() > 0 ){
                                                $discount = $report->where('type',1)->sum('discount') / $report->where('type',1)->count();
                                            }else {
                                                $discount = 0;
                                            }

                                            if($report->where('type',1)->whereIn('inv_type',[1,2])->count() > 0 ){
                                                $cashDiscount =  number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('discount') / $report->where('type',1)->whereIn('inv_type',[1,2])->count(),2);
                                            }else {
                                                $cashDiscount = 0;
                                            }
                                            $calCashDiscount = ($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') * $cashDiscount)/100;


                                            if($report->where('type',1)->whereIn('inv_type',[3,4])->count() > 0 ){
                                                $creditDiscount =  number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('discount') / $report->where('type',1)->whereIn('inv_type',[3,4])->count());
                                            }else {
                                                $creditDiscount = 0;
                                            }
                                            $calCreditDiscount = ($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') * $cashDiscount)/100;


                                            // Payment Discount Calculation
                                            if ($report->where('type',2)->count() > 0) {
                                                $payDiscount = number_format($report->where('type',2)->sum('discount') / $report->where('type',2)->count());
                                            }else{
                                                $payDiscount = 0;
                                            }

                                            $totalPayDiscountAmt = ($report->where('type',2)->sum('amt')*$payDiscount)/100;

                                            if ($report->where('type',1)->where('pay_type',1)->count() > 0) {
                                                $payCashDiscount =  number_format($report->where('type',2)->where('pay_type',1)->sum('discount') / $report->where('type',2)->where('pay_type',1)->count());
                                            }else{
                                                $payCashDiscount = 0;
                                            }
                                            $calPayCashDiscount = ($report->where('type',2)->where('pay_type',1)->sum('amt') * $payCashDiscount)/100;

                                            if ($report->where('type',1)->where('pay_type',3)->count() > 0) {
                                                $payCreditDiscount =  number_format($report->where('type',2)->where('pay_type',3)->sum('discount') / $report->where('type',1)->where('pay_type',3)->count());
                                            }else{
                                                $payCreditDiscount = 0;
                                            }
                                            $calPayCreditDiscount = ($report->where('type',2)->where('pay_type',3)->sum('amt') * $payCreditDiscount)/100;

                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><span style="padding-left: 30px"></span>{{ $sReport->sso->name }}</td>
                                            <td>{{ $sReport->user->job_loc }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $calCashDiscount ,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') + $calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($calCashDiscount+$calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('pay_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('pay_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($calPayCashDiscount + $calPayCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->sum('amt') - $totalPayDiscountAmt,2) }}</td>
                                            @php
                                                $balance = 0;
                                                $b = ($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt')) - ($report->where('type',2)->sum('amt') - $totalPayDiscountAmt);
                                            @endphp
                                            <td class="text-right">{{ number_format($balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach

                                        @foreach($reports->groupby('so_id') as $report)
                                        @php
                                            $sReport = $report->first();

                                            if($report->where('type',1)->count() > 0 ){
                                                $discount = $report->where('type',1)->sum('discount') / $report->where('type',1)->count();
                                            }else {
                                                $discount = 0;
                                            }

                                            if($report->where('type',1)->whereIn('inv_type',[1,2])->count() > 0 ){
                                                $cashDiscount =  number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('discount') / $report->where('type',1)->whereIn('inv_type',[1,2])->count(),2);
                                            }else {
                                                $cashDiscount = 0;
                                            }
                                            $calCashDiscount = ($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') * $cashDiscount)/100;


                                            if($report->where('type',1)->whereIn('inv_type',[3,4])->count() > 0 ){
                                                $creditDiscount =  number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('discount') / $report->where('type',1)->whereIn('inv_type',[3,4])->count());
                                            }else {
                                                $creditDiscount = 0;
                                            }
                                            $calCreditDiscount = ($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') * $cashDiscount)/100;


                                            // Payment Discount Calculation
                                            if ($report->where('type',2)->count() > 0) {
                                                $payDiscount = number_format($report->where('type',2)->sum('discount') / $report->where('type',2)->count());
                                            }else{
                                                $payDiscount = 0;
                                            }

                                            $totalPayDiscountAmt = ($report->where('type',2)->sum('amt')*$payDiscount)/100;

                                            if ($report->where('type',1)->where('pay_type',1)->count() > 0) {
                                                $payCashDiscount =  number_format($report->where('type',2)->where('pay_type',1)->sum('discount') / $report->where('type',1)->where('pay_type',1)->count());
                                            }else{
                                                $payCashDiscount = 0;
                                            }
                                            $calPayCashDiscount = ($report->where('type',2)->where('pay_type',1)->sum('amt') * $payCashDiscount)/100;

                                            if ($report->where('type',1)->where('pay_type',3)->count() > 0) {
                                                $payCreditDiscount =  number_format($report->where('type',2)->where('pay_type',3)->sum('discount') / $report->where('type',1)->where('pay_type',3)->count());
                                            }else{
                                                $payCreditDiscount = 0;
                                            }
                                            $calPayCreditDiscount = ($report->where('type',2)->where('pay_type',3)->sum('amt') * $payCreditDiscount)/100;

                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            @isset($sReport->so->name)
                                            <td><span style="padding-left: 50px"></span>{{ $sReport->so->name }}</td>
                                            @else
                                            <td><span style="padding-left: 50px"></span></td>
                                            @endisset

                                            <td>{{ $sReport->user->job_loc }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $calCashDiscount ,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') + $calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($calCashDiscount+$calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('pay_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('pay_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($calPayCashDiscount + $calPayCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->sum('amt') - $totalPayDiscountAmt,2) }}</td>
                                            @php
                                                $balance = 0;
                                                $b = ($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt')) - ($report->where('type',2)->sum('amt') - $totalPayDiscountAmt);
                                            @endphp
                                            <td class="text-right">{{ number_format($balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach

                                        @foreach($reports->groupBy('customer_id') as $report)
                                        @php
                                            $sReport = $report->first();

                                            if($report->where('type',1)->count() > 0 ){
                                                $discount = $report->where('type',1)->sum('discount') / $report->where('type',1)->count();
                                            }else {
                                                $discount = 0;
                                            }

                                            if($report->where('type',1)->whereIn('inv_type',[1,2])->count() > 0 ){
                                                $cashDiscount =  number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('discount') / $report->where('type',1)->whereIn('inv_type',[1,2])->count(),2);
                                            }else {
                                                $cashDiscount = 0;
                                            }
                                            $calCashDiscount = ($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') * $cashDiscount)/100;


                                            if($report->where('type',1)->whereIn('inv_type',[3,4])->count() > 0 ){
                                                $creditDiscount =  number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('discount') / $report->where('type',1)->whereIn('inv_type',[3,4])->count());
                                            }else {
                                                $creditDiscount = 0;
                                            }
                                            $calCreditDiscount = ($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') * $cashDiscount)/100;


                                            // Payment Discount Calculation
                                            if ($report->where('type',2)->count() > 0) {
                                                $payDiscount = number_format($report->where('type',2)->sum('discount') / $report->where('type',2)->count());
                                            }else{
                                                $payDiscount = 0;
                                            }

                                            $totalPayDiscountAmt = ($report->where('type',2)->sum('amt')*$payDiscount)/100;

                                            if ($report->where('type',1)->where('pay_type',1)->count() > 0) {
                                                $payCashDiscount =  number_format($report->where('type',2)->where('pay_type',1)->sum('discount') / $report->where('type',1)->where('pay_type',1)->count());
                                            }else{
                                                $payCashDiscount = 0;
                                            }
                                            $calPayCashDiscount = ($report->where('type',2)->where('pay_type',1)->sum('amt') * $payCashDiscount)/100;

                                            if ($report->where('type',1)->where('pay_type',3)->count() > 0) {
                                                $payCreditDiscount =  number_format($report->where('type',2)->where('pay_type',3)->sum('discount') / $report->where('type',1)->where('pay_type',3)->count());
                                            }else{
                                                $payCreditDiscount = 0;
                                            }
                                            $calPayCreditDiscount = ($report->where('type',2)->where('pay_type',3)->sum('amt') * $payCreditDiscount)/100;

                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><span style="padding-left: 70px"></span>{{ $sReport->customer->business_name }}</td>
                                            <td>{{ $sReport->user->job_loc }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $calCashDiscount ,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') + $calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($calCashDiscount+$calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('pay_type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->where('pay_type',3)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($calPayCashDiscount + $calPayCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->sum('amt') - $totalPayDiscountAmt,2) }}</td>




                                            {{-- <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $calCashDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt') + $calCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($discount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->whereIn('inv_type',[1,2])->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->whereIn('inv_type',[3,4])->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($calPayCashDiscount + $calPayCreditDiscount,2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->sum('amt') - $totalPayDiscountAmt,2) }}</td> --}}
                                            @php
                                                $balance = 0;
                                                $b = ($report->where('type',1)->whereIn('inv_type',[1,2])->sum('amt') + $report->where('type',1)->whereIn('inv_type',[3,4])->sum('amt')) - ($report->where('type',2)->sum('amt') - $totalPayDiscountAmt);
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

