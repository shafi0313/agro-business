@extends('admin.layout.master')
@section('title', 'Send to Store')
@section('content')
@php $p='factory'; $sm='bulkProduction'; $ssm='repackUnitShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('send-to-production.index')}}">Send to Store</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Send</li>
                </ul>
            </div>
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
                                <div class="col text-center">
                                    <p style="font-size: 30px; font-weight: bold;margin-top:-10px">Send to Store</p>
                                </div>
                            </div>

                        <form action="{{ route('send-to-production.store') }}" method="post">
                         @csrf
                            <input type="hidden" name="pur_inv_id" value="{{$invoice_id->id}}">
                            <input type="hidden" name="pur_product_id" value="{{$invoice_id->product_id}}">
                            <input type="hidden" name="pur_size_id" value="{{$invoice_id->size}}">
    {{--__________________________________Invoice Info Start__________________________________--}}
                            <div class="row justify-content-between">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Select Store <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm"  name="supplier_id" required>
                                            <option selected value disabled>Select Store</option>
                                            @foreach ($stores as $store)
                                            <option value="{{$store->id}}">{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Challan No:</label>
                                        <input type="number" readonly name="challan_no" value="{{ $invoice_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="" class="form-label form-label-sm">Production Date <span class="t_r">*</span></label>
                                        <input type="date" name="delivery_date" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">FM Id <span class="t_r">*</span></label>
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
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Group Name <span class="t_r">*</span></label>
                                    <select  name="production_product_id" id="group_name_production" class="form-control form-control-sm">
                                        <option selected value disabled>Select</option>
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{ $product->generic }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Size <span class="t_r">*</span></label>
                                    <select id="production_product_size"  class="form-control form-control-sm" name="production_product_size"></select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="" class="form-label form-label-sm">Quantity <span class="t_r">*</span></label>
                                    <input type="text" name="production_product_quantity" id="production_product_quantity" class="form-control form-control-sm" readonly required>
                                </div>

                            </div>
                            <hr class="bg-warning">
{{--__________________________________Product Input Start__________________________________--}}
                            <div class="row mx-auto">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Brand Name <span class="t_r">*</span></th>
                                            <th>Group Name <span class="t_r">*</span></th>
                                            <th>Size <span class="t_r">*</span></th>
                                            <th>Batch No. <span class="t_r">*</span></th>
                                            <th>Quantity <span class="t_r">*</span></th>
                                            <th style="width: 20px;text-align:center;">
                                                <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <input type="hidden" id="size_text">
                                        <input type="hidden"    id="product_id"  class="autocomplete_txt" />
                                        <td><input type="text"  id="product_name" data-type="product" class="form-control form-control-sm autocomplete_txt"  placeholder="" /></td>
                                        <td><input type="text"  id="group_name"  class="form-control form-control-sm autocomplete_txt"  /></td>
                                        <td><select id="sizee"  class="form-control form-control-sm" style="width:100px" ></select></td>
                                        <td><input type="text" id="batch_no" class="form-control form-control-sm" placeholder="" /></td>
                                        <td><input type="number" id="qty" class="form-control form-control-sm" placeholder="Quantity" /></td>
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
                                        <th width="">Brand Name:</th>
                                        <th width="">Group Name:</th>
                                        <th width="8%">Size: </th>
                                        <th width="8%">Batch No.: </th>
                                        <th width="7%">Quantity: </th>
                                        {{-- <th width="11%">Rate Per Qty:</th>
                                        <th width="10%">Bonus</th>
                                        <th width="12%">Amount</th> --}}
                                        <th width="3%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                            <input type="hidden" name="net_weight" id="net_weight" value="{{$invoice_id->net_weight}}">
                            <input type="hidden" name="db_use_weight" id="db_use_weight" value="{{$invoice_id->use_weight}}">
                            <div class="row justify-content-end">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Use Weight</label>
                                        <div class="col-sm-8">
                                          <input type="number" name="use_weight" id="use_weight" step="any" class="form-control" required>
                                          <span id="use_alert_msg"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        {{--__________________________________Product Show End__________________________________--}}
                            {{-- </div> --}}
                            <div class="text-center">
                                <input type="submit" value="Submit" class="btn btn-success" onclick='return btnClick();'>
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

@push('custom_scripts')
<script>
    // Quantity Calculation
    $("#use_weight").keyup(function(){
        var size = $("#production_product_size").find(":selected").text();
        var use_weight = $("#use_weight").val();
        var sizeNumber = size.match(/(\d)/g);
        if(sizeNumber==null){
            alert("select size")
            return false
        }
        sizeNumber = sizeNumber.join("");
        var quantity = use_weight / Number(sizeNumber)
        $("#production_product_quantity").val(quantity)
    })

     // Product Size
     $('#group_name_production').on('change',function(e) {
            // var size = $('#sizee').val();
            var cat_id = $('#group_name_production').val();
            $.ajax({
                url:'{{ route("bulkPackSize") }}',
                type:"get",
                data: {
                    cat_id: cat_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    $('#production_product_size').html(res.size);
                }
            })
        });

    $(document).ready(function(){
        $('.add_porduct').on('click', function() {
            var product_name    = $('#product_name').val();
            var product_id      = $('#product_id').val();
            var group_name      = $('#group_name').val();
            var size_text       = $('#size_text').val();
            var size_id         = $('#sizee').val();
            var batch_no        = $('#batch_no').val();
            var quantity        = $('#qty').val();
            // Validation
            if (product_name == '') {
                toast('warning', 'Please select brand name');
                $('#product_name').focus();
                return false;
            }

            // if (size_id == '') {
            //     toast('warning', 'Please select size');
            //     $('#sizee').focus();
            //     return false;
            // }

            if (quantity == '') {
                toast('warning', 'Please enter quantity');
                $('#qty').focus();
                return false;
            }


            var html = '<tr>';
            html += '<tr class="trData"><td class="serial text-center"></td><td>' + product_name + '</td><td>' + group_name + '</td><td class="text-center">'+ size_text +'</td><td class="text-center">' + batch_no + '</td><td class="text-center">' + quantity + '</td><td align="center">';
            html += '<input type="hidden" name="product_id[]" value="' + product_id + '" />';
            html += '<input type="hidden" name="size[]" value="' + size_id + '" />';
            html += '<input type="hidden" name="quantity[]" value="' + quantity + '" />';
            html += '<input type="hidden" name="batch_no[]" value="' + batch_no + '" />';
            html += '<a class="product_delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
            toast('success','Product Added');

            // Value reset
            $('.product_table tbody').append(html);
            $('#product_name').val('');
            $('#group_name').val('');
            $('#sizee').val('');
            $('#size_text').val('');
            $('#qty').val('');
            $('#batch_no').val('');

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
            $('#totalp').val(subtotal);
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
                    // alert(res.size_text)
                    $('#size_text').val(res.size_text);
                    // alert($('#size_text').val())

                }
            })
        });

        // Product Size
        $('#product_name').on('change',function(e) {
            var size = $('#sizee').val();
            var cat_id = $('#product_id').val();
            $.ajax({
                url:'{{ route("productSize") }}',
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
                url:'{{ route("productPriceCash") }}',
                type:"get",
                data: {
                    size_id: size_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    $('#price').val(res.cash_price);
                }
            })
        });

        // $('#qty').on('keyup',function(e) {
        //     var product_id = $('#product_id').val();
        //     var size_id = Number($('#sizee').val());
        //     var qty = Number($('#qty').val());
        //     var price = $('#price').val();
        //     var discount = $('#discount').val();
        //     var total = $('#totalamounval').val();
        //     var result = Number(qty)*Number(price);
        //     $('#subtotal').val(result);
        //     total_price();
        //     $.ajax({
        //         url:'{{ route("productStockCheck") }}',
        //         type:"get",
        //         data: {
        //             product_id: product_id,
        //             size_id: size_id
        //             },
        //         success:function (res) {
        //             res = $.parseJSON(res);
        //             if(qty > res.quantity){
        //                 $('#msg').html("In Stock " + (res.quantity));
        //             }else if(qty < res.quantity){
        //                 $('#msg').html('');
        //             }
        //         }
        //     })
        // });

        // Total Price
        function total_price(){
            var total = 0;
            $('input.subtotal').each(function() {
                total +=Number($(this).val());
            });
            $('#totalamounval').val(total);
        }

        // $('#discountAmt').keyup(function() {
        //     var sum = 0;
        //     var sumTk = 0;
        //     var amt = $("#total_amount").val()
        //     var discount = $("#discountAmt").val()
        //     var percent = Number(amt)*Number(discount)/100;

        //     $('#totalp').each(function() {
        //         sum = Number(amt) - Number(percent);
        //     });
        //     $('#discountTk').each(function() {
        //         sumTk = Number(percent);
        //     });

        //     // credit_limit
        //     var credit_limit = Number($('#credit_limit').val())
        //     var due_amt = $('#due_amt').val()
        //     var totalp = $('#totalp').val()
        //     var total = Number(sum) + Number(due_amt);
        //     if(total>credit_limit){
        //         $('#credit_limit_m').html(credit_limit - total + ' Credit limit over');
        //     }else{
        //         $('#credit_limit_m').html('')
        //     }

        //     $('#totalp').val(sum);
        //     $('#discountTk').val(sumTk);
        // });

        //autocomplete script
        $(document).on('focus', '.autocomplete_txt', function () {
            type = $(this).data('type');
            if (type == 'product') autoType = 'name';
            // if (type == 'medicinesId') autoType = 'id';
            $(this).autocomplete({
                minLength: 0,
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('productSearch') }}",
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
                    $('#product_name' ).val(data.name);
                    $('#group_name').val(data.generic);
                }
            });
        });
})
</script>

{{-- <script>
    $('#use_weight').keyup(function(){
        var net_weight = Number($('#net_weight').val())
        var use_weight = Number($('#use_weight').val())
        var db_use_weight = Number($('#db_use_weight').val())
        // alert(use_weight + db_use_weight)
        if((use_weight + db_use_weight) > (net_weight )){
            $('#use_alert_msg').html('Use Weight Over')
        }else{
            $('#use_alert_msg').html('')
        }
    })


    function btnClick() {
        var net_weight = Number($('#net_weight').val())
        var use_weight = Number($('#use_weight').val())
        var db_use_weight = Number($('#db_use_weight').val())
        if((use_weight + db_use_weight) > (net_weight )){
            alert('Use Weight Over')
            return false;
        }
    }
</script> --}}


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
