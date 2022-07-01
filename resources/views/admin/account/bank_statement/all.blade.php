@extends('admin.layout.master')
@section('title', 'Bank Statement')
@section('content')
@php $p = 'account'; $sm='bankStat'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Bank Statement</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            @php $pageTitle='Bank Statement' @endphp
                            @include('admin.include.print_page_heading')

                            <div class="page-number"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Trans Date</th>
                                            <th>Post Date</th>
                                            <th>Particulars</th>
                                            <th>Bank Name</th>
                                            <th>AC No</th>
                                            <th>Cheque/DS No</th>
                                            <th>Withdraw</th>
                                            <th>Deposit</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $openingDate = Carbon\carbon::parse($form_date)->subDay(); @endphp
                                        <tr>
                                            <th colspan="9">Opening Balance. &nbsp; Until {{ Carbon\carbon::parse($openingDate)->format('d/m/Y') }}</th>
                                            <td style="font-weight: bold;text-align:right">{{ number_format($opening,2) }}</td>
                                        </tr>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($accounts as $account)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ Carbon\Carbon::parse($account->m_r_date)->format('d/m/Y') }}</td>
                                            <td>{{ Carbon\Carbon::parse($account->date)->format('d/m/Y') }}</td>
                                            <td>{{ $account->note }}</td>
                                            @if (isset($account->userBank->bank->name))
                                            <td>{{  $account->userBank->bank->name }}</td>
                                            @else
                                            <td></td>
                                            @endif

                                            @if (isset($account->userBank->ac_no))
                                            <td>{{  $account->userBank->ac_no }}</td>
                                            @else
                                            <td></td>
                                            @endif

                                            <td>{{ $account->cheque_no }}</td>
                                            <td class="text-right">{{ number_format($account->debit,2) }}</td>
                                            <td class="text-right">{{ number_format($account->credit,2) }}</td>
                                            @php $b = $account->credit - $account->debit; @endphp
                                            <td class="text-right" style="font-weight: bold">{{ number_format($opening + $balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                        <tr style="text-align:right; font-weight: bold;">
                                            <td colspan="7">Total:</td>
                                            <td>{{ number_format($accounts->sum('debit'),2) }}</td>
                                            <td>{{ number_format($accounts->sum('credit'),2) }}</td>
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
    @include('admin.layout.footer')
</div>

@push('custom_scripts')

@include('admin.include.printJS');
@endpush
@endsection

