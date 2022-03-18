@extends('admin.layout.master')
@section('title', 'Sales of Cash')
@section('content')
@php $p='sales'; $sm="salesCash" @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Sales of Cash</a></li>
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
                                    {{-- Customer Information --}}
                                    @include('admin.company_info.customer_info')
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="text-center bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Brand Name</th>
                                            <th>Group Name</th>
                                            <th>Weight</th>
                                            <th>Quantity</th>
                                            <th>Rate Per QTY</th>
                                            {{-- <th>Net Weight</th> --}}
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($showInvoices as $showInvoice)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $showInvoice->product->name }}</td>
                                            <td>{{ $showInvoice->product->generic }}</td>
                                            <td class="text-center">{{ $showInvoice->packSize->size }}</td>
                                            <td class="text-center">{{ $showInvoice->quantity }}</td>
                                            <td class="text-right">{{ number_format($showInvoice->rate_per_qty,2) }}</td>
                                            {{-- <td class="text-center">{{ number_format($showInvoice->net_weight,0) }}</td> --}}
                                            <td class="text-right">{{ number_format($showInvoice->amt,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: center;font-weight: bold}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="6">Total: </td>
                                            <td class="text-right">{{ number_format($showInvoices->sum('amt'),2) }}</td>
                                        </tr>
                                    </tfoot>
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
@endpush
@endsection

