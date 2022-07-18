@extends('admin.layout.master')
@section('title', 'Bulk Sales')
@section('content')
@php $p='factory'; $sm="balkSales"; $ssm = 'bulkShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Bulk</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-bulk.index')}}">Sales</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">All Challan and Invoice By Date</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:40px">SL</th>
                                            <th>Name</th>
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
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($supplierChallans as $supplierChallan)
                                        @php $challan = $supplierChallan->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $challan->customer->name }}</td>
                                            <td>{{ $challan->challan_no }}</td>
                                            <td>{{ $challan->invoice_no }}</td>
                                            <td>{{ bdDate($challan->invoice_date) }}</td>
                                            <td class="text-right">{{ number_format($supplierChallan->sum('amt'),2) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('bulkSales.printInvoice', [$challan->customer_id, $challan->invoice_no]) }}" target="_blank">Invoice</a>
                                                <span> | </span>
                                                <a href="{{ route('bulkSales.printChallan', [$challan->customer_id, $challan->invoice_no]) }}" target="_blank">Challan</a>
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

