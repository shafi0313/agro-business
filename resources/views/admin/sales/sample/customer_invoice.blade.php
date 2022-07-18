@extends('admin.layout.master')
@section('title', 'Sample Invoice')
@section('content')
@php $p='sales'; $sm='sample' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sample-invoive.index')}}">Sample Invoice</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">All Invoice List</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h2><strong>Name: </strong>{{$customerInfo->customer->name}}</h2>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:40px">SL</th>
                                            <th>Challan No</th>
                                            <th>Invoice No</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th class="no-sort text-center" style="width:120px">Print</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($customerInvoices as $customerInvoice)
                                        <tr>
                                            @php $invoice = $customerInvoice->first();@endphp

                                            <td class="text-center">{{ $x++ }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>
                                            <td class="text-center">{{ $invoice->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-right">{{ number_format($customerInvoice->sum('amt'),2) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('salesSample.printInvoice', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Invoice</a>

                                                <span> | </span>
                                                <a href="{{ route('salesSample.printChallan', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Challan</a>

                                            </td>
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
@endpush
@endsection

