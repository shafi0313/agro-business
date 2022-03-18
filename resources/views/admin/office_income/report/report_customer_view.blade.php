@extends('admin.layout.master')
@section('title', 'Office Income Report')
@section('content')
@php $p = 'account'; $sm='officeInRe'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Office Income Report</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Office Income Report</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto " id="p" onclick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            <br><br>
                            @php $pageTitle='Office Income Report' @endphp
                            @include('admin.include.print_page_heading')
                            <div class="table-responsive">
                                <table id="multi-filter-select"class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw text-center">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Date</th>
                                            <th>Particulars</th>
                                            <th>Payment By</th>
                                            <th>Cheque/DS No</th>
                                            <th>Cash</th>
                                            <th>Bank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($accounts as $account)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ Carbon\Carbon::parse($account->date)->format('d/m/Y') }}</td>
                                            <td>{{ $account->note }}</td>

                                            @if (isset($account->userBank->bank->name))
                                                <td>{{ $account->userBank->bank->name }}</td>
                                            @else
                                                <td>Cash</td>
                                            @endif

                                            <td>{{ $account->m_r_no }}</td>
                                            @if ($account->type == 1)
                                                <td class="text-right">{{ number_format($account->credit,2) }}</td>
                                            @else
                                                <td class="text-right">0</td>
                                            @endif

                                            @if ($account->type == 2)
                                                <td class="text-right">{{ number_format($account->credit,2) }}</td>
                                            @else
                                                <td class="text-right">0</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tr style="font-weight: bold; text-align: right">
                                        <td colspan="5">Total:</td>
                                        <td>{{ number_format($accounts->where('type',1)->sum('credit'),2) }}</td>
                                        <td>{{ number_format($accounts->where('type', 2)->sum('credit'),2) }}</td>
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

@include('admin.include.data_table_js')
@include('admin.include.printJS')
@endpush
@endsection

