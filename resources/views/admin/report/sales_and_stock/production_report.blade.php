@extends('admin.layout.master')
@section('title', 'Production report')
@section('content')
@php $p='report'; $sm="salesAndStock" @endphp
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
                                <h4 class="card-title">Production report</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onclick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            <h2 id="title" class="text-center"></h2>
                            <h4 id="sub_title" class="text-center"></h4>
                            <div style="font-size:20px; text-align:center">Form: {{Carbon\carbon::parse($form_date)->format('d/m/Y')}} To: {{Carbon\carbon::parse($to_date)->format('d/m/Y')}}</div>
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
                                            <th>Use Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($reports->groupBy('product_id') as $report)
                                        <tr style="font-weight: bold; color:#fff" class="bg-info">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td colspan="6" style="font-weight: bold;">{{ $report->first()->product->name??$report->first()->product->generic }}</td>
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
                                                    <td class="text-center">{{ $reportSubSub->use_weight }}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="font-weight: bold; background: #dfe6e9">
                                                    <td colspan="5" class="text-right">Total: </td>
                                                    <td class="text-center">{{ $reportSub->sum('quantity') }}</td>
                                                    <td class="text-center">{{ $reportSub->sum('use_weight') }}</td>
                                                </tr>
                                            @endforeach
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
@include('admin.include.printJS')
@endpush
@endsection

