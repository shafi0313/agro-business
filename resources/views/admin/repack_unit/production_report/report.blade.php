@extends('admin.layout.master')
@section('title', 'Production Report')
@section('content')
@php $p='factory'; $sm='productionReport'; $ssm='repackUnitShow' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Production Report</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Challan</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Production Report</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto" id="p" onclick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body" id="printableArea">
                            @php $pageTitle='Production Report' @endphp
                                @include('admin.include.print_page_heading')
                            <div class="row">
                            <div class="table-responsive">
                                <table class="display table table-bordered table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th style="width:40px">SL</th>
                                            <th>Product Name</th>
                                            <th>Size</th>
                                            <th>Date</th>
                                            <th>Challan No</th>
                                            {{-- <th>Pre</th> --}}
                                            <th>Quantity</th>
                                            <th>Use Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($productions->groupBy('product_id') as $production)
                                        <tr style="font-weight: bold; color:#fff" class="bg-info">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td colspan="6" style="font-weight: bold;">{{ $production->first()->product->name }}</td>
                                        </tr>

                                            @foreach($production->groupBy('size') as $productionSub)
                                            <tr>
                                                <td colspan="2" class="text-right font-weight-bold">{{ $productionSub->first()->packSize->size }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                                @foreach($productionSub as $productionSubSub)
                                                    <td class="text-right" colspan="3">{{ \Carbon\Carbon::parse($productionSubSub->invoice_date)->format('d/m/Y') }}</td>
                                                    <td class="text-center">{{ $productionSubSub->challan_no }}</td>

                                                    @if ($productionSubSub->invoice_date <= $form_date)
                                                    <td class="text-center">{{ $productionSubSub->quantity }}</td>
                                                    @else
                                                    <td></td>
                                                    @endif

                                                    @if ($productionSubSub->invoice_date >= $form_date)
                                                    <td class="text-center">{{ $productionSubSub->quantity }}</td>
                                                    @else
                                                    <td></td>
                                                    @endif

                                                    <td class="text-center">{{ $productionSubSub->use_weight }}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="font-weight: bold; background: #dfe6e9">
                                                    <td colspan="5" class="text-right">Total: </td>
                                                    <td class="text-center">{{ $productionSub->sum('quantity') }}</td>
                                                    <td class="text-center">{{ $productionSub->sum('use_weight') }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('admin.include.footer_signature')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom_scripts')
@include('admin.printJS')
@include('admin.include.data_table_js')
@endpush
@endsection

