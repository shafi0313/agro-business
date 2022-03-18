@extends('admin.layout.master')
@section('title', 'Store Chaeck')
@section('content')
@php $p='factory'; $sm='storeQaqc'; $ssm='storeShow'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Store Check</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {{-- <h2><strong>Customer Name: </strong>{{$customerInfo->customer->name}}</h2> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:40px">SL</th>
                                            <th>Challan No</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="no-sort text-center" style="width:100px">Report</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($customerInvoices as $customerInvoice)
                                        @php $invoice = $customerInvoice->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td class="text-center">{{ $invoice->challan_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-center {{($invoice->status=='2')?'bg-danger text-light':''}}">{{ ($invoice->status=='0')?'Not Seen':(($invoice->status=='1')?'Accepted':'Reject') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('productionCheck.showInvoiceAccpet', $invoice->challan_no) }}">Show</a>
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

