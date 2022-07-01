@extends('admin.layout.master')
@section('title', 'Customer Report')
@section('content')
@php $p='report'; $sm='customerReport' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Customer Report</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-sm ml-auto " id="p" onclick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body"  id="printableArea">
                            <h2 id="title" class="text-center"></h2>
                            <h4 id="sub_title" class="text-center"></h4>
                            <div class="table-responsive">
                                @php $pageTitle='Customer Report' @endphp
                                @include('admin.include.print_page_heading')
                                <table class="display table table-bordered table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th rowspan="2" style="width:40px">SN</th>
                                            <th rowspan="2">Customer Id</th>
                                            <th rowspan="2">Customer Name</th>
                                            <th rowspan="2">Proprietor</th>
                                            <th colspan="2">Sales</th>
                                            <th colspan="2">Return</th>
                                            <th rowspan="2">Dis</th>
                                            <th rowspan="2">Sales Amount</th>
                                            <th rowspan="2">Previous Credit</th>
                                            <th colspan="2">Collection</th>
                                            <th rowspan="2">Due</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Cash</th>
                                            <th>Credit</th>
                                            <th>Cash</th>
                                            <th>Credit</th>
                                            <th>Cash</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($customers as $customer)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $customer->tmm_so_id }}</td>
                                            <td>{{ $customer->business_name }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td class="text-right">{{ number_format($cashS = $customer->invoice->where('type',1)->sum('sales_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($creditS = $customer->invoice->where('type',3)->sum('sales_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($cashR = $customer->invoice->where('type',2)->sum('sales_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($creditR = $customer->invoice->where('type',4)->sum('sales_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($dis = $customer->invoice->sum('discount_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($totalSales = ($cashS+$creditS) - (abs($cashR+$creditR)+$dis),2) }}</td>
                                            <td class="text-right">{{ number_format($pre = $customer->invoice->where('type',0)->sum('net_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($cashC = $customer->invoice->where('pay_type',1)->sum('payment'),2) }}</td>
                                            <td class="text-right">{{ number_format($creditC = $customer->invoice->where('pay_type',3)->sum('payment'),2) }}</td>
                                            <td class="text-right">{{ number_format(($totalSales+$pre) - ($cashC+$creditC),2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="text-right" style="font-weight: bold">
                                            <th colspan="4">Page Total: </th>
                                            <th>{{ number_format($salesLedgerBook->where('type',1)->sum('sales_amt'),2) }}</th>
                                            <th>{{ number_format($salesLedgerBook->where('type',3)->sum('sales_amt'),2) }}</th>
                                            <th>{{ number_format(abs($salesLedgerBook->where('type',2)->sum('sales_amt')),2) }}</th>
                                            <th>{{ number_format(abs($salesLedgerBook->where('type',4)->sum('sales_amt')),2) }}</th>
                                            <th>{{ number_format($salesLedgerBook->sum('discount_amt'),2) }}</th>
                                            <th>{{ number_format($salesLedgerBook->whereIn('type',[1,3])->sum('net_amt') - $salesLedgerBook->sum('discount_amt') - $salesLedgerBook->whereIn('type',[2,4])->sum('net_amt'),2) }}</th>
                                            <th>{{ number_format($salesLedgerBook->where('type',0)->sum('net_amt'),2) }}</th>
                                            <th>{{ number_format($salesLedgerBook->where('pay_type',1)->sum('payment'),2) }}</th>
                                            <th>{{ number_format($salesLedgerBook->where('pay_type',3)->sum('payment'),2) }}</th>
                                            <th>{{ number_format(abs(($salesLedgerBook->whereIn('type',[1,3])->sum('net_amt') - $salesLedgerBook->sum('discount_amt') - $salesLedgerBook->whereIn('type',[2,4])->sum('net_amt')+$salesLedgerBook->where('type',0)->sum('net_amt')) - $salesLedgerBook->sum('payment') ),2)}}</th>
                                            {{-- <th>{{ number_format($salesLedgerBook->sum('net_amt') - $salesLedgerBook->sum('payment'),2) }}</th> --}}
                                        </tr>
                                    </tbody>
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
@include('admin.include.printJS')
@endpush
@endsection

