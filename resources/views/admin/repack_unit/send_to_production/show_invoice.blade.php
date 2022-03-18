@extends('admin.layout.master')
@section('title', 'Sales of Cash Invoice')
@section('content')
@php $p='factory'; $sm='bulkProduction'; $ssm='repackUnitShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Sales of Credit Invoice</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Challan</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {{-- Customer Information --}}
                                    @include('admin.company_info.supplier_info')
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="text-center bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Products</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Rate Per QTY</th>
                                            <th>Bonus</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($showInvoices as $showInvoice)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $showInvoice->product->name }}</td>
                                            <td class="text-center">{{ $showInvoice->packSize->size }}</td>
                                            <td class="text-center">{{ $showInvoice->quantity }}</td>
                                            <td class="text-right">{{ number_format($showInvoice->rate_per_qty,2) }}</td>
                                            <td class="text-center">{{ $showInvoice->bonus }}</td>
                                            <td class="text-right">{{ number_format($showInvoice->amt,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: center;font-weight: bold}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="3">Total: </td>
                                            <td>{{ $showInvoices->sum('quantity') }}</td>
                                            <td class="text-right">{{ number_format($showInvoices->sum('rate_per_qty'),2) }}</td>
                                            <td>{{ $showInvoices->sum('bonus') }}</td>
                                            <td class="text-right">{{ number_format($showInvoices->sum('amt'),2) }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="6" class="text-right">Discount Amount:</td>
                                            <td class="text-right">{{ number_format($total_amt->net_amt*$total_amt->discount/100,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" colspan="6">Net Payable Amount: </td>
                                            <td class="text-right">{{ number_format($total_amt->net_amt,2) }}</td>
                                        </tr> --}}

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
@include('admin.include.data_table_js')
@endpush
@endsection

