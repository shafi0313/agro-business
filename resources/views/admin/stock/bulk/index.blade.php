@extends('admin.layout.master')
@section('title', 'Bulk Stock')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Factory</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Bulk</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Bulk Stock</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Stock</h4>
                                <button type="button" class="btn btn-success btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
                                <a class="btn btn-primary btn-round ml-3" href="{{route("stock.bulk.create")}}">
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="printableArea">
                                <br><br>
                                @php $pageTitle='Bulk Stock Report' @endphp
                                @include('admin.include.print_page_heading')
                                <table id="multi-filter-select" class="display table table-border" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Group Name</th>
                                            <th style="min-width:60px">Pack Size</th>
                                            <th>Opening</th>
                                            <th>Receive Bulk</th>
                                            <th>Total Bulk</th>
                                            <th>Sales</th>
                                            <th>Send to Repack Unit</th>
                                            <th>Total Out</th>
                                            <th>Quantity</th>
                                            <th>Net Weight</th>
                                            <th>Use Weight</th>
                                            <th>Damaged</th>
                                            <th class="text-center">Rate Per kg/ltr</th>
                                            <th class="text-center">Amount</th>
                                            <th class="no-print no-sort text-center" style="width:40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1;@endphp
                                        @foreach($stocks->groupBy('product_id') as $stockGroup)
                                        @php $stock = $stockGroup->first() @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $stock->product->generic }}</td>
                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        <td>{{ $stockSub->packSize->size }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- 00 Opening --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 00)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- 7 Bulk Purchase/Receive Bulk --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 7)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Total Bulk 00+7 --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['00','7'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- 16 Sales --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', [16,18])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- 12 Send to Repackunit  --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 9)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Total out 12+16--}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['9','16'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Quantity (Total bulk - Total out) --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['00','7'])->sum('quantity') - $stockSubGroup->where('stock_close',0)->whereIn('type', ['9','16','18'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Net Weight --}}
                                                        <td>{{ abs($stockSubGroup->where('stock_close',0)->where('stock_type', 2)->whereIn('type',['00','7'])->sum('net_weight') - $stockSubGroup->where('stock_close',0)->where('stock_type', 2)->whereIn('type',['9','16','18'])->sum('net_weight')) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Net Weight --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('stock_type', 2)->sum('use_weight') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Damaged --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 22)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- price --}}
                                                        <td>{{ number_format($stockSub->packSize->trade_price,2)}}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- amount --}}
                                                        <td>{{ ($stockSubGroup->where('stock_close',0)->whereIn('type', ['0','11'])->sum('quantity') - $stockSubGroup->where('stock_close',0)->whereIn('type', ['1','5'])->sum('quantity')) * $stockSub->packSize->cash }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td class="text-center no-print">
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <a href="{{ route('stock.bulk.previous',$stockSub->packSize->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <span title="Stock Close" class="btn btn-link btn-primary btn-success stock_close" data-toggle="modal" data-target="#stock_close" data-id="{{$stock->product->id}}" data-id2="{{$stockSub->packSize->id}}">
                                                                    <i class="far fa-check-circle"></i>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                        </tr>
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

<!-- Stock Close Modal -->
<div class="modal fade" id="stock_close" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Password Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('stock.bulk.close') }}" method="post" id="close_stock">
                @csrf
                <input type="hidden" id="product_id" name="product_id">
                <input type="hidden" id="pack_size_id" name="pack_size_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">Enter your password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('custom_scripts')
@include('admin.printJS')
<script>
    $(".stock_close").on('click', function(){
        $('#product_id').val($(this).data("id"));
        $('#pack_size_id').val($(this).data("id2"));
    });
</script>

@include('admin.include.data_table_js')
@endpush
@endsection

