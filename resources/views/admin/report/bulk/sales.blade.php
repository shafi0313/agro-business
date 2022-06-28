@extends('admin.layout.master')
@section('title', 'Bulk Sales Report')
@section('content')
@php $p='factory'; $ssm='bulkShow'; $sm="bulkReport" @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Bulk Sales Report</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onClick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            @php $pageTitle='Bulk Sales Report' @endphp
                            @include('admin.include.print_page_heading')
                            <div class="table-responsive"  >
                                <table class="display table table-bordered table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th style="width:40px">SL</th>
                                            <th>Product Name</th>
                                            <th>Size</th>
                                            <th>Date</th>
                                            <th>Challan No</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($reports->groupBy('product_id') as $report)
                                        <tr style="font-weight: bold; color:#fff" class="bg-info">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td colspan="6" style="font-weight: bold;">{{ $report->first()->product->generic }}</td>
                                        </tr>
                                            @foreach($report->groupBy('size') as $reportSub)
                                            <tr>
                                                <td colspan="3" class="text-right font-weight-bold">{{ $reportSub->first()->packSize->size }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                                @foreach($reportSub as $reportSubSub)
                                                    <td class="text-right" colspan="4">{{ \Carbon\Carbon::parse($reportSubSub->invoice_date)->format('d/m/Y') }}</td>
                                                    <td class="text-center">{{ $reportSubSub->challan_no }}</td>
                                                    <td class="text-center">{{ $reportSubSub->quantity }}</td>
                                                    <td class="text-center">{{ number_format($reportSubSub->amt,2) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="font-weight: bold; background: #dfe6e9">
                                                    <td colspan="5" class="text-right">Total: </td>
                                                    <td class="text-center">{{ $reportSub->sum('quantity') }}</td>
                                                    <td class="text-center">{{ number_format($reportSub->sum('amt'),2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-6">
                                    <table class="table" >
                                        <tr class="bg-secondary text-light" style="font-weight:bold">
                                            <td>Sales: {{ number_format($reportWithDiscount->sum('sales_amt'),2)}}</td>
                                            <td>Discount: {{ number_format($reportWithDiscount->sum('sales_amt')-$reportWithDiscount->sum('net_amt') ,2)}}</td>
                                            <td>Net Amount: {{ number_format($reportWithDiscount->sum('net_amt'),2) }}</td>
                                        </tr>
                                    </table>
                                </div>
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

