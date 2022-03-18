@extends('admin.layout.master')
@section('title', 'Total Stock')
@section('content')
@php $p='factory'; $sm="bulkStock"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Bulk Stock</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Bulk Stock</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto " id="p" onclick="printDiv('printableArea')"><i class="fas fa-print"></i> Print</button>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('customer.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Customer
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body"  id="printableArea">
                            <h2 id="title" class="text-center"></h2>
                            <h4 id="sub_title" class="text-center"></h4>
                            <div class="table-responsive">
                                <table id="tblProducts" class="table table-striped table-hover table-sm table-bordered">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th rowspan="2" class="text-center">SL</th>
                                            <th rowspan="2">Group Name</th>
                                            <th rowspan="2">Size</th>
                                            <th rowspan="2" class="text-center">Date</th>
                                            <th colspan="3" class="text-center">Quantity</th>
                                            <th rowspan="2" class="text-center">Total Stock</th>
                                        </tr>
                                        <tr>
                                            <th>Production</th>
                                            <th>Sales</th>
                                            <th>Sample</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1 @endphp
                                        @foreach($totalStocks->groupBy('product_id') as $totalStock)
                                        @php $sales = $totalStock->first(); @endphp
                                        <tr style="font-weight: bold; color:#fff" class="bg-info">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td colspan="6" style="font-weight: bold;">{{ $sales->product->name }}</td>
                                        </tr>
                                        @foreach($totalStock->groupBy('size') as $totalStockSub)
                                        @php $totalStockSubFirst = $totalStockSub->first(); @endphp

                                        <tr>
                                            <td class="text-right" colspan="3">{{ $totalStockSubFirst->packSize->size }}</td>
                                            <td class="text-right">{{ \Carbon\Carbon::parse($totalStockSubFirst->invoice_date)->format('d/m/Y') }}</td>
                                            @isset($record)
                                            <td class="text-right" >{{ $totalStock->purchaseStock->sum('quantity') }}</td>
                                            @else
                                            <td class="text-right"></td>
                                            @endisset

                                            <td class="text-right" >{{ $totalStock->where('type',5)->sum('quantity') }}</td>
                                            <td class="text-right" >{{ $totalStock->where('type',5)->sum('quantity') }}</td>
                                            <td class="text-center">{{ $totalStockSubFirst->net_weight }}</td>
                                        </tr>
                                        {{-- <tr style="font-weight: bold;">
                                            <td colspan="5" class="text-right">Total</td>
                                            <td class="text-center">{{ $totalStock->sum('quantity') }}</td>
                                            <td class="text-center">{{ $totalStock->sum('use_weight') }}</td>
                                        </tr> --}}
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
<script>
    // Amount Calculation
    var $tblrows = $("#tblProducts tbody tr");
        $tblrows.each(function (index) {
            var $tblrow = $(this);
            var qty = $tblrow.find("[name=quantity]").val();
            var price = $tblrow.find("[name=rate]").val();

            $tblrow.find("[name=rate]").keyup(function() {
                var qty = $tblrow.find("[name=quantity]").val();
                var price = $tblrow.find("[name=rate]").val();
                var subTotal = parseFloat(qty) * parseFloat(price);
                $tblrow.find("[name=totalr]").val(subTotal);
        })
    });
</script>

@include('admin.include.data_table_js')
@include('admin.include.printJS')
@endpush
@endsection

