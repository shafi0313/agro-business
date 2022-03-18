@extends('admin.layout.master')
@section('title', 'Label Stock')
@section('content')
@php $p='factory'; $sm='labelStock'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Label Stock</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Label Stock</h4>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('customer.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Customer
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tblProducts" class="table table-striped table-hover table-sm table-bordered">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Brand Name</th>
                                            <th>Weight</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Net Weight</th>
                                            <th class="text-center">Damaged</th>
                                            <th class="text-center">Total Stock</th>
                                            <th class="text-center" style="width: 150px">Rate Per kg/ltr</th>
                                            <th class="text-center" style="width: 150px">Amount</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $key => $stock)
                                        <tr>
                                            <td class="text-center">{{ ++$key }} </td>
                                            <td>{{ $stock->product->name }} </td>
                                            <td>{{ $stock->productPackSize->size }} </td>
                                            <td class="text-center">{{ $stock->quantity }} </td>
                                            <input type="hidden" value="{{ $stock->quantity }}" id="quantity" name="quantity">
                                            <td class="text-center">{{ $stock->net_weight }} </td>
                                            <td class="text-center">{{ $stock->damage }} </td>
                                            @php
                                                if($stock->damage < 1 ){
                                                    $total = $stock->quantity + $stock->damage;
                                                }else{
                                                    $total = $stock->quantity - $stock->damage;
                                                }
                                            @endphp

                                            <td class="text-center {{($total<0)? 'bg-danger text-light':'' }}">{{ $total }} </td>
                                            <td><input type="text" name="rate" id="rate" class="form-control form-control-sm"></td>
                                            <td class="text-center"><input type="text" id="totalr" name="totalr" class="form-control form-control-sm"></td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('bulkStock.edit',$stock->id) }}" class="btn btn-link btn-info" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-edit"></i>
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

<script >
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
        });

        $('#multi-filter-select').DataTable( {
            "pageLength": 10,
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                            );

                        column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
    });
</script>

@endpush
@endsection

