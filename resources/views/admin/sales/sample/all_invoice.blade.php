@extends('admin.layout.master')
@section('title', 'Sample Invoice')
@section('content')
@php $p='sales'; $sm="sample" @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Sales</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sample-invoive.index')}}">Sample</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">All Challan</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {{-- <h2><strong>Supplier Name: </strong>{{$supplierInfo->supplier->name}}</h2> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:40px">SL</th>
                                            <th>Name</th>
                                            <th>Challan No</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th class="no-sort text-center" style="width:160px">Report</th>
                                            <th class="no-sort text-center" style="width:60px">Action</th>
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
                                        @foreach($supplierChallans as $supplierChallan)
                                        @php $challan = $supplierChallan->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $challan->customer->name }}</td>
                                            <td class="text-center">{{ $challan->challan_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($challan->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-right">{{ number_format($supplierChallan->sum('amt'),2) }}</td>
                                            {{-- <td class="text-center">
                                                <a href="{{ route('salesInvoiceCash.allInvoiceShow', [$challan->challan_no]) }}">Show</a>
                                            </td> --}}
                                            <td class="text-center">
                                                <a href="{{ route('salesInvoiceCash.printInvoice', [$challan->customer_id, $challan->invoice_no]) }}" target="_blank">Print Invoice</a>
                                                <span> | </span>
                                                <a href="{{ route('salesInvoiceCash.allInvoiceShow', [$challan->invoice_no]) }}">Show</a>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('salesInvoiceCash.destroy', $challan->challan_no) }} " title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
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

