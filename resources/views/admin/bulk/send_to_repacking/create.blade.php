@extends('admin.layout.master')
@section('title', 'Send To Repack Unit')
@section('content')
@php $p='factory'; $sm="balkRepack"; $ssm = 'bulkShow' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('purchase-bulk.index')}}">Send To Repack Unit</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-3">
                                    {{-- Company Info --}}
                                    @include('admin.company_info.address_for_page')
                                </div>
                                <div class="col text-center">
                                    <p style="font-size: 30px; font-weight: bold;margin-top:-10px">Send to Repack Unit</p>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-size: 18px;font-weight:600;background:green;color:white;margin:0;padding:0px 5px">Bill To</p>
                                    <p style="font-size: 15px">
                                        <span>{{ $supplier->name }}</span><br>
                                        <span>{{ $supplier->address }}</span>
                                    </p>
                                </div>
                            </div>

                        <form action="{{ route('send-to-repack-unit.store') }}" method="post">
                         @csrf
                            <input type="hidden" name="supplier_id" value="{{$supplier->id}}">

    {{--__________________________________Invoice Info Start__________________________________--}}
                            <div class="row " >
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""   class="form-label form-label-sm">Challan No</label>
                                        <input type="number" name="challan_no" value="{{$challan_no}}" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{-- <div class="form-group">
                                        <label for=""   class="form-label form-label-sm">Invoice No <span class="t_r">*</span></label>
                                        <input type="number" name="invoice_no" value="" class="form-control form-control-sm" required>
                                    </div> --}}
                                </div>
                                {{-- <div class="col-md-3"></div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""   class="form-label form-label-sm">Date <span class="t_r">*</span></label>
                                        <input type="date" name="invoice_date" value="" class="form-control form-control-sm" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">CEO Id <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="user_id" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($userId as $id)
                                                <option value="{{ $id->id }}">{{ $id->tmm_so_id }}-{{$id->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
    {{--__________________________________Invoice Info End__________________________________--}}
                            <hr class="bg-warning">
    {{--__________________________________Product Input Start__________________________________--}}
                            <div class="row mx-auto">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Group Name <span class="t_r">*</span></th>
                                            <th>Size <span class="t_r">*</span></th>
                                            <th>Quantity <span class="t_r">*</span></th>
                                            {{-- <th>Rate Per kg/ltr <span class="t_r">*</span></th> --}}
                                            <th>Net Weight</th>
                                            {{-- <th>Amount</th> --}}
                                            <th style="width: 20px;text-align:center;">
                                                <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <input type="hidden"      name="weight[]"   id="weight"  data-type="weight"  class="form-control form-control-sm autocomplete_txt" />
                                        <input type="hidden" id="size_text">
                                        <input type="hidden"    id="product_id"  class="autocomplete_txt" />
                                        <td><input type="text"  id="group_name" data-type="product" class="form-control form-control-sm autocomplete_txt" style="min-width:200px" /></td>
                                        <td><select id="sizee"  class="form-control form-control-sm" style="width:100px" ></select></td>
                                        <td><span id="msg"    style="color: red"></span><input type="number" id="qty"  class="form-control form-control-sm qty" placeholder="Quantity" /></td>
                                        {{-- <td><input type="number" id="price"  data-type="price" class="form-control form-control-sm qty" placeholder="Rate" /></td> --}}
                                        <td><input type="number" id="net_weight" value="0" class="form-control form-control-sm" placeholder=""/></td>
                                        {{-- <td><input type="number" id="subtotal" step="any" class="form-control form-control-sm subtotal" placeholder="amount" readonly ></td> --}}
                                        <td><button class="btn btn-success btn-sm add_porduct" type="button">Add</button></td>
                                    </tr>
                                </table>
                            </div>
    {{--__________________________________Product Input Start__________________________________--}}
                            <hr class="bg-warning">
    {{--__________________________________Product Show Start__________________________________--}}
                            <table class="table table-bordered table-hover table-sm product_table ">
                                <thead class="text-center" style="font-size: 15px;">
                                    <tr>
                                        <th width="4%">SN</th>
                                        <th width="%">Group Name:</th>
                                        <th width="8%">Size: </th>
                                        <th width="7%">Quantity:</th>
                                        {{-- <th width="11%">Rate Per kg/ltr:</th> --}}
                                        <th>Net Weight</th>
                                        {{-- <th width="12%">Amount</th> --}}
                                        <th width="3%"></th>
                                    </tr>
                                    @if (isset($ledgerPayment->net_amt))
                                    <input type="hidden" id="due_amt" value="{{$ledgerPayment->sum('net_amt') - $ledgerPayment->sum('payment') }}">
                                    <input type="hidden" id="credit_limit" value="{{$ledgerPayment->customer->credit_limit}}">
                                    @endif
                                </thead>
                                <tbody>
                                </tbody>
                                <style>
                                    tfoot tr td{
                                        text-align: right; font-size:16px; font-weight:bold
                                    }
                                </style>
                                {{-- <tfoot id="totalamount">
                                    <tr>
                                        <th colspan="6" class="text-right">Total:</th>
                                        <th class="text-right sub-total">0.00 </th>
                                        <th><input type="hidden" name="total_amt" id="total_amount"></th>
                                    </tr>
                                </tfoot> --}}
                            </table>
    {{--__________________________________Product Show End__________________________________--}}

                            <div class="text-center">
                                <input type="submit" value="Submit" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                    {{-- Page Content End --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<tr>
    <td style="width: 40%; vertical-align: middle;">Basic alert</td>
    <td>
        <button type="button" class="btn btn-info" id="alert_demo_1"> Show me</button>
    </td>
</tr>

@push('custom_scripts')
<script>
    $(document).ready(function(){
        $('.add_porduct').on('click', function() {
            // var product_name    = $('#product_name').val();
            var product_id      = $('#product_id').val();
            var group_name      = $('#group_name').val();
            var size_text       = $('#size_text').val();
            var size_id         = $('#sizee').val();
            var quantity        = $('#qty').val();
            var net_weight      = $('#net_weight').val();
            var checkStock = $('#msg').text()
            // Validation
            if (group_name == '') {
                toast('warning', 'Please select group name');
                $('#product_name').focus();
                return false;
            }

            if (size_id == '') {
                toast('warning', 'Please select size');
                $('#sizee').focus();
                return false;
            }

            if (quantity == '') {
                toast('warning', 'Please enter quantity');
                $('#qty').focus();
                return false;
            }

            if (checkStock != '') {
                toast('error', 'Out Of stock');
                return false;
            }

            // var totalamount =  quantity*rate_per_qty;
            var html = '<tr>';
            html += '<tr class="trData"><td class="serial text-center"></td><td>' + group_name + '</td><td class="text-center">'+ size_text +'</td><td class="text-center">' + quantity + '</td><td class="text-center">'+net_weight+'</td><td align="center">';
            html += '<input type="hidden" name="product_id[]" value="' + product_id + '" />';
            html += '<input type="hidden" name="size[]" value="' + size_id + '" />';
            html += '<input type="hidden" name="quantity[]" value="' + quantity + '" />';
            html += '<input type="hidden" name="net_weight[]" value="' + net_weight + '" />';
            html += '<a class="product_delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
            toast('success','Product Added');

            // Value reset
            $('.product_table tbody').append(html);
            $('#product_name').val('');
            $('#group_name').val('');
            $('#sizee').val('');
            $('#size_text').val('');
            $('#qty').val('');
            $('#net_weight').val('');

            serialMaintain();
        });

        // Delete
        $('.product_table').on('click', '.product_delete', function(e) {
            var element = $(this).parents('tr');
            element.remove();
            toast('warning','Product Removed!');
            e.preventDefault();
            serialMaintain();
        });

        // Subtotal
        function serialMaintain() {
            var i = 1;
            var subtotal = 0;
            $('.serial').each(function(key, element) {
                $(element).html(i);
                var total = $(element).parents('tr').find('input[name="amt[]"]').val();
                subtotal += + parseFloat(total);
                i++;
            });

            $('.sub-total').html(subtotal.toFixed(2));
            $('#total_amount').val(subtotal);
            // $('#totalp').val(subtotal);
        };


        $('#sizee').on('change',function(e) {
            var size_text = $('#sizee').val();
            $.ajax({
                url:'{{ route("productSizeId") }}',
                type:"get",
                data: {
                    size_text: size_text
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    console.log(res.size_text)
                    $('#size_text').val(res.size_text);
                }
            });

            var cat_id = $('#sizee').val();
            $.ajax({
                url:'{{ route("bulkSize") }}',
                type:"get",
                data: {
                    cat_id: cat_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    console.log(res.tradeWeight)
                    $('#weight').val(res.tradeWeight);
                }
            })
        });

        // Product Size
        $('#group_name').on('change',function(e) {
            var size = $('#sizee').val();
            var cat_id = $('#product_id').val();
            $.ajax({
                url:'{{ route("bulkPackSize") }}',
                type:"get",
                data: {
                    cat_id: cat_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    $('#sizee').html(res.size);
                }
            })
        });


        // Product Price
        $('#sizee').on('change',function(e) {
            var size_id = $('#sizee').val();
            $.ajax({
                url:'{{ route("bulkPrice") }}',
                type:"get",
                data: {
                    size_id: size_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    $('#price').val(res.purchase);
                }
            })
        });

        $('.qty').on('keyup',function(e) {

            var product_id = Number($('#product_id').val());
            var size_id = Number($('#sizee').val());
            var qty = Number($('#qty').val());
            var weight = $('#weight').val();
            var price = $('#price').val();
            var total = $('#totalamounval').val();
            var result = Number(qty)*Number(price);

            $('.qty').each(function() {
                sum = Number(qty)*Number(weight);
            });

            $('#net_weight').val(sum);
            $('#subtotal').val(result);
            total_price();

            $.ajax({
                url:'{{ route("bulkStockCheck") }}',
                type:"get",
                data: {
                    product_id: product_id,
                    size_id: size_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    // console.log(res.quantity)
                    if(qty > res.quantity){
                        $('#msg').html("In Stock " + (res.quantity));
                    }else if(qty < res.quantity){
                        $('#msg').html('');
                    }
                }
            })
        });

        // Total Price
        function total_price()
        {
            var total = 0;
            $('input.subtotal').each(function() {
                total +=Number($(this).val());
            });
            $('#totalamounval').val(total);
        }

        //autocomplete script
        $(document).on('focus', '.autocomplete_txt', function () {
            type = $(this).data('type');
            if (type == 'product') autoType = 'name';
            // if (type == 'medicinesId') autoType = 'id';
            $(this).autocomplete({
                minLength: 0,
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('PurchaseProductSearch') }}",
                        dataType: "json",
                        data: {
                            term: request.term,
                            type: type,
                        },
                        success: function (data) {
                            var array = $.map(data, function (item) {
                                return {
                                    label: item[autoType],
                                    value: item[autoType],
                                    data: item
                                }
                            });
                            response(array)
                        }
                    });
                },
                select: function (event, ui) {
                    var data = ui.item.data;
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    elementId = id[id.length - 1];
                    $('#product_id' ).val(data.id);
                    // $('#product_name' ).val(data.name);
                    $('#group_name').val(data.generic);
                }
            });
        });
})
</script>

<script>
    function toast(status,header,msg) {
        Command: toastr[status](header, msg)
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>
@endpush
@endsection
