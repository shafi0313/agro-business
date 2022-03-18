@extends('admin.layout.master')
@section('title', 'Send To Repack Unit')
@section('content')
@php $p='factory'; $sm="balkRepack"; $ssm = 'bulkShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Challan</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h2><strong></strong>{{$supplierInfo->supplier->name}}</h2>
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
                                            <th class="no-sort text-center" style="width:100px">Print</th>
                                            <th class="no-sort text-center" style="width:100px">Report</th>
                                            {{-- <th class="no-sort text-center" style="width:60px">Action</th> --}}
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
                                        @foreach($invoices as $invoice)
                                        @php $getInvoice = $invoice->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td class="text-center">{{ $getInvoice->challan_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($getInvoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-center {{($getInvoice->status=='2')?'bg-danger text-light':''}}">{{ ($getInvoice->status=='0')?'Not Seen':(($getInvoice->status=='1')?'Accepted':'Reject') }}</td>
                                            <td class="text-center">
                                                {{-- <a href="{{ route('salesInvoiceCash.printInvoice', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Invoice</a>
                                                <span> | </span> --}}
                                                <a href="{{ route('repacking.printChallan', [$getInvoice->supplier_id, $getInvoice->challan_no]) }}" target="_blank">Challan</a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('repacking.show',[$getInvoice->supplier_id, $getInvoice->challan_no]) }}">Show</a>
                                            </td>
                                            {{-- <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('repacking.destroy', $getInvoice->challan_no) }} " title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </td> --}}
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

