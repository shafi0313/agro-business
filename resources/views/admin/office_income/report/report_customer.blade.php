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
                            @php $pageTitle='Office Income Report' @endphp
                            @include('admin.include.print_page_heading')
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw text-center">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Particulars</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; $balance=0; @endphp
                                        @foreach($accounts as $account)
                                        @php $ac = $account->first() @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><a href="{{ route('officeIn.reportView',[$ac->user_id.'Cus',$form_date,$to_date, 0])}}">{{ $ac->users->business_name }}</a></td>
                                            <td class="text-right">{{ number_format($account->sum('credit'),2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tr style="font-weight: bold; text-align: right">
                                        <td colspan="2">Page Total:</td>
                                        <td>{{ number_format($getAccounts->sum('credit'),2) }}</td>
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
@push('custom_scripts')
@include('admin.include.data_table_js')
@include('admin.include.printJS')
@endpush
@endsection

