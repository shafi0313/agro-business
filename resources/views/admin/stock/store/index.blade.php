@extends('admin.layout.master')
@section('title', 'Store Stock')
@php $p='factory'; $sm='storeStock'; $ssm='storeShow'; @endphp
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Store Stock</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Store Stock</h4>
                                <button type="button" class="btn btn-success btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
                                <a class="btn btn-primary btn-round ml-3" href="{{route("stock.store.create")}}">
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="printableArea">
                                <br><br>
                                @php $pageTitle='Store Stock Report' @endphp
                                @include('admin.include.print_page_heading')
                                <table id="multi-filter-select" class="display table table-border rate_cal" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Brand Name</th>
                                            <th>Group Name</th>
                                            <th style="min-width:60px !important">Pack Size</th>
                                            <th>Opening</th>
                                            <th>Production</th>
                                            <th>Total Pd.</th>
                                            <th>Sales</th>
                                            <th>Sample</th>
                                            <th>Total Out</th>
                                            <th>Closing</th>
                                            <th>Expired</th>
                                            <th>Unsold</th>
                                            <th>Damaged</th>
                                            <th class="text-center" style="width: 150px">Rate Per kg/ltr</th>
                                            <th class="text-center" style="width: 150px">Amount</th>
                                            <th class="no-print no-sort text-center" style="width:40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1;@endphp
                                        @foreach($stocks->groupBy('product_id') as $stockGroup)
                                        @php $stock = $stockGroup->first() @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $stock->product->name }}</td>
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
                                                        {{-- Opening --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 0)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Production --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 11)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Opening + Production --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['0','11'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Sales --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['1','3'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Sample --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 5)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{--Total Out (Sales + Sample) --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['1','3','5'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table style="width:100%; border:none" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        {{-- Closing --}}
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->whereIn('type', ['0','11','20','21'])->sum('quantity') - $stockSubGroup->where('stock_close',0)->whereIn('type', ['1','3','5'])->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%;" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        <td >{{ $stockSubGroup->where('stock_close',0)->where('type', 20)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        <td>{{ $stockSubGroup->where('stock_close',0)->where('type', 21)->sum('quantity') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
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
                                                        <td>{{ number_format($stockSub->packSize->cash,2) }}</td>
                                                        {{-- <td class="no-print"><input type="text" name="rate" id="rate" class="form-control form-control-sm"></td> --}}
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        <td>{{ ($stockSubGroup->where('stock_close',0)->whereIn('type', ['0','11'])->sum('quantity') - $stockSubGroup->where('stock_close',0)->whereIn('type', ['1','5'])->sum('quantity')) * $stockSub->packSize->cash }}</td>
                                                        {{-- <td class="text-center no-print"><input type="text" id="totalr" name="totalr" class="form-control form-control-sm"></td> --}}
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td class="no-print">
                                                <table style="width:100%" class="text-center">
                                                    @foreach ($stockGroup->groupBy('product_pack_size_id') as $stockSubGroup)
                                                    @php $stockSub = $stockSubGroup->first() @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <a href="{{ route('stock.store.previous',$stockSub->packSize->id) }}" title="Edit" class="btn btn-link btn-primary"><i class="fa fa-edit"></i></a>
                                                                {{-- <a href="{{ route('stock.store.previous',[$stock->product->id, $stockSub->packSize->id]) }}" title="Stock Close" class="btn btn-link btn-primary btn-danger"><i class="far fa-times-circle"></i></a> --}}
                                                                <span title="Stock Close" class="btn btn-link btn-primary btn-danger stock_close" data-toggle="modal" data-target="#stock_close" data-id="{{$stock->product->id}}" data-id2="{{$stockSub->packSize->id}}">
                                                                    <i class="far fa-times-circle"></i>
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
            <form action="{{ route('stock.store.close') }}" method="post" id="close_stock">
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
        // $('#close_stock').attr('action',$(this).data('url'));
        $('#product_id').val($(this).data("id"));
        $('#pack_size_id').val($(this).data("id2"));
    });
</script>
@include('admin.include.data_table_js')
<script>
    // Amount Calculation
    var $tblrows = $(".rate_cal tr");
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

@endpush
@endsection

