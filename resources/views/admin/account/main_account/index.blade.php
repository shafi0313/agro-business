@extends('admin.layout.master')
@section('title', 'Main Accounts')
@section('content')
@php $p='account'; $sm='mainAc'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Main Accounts</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Main Accounts</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto " id="p" onclick="printDiv('printArea')"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body" id="printArea">
                                @php $pageTitle='Main Accounts' @endphp
                                @include('admin.include.print_page_heading')
                                <div class="page-number"></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr class="text-center">
                                                <th style="width:35px">SL</th>
                                                <th>Post Date</th>
                                                <th>Trans Date</th>
                                                <th>Particulars</th>
                                                <th>Voucher No</th>
                                                <th>Cheque/Ds/V. No</th>
                                                <th>Withdraw/Exp.</th>
                                                <th>Deposit</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $openingDate = Carbon\carbon::parse($form_date)->subDay(); @endphp
                                            <tr>
                                                <th colspan="6">Opening Balance. &nbsp; Until {{ Carbon\carbon::parse($openingDate)->format('d/m/Y') }}</th>
                                                <td style="font-weight: bold;text-align:right">{{ Number_format($opening->sum('debit'),2) }}</td>
                                                <td style="font-weight: bold;text-align:right">{{ Number_format($opening->sum('credit'),2) }}</td>
                                                <td style="font-weight: bold;text-align:right">{{ Number_format($openingCal = $opening->sum('credit') - $opening->sum('debit'),2) }}</td>
                                            </tr>
                                            @php $x=1; $balance=0; @endphp
                                            @foreach($accounts as $account)
                                            <tr class="text-center">
                                                <td class="text-center">{{ $x++ }}</td>
                                                <td>{{ bdDate($account->date) }}</td>
                                                <td>{{ bdDate($account->created_at) }}</td>
                                                <td>{{ $account->note }}</td>
                                                <td>{{ $account->m_r_no }}</td>
                                                <td>{{ $account->cheque_no }}</td>
                                                <td class="text-right">{{ number_format($account->debit,2) }}</td>
                                                <td class="text-right">{{ number_format($account->credit,2) }}</td>
                                                @php
                                                    $b = $account->credit - $account->debit;
                                                @endphp
                                                <td class="text-right" style="font-weight: bold">{{ number_format($openingCal + $balance += $b,2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tr style="font-weight: bold; text-align: right">
                                            <td colspan="6">Total:</td>
                                            <td>{{ number_format($opening->sum('debit') + $accounts->sum('debit'),2) }}</td>
                                            <td>{{ number_format($opening->sum('credit') + $accounts->sum('credit'),2) }}</td>
                                            <td>{{ number_format($openingCal + $accounts->sum('credit')-$accounts->sum('debit'),2) }}</td>
                                        </tr>
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
</div>

@push('custom_scripts')
@include('admin.include.printJS');

@endpush
@endsection

