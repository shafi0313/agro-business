@extends('admin.layout.master')
@section('title', 'Sales of Cash Return Invoice')
@section('content')
@php $p='sales'; $sm='salesCashRe' @endphp
<style>
    .invv ul{
        list-style: none;
        padding: 5px;
        margin: 0;
    }
    .invv ul li{
        padding: 5px;
        cursor: pointer;
    }
    /* .table thead tr th{font-weight: bold; text-align: center} */

</style>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Sales of Cash Return Invoice</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create</li>
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
                                <div class="col-md-3">
                                    {{-- Company Info --}}
                                    @include('admin.company_info.address_for_page')
                                </div>
                                <div class="col text-center">
                                    <p style="font-size: 30px; font-weight: bold;margin-top:-10px">Sales of Cash Return Invoice</p>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-size: 18px;font-weight:600;background:green;color:white;margin:0;padding:0px 5px">Bill To</p>
                                    <p style="font-size: 15px">
                                        <span>{{ $customer->business_name }}, {{ $customer->name }}</span><br>
                                        <span>{{ $customer->address }}</span>
                                    </p>
                                </div>
                            </div>

                        <form action="{{ route('sales-invoice-cash-return.store') }}" method="post" onsubmit="return validate()">
                         @csrf
                            <input type="hidden" id="customer_id" name="customer_id" value="{{$customer->id}}">
    {{--__________________________________Invoice Info Start__________________________________--}}
                            <div class="row justify-content-between">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Invoice No:</label>
                                        <input type="number" readonly name="store_invoice_no" value="{{ $invoice_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Challan No:</label>
                                        <input type="number" readonly name="challan_no" value="{{ $challan_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="invoice_date" class="form-label form-label-sm">Invoice Date <span class="t_r">*</span></label>
                                        <input type="date" name="invoice_date" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="" class="form-label form-label-sm">Return Type <span class="t_r">*</span></label>
                                        <select name="r_type" id="" class="form-control form-control-sm" required>
                                            <option value="">Select</option>
                                            <option value="20">Expired</option>
                                            <option value="21">Unsold</option>
                                            <option value="22">Damage</option>
                                        </select>
                                        {{-- <input type="date" name="delivery_date" class="form-control form-control-sm" required> --}}
                                    </div>
                                </div>
                                {{-- <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm text-danger">Payment Date <span class="t_r">*</span></label>
                                        <input type="date" name="payment_date" class="form-control form-control-sm" required>
                                    </div>
                                </div> --}}
                            {{-- </div>
                            <div class="row justify-content-end"> --}}
                                @isset($customer->customerInfo->type)
                                    @if ($customer->customerInfo->type==1)
                                    @php $type = 'Dealer' @endphp
                                    @elseif ($customer->customerInfo->type==2)
                                    @php $type = 'Retailer' @endphp
                                    @endif
                                @else
                                @php $type = '' @endphp
                                @endisset
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Type <span class="t_r">*</span></label>
                                        <input type="text" readonly class="form-control form-control-sm" value="{{$type}}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Officer Id <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="user_id" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($userId as $id)
                                                <option value="{{$id->user_id}}">{{ $id->userForSR->tmm_so_id }}=>{{ $id->userForSR->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Inv Type <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="inv_type" id="inv_type" required>
                                            <option selected value disabled>Select</option>
                                            <option value="2" >Cash</option>
                                            <option value="4" >Credit</option>
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
                                            <th>Invoice No <span class="t_r">*</span></th>
                                            <th>Brand Name <span class="t_r">*</span></th>
                                            {{-- <th>Group Name <span class="t_r">*</span></th> --}}
                                            <th>Size <span class="t_r">*</span></th>
                                            <th>Quantity <span class="t_r">*</span></th>
                                            <th>Rate Per Qty <span class="t_r">*</span></th>
                                            <th>Bonus</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
                                            <th style="width: 20px;text-align:center;">
                                                <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <input type="hidden" id="sub-total-temp">
                                        <input type="hidden" id="size_text">
                                        <input type="hidden" id="size_id">
                                        <input type="hidden" id="inv_id">
                                        {{-- <input type="hidden" id="invoice_no"> --}}
                                        <input type="hidden"    id="product_id"  class="autocomplete_txt" />
                                        <td><input type="text"  id="invoice_no" data-type="invoice_no" class="form-control form-control-sm autocomplete_txt" style="width:200px" placeholder="" /></td>
                                        <td><input type="text"  id="product_name" class="form-control form-control-sm" style="width:200px" placeholder="" readonly/></td>
                                        {{-- <td><input type="text"  id="group_name"  class="form-control form-control-sm" style="min-width:200px" /></td> --}}
                                        <td><input id="sizee"  class="form-control form-control-sm" style="width:100px" readonly></td>
                                        <td><input type="number" id="qty" class="form-control form-control-sm qty" placeholder="Quantity" /></td>
                                        <td><input type="number" id="rate_per_qty"  data-type="price" class="form-control form-control-sm qty" placeholder="Rate" /></td>
                                        <td><input type="number" id="bonus" value="0" class="form-control form-control-sm" placeholder=""/></td>
                                        <td><input type="number" id="pro_dis" value="0" class="form-control form-control-sm" placeholder=""/></td>
                                        <td><input type="number" id="subtotal" step="any" class="form-control form-control-sm subtotal" placeholder="amount" readonly ></td>
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
                                        <th width="%">Invoice No</th>
                                        <th width="%">Brand Name:</th>
                                        {{-- <th width="%">Group Name:</th> --}}
                                        <th width="8%">Size: </th>
                                        <th width="7%">Quantity:</th>
                                        <th width="11%">Rate Per Qty:</th>
                                        <th width="10%">Bonus</th>
                                        <th width="10%">Discount</th>
                                        <th width="12%">Amount</th>
                                        <th width="3%"></th>
                                    </tr>
                                    @if ($ledgerPayment->sum('net_amt') - $ledgerPayment->sum('payment'))
                                    <input type="hidden" id="due_amt" value="{{$ledgerPayment->sum('net_amt') - $ledgerPayment->sum('payment') }}">
                                    @else
                                    <input type="hidden" id="due_amt" value="0">
                                    @endif
                                    <input type="hidden" id="credit_limit" value="{{$customer->customerInfo->credit_limit}}">
                                </thead>
                                <tbody>
                                </tbody>
                                <style>
                                    tfoot tr td{
                                        text-align: right; font-size:16px; font-weight:bold
                                    }
                                </style>
                                <tfoot id="totalamount">
                                    <tr>
                                        <th colspan="8" class="text-right">Total:</th>
                                        <th class="text-right sub-total">0.00 </th>
                                        <th><input type="hidden" name="total_amt" id="total_amount"></th>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Discount: <span class="t_r">*</span></td>
                                        <td colspan="2"><input required type="number" id="discountAmt" step="any" name="discount" class="form-control form-control-sm" style="width:50%; display:inline-block"><input style="width:50%;display:inline-block" type="number" name="discount_amt" id="discountTk" step="any" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Net Payable:</td>
                                        <td colspan="2"><input type="number" id="net_amt" step="any" name="net_amt" class="form-control form-control-sm" readonly><span id="credit_limit_m" class="text-danger"></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        {{--__________________________________Product Show End__________________________________--}}

                        <hr class="bg-warning">
                            <div class="form-check">
                                <label class="form-check-label" >
                                    <input class="form-check-input" type="checkbox" id="note">
                                    <span class="form-check-sign" style="font-size: 16px">Note</span>
                                </label>
                            </div>
                            <div class="col-md-12" id="note_text" style="display: none">
                                <div class="form-group ">
                                    {{-- <label for="" class="form-label form-label-sm">Note</label> --}}
                                    <textarea name="note" class="form-control"   style="width: 100%;"></textarea>
                                </div>
                            </div>



                            <div class="text-center">
                                <input type="submit" value="Submit" class="btn btn-success" id="btn_submit" onclick='return btnClick();'>
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
    $("#due").click(function(){
        $("#due_text").slideToggle();
    });

    $("#note").click(function(){
        $("#note_text").slideToggle();
    });

    function validate() {
        $("#btn_submit").attr('disabled', 'disabled');
    }

    $(document).ready(function(){
        $('.add_porduct').on('click', function() {
            var inv_id          = $('#inv_id').val();
            var invoice_no      = $('#invoice_no').val();
            var product_name    = $('#product_name').val();
            var product_id      = $('#product_id').val();
            // var group_name      = $('#group_name').val();
            var size_text       = $('#sizee').val();
            var size_id         = $('#size_id').val();
            var quantity        = $('#qty').val();
            var rate_per_qty    = $('#rate_per_qty').val();
            var bonus           = $('#bonus').val();
            var pro_dis           = $('#pro_dis').val();
            var checkStock = $('#msg').text();

            var inv = invoice_no.substr(0,invoice_no.indexOf(' '));

            console.log(size_id)

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

            if (checkStock != '') {
                toast('error', 'Out Of stock');
                return false;
            }

            var proDiscount = Number((quantity*rate_per_qty)*pro_dis/100);

            var totalamount =  quantity*rate_per_qty - proDiscount;
            var html = '<tr>';
            html += '<tr class="trData"><td class="serial text-center"></td><td>' + inv  + '</td><td>' + product_name + '</td><td class="text-center">'+ size_text +'</td><td class="text-center">' + quantity + '</td><td class="text-right">' + parseFloat(rate_per_qty).toFixed(2) + '</td><td class="text-center">'+bonus+'</td><td class="text-center">'+pro_dis+'</td><td class="text-right">' + parseFloat(totalamount).toFixed(2) + '</td><td align="center">';
            html += '<input type="hidden" name="invoice_no[]" value="' + inv + '" />';
            html += '<input type="hidden" name="product_id[]" value="' + product_id + '" />';
            html += '<input type="hidden" name="size[]" value="' + size_id + '" />';
            html += '<input type="hidden" name="quantity[]" value="' + quantity + '" />';
            html += '<input type="hidden" name="rate_per_qty[]" value="' + rate_per_qty + '" />';
            html += '<input type="hidden" name="bonus[]" value="' + bonus + '" />';
            html += '<input type="hidden" name="pro_dis[]" value="' + pro_dis + '" />';
            html += '<input type="hidden" name="amt[]" value="' + totalamount + '" />';
            html += '<input type="hidden" name="inv_id[]" value="' + inv_id + '" />';
            html += '<a class="product_delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
            toast('success','Product Added');

            // Value reset
            $('.product_table tbody').append(html);
            $('#product_name').val('');
            // $('#group_name').val('');
            $('#sizee').val('');
            $('#size_text').val('');
            $('#qty').val('');
            $('#price').val('');
            $('#bonus').val(0);
            $('#pro_dis').val(0);
            $('#subtotal').val('');
            $('#discountAmt').val(0);
            $('#invoice_no').val('');
            $('#rate_per_qty').val(0);
            $('#inv_id').val('');

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
            $('#net_amt').val(subtotal);
        };


        // $('#sizee').on('change',function(e) {
        //     var size_text = $('#sizee').val();
        //     $.ajax({
        //         url:'{{ route("productSizeId") }}',
        //         type:"get",
        //         data: {
        //             size_text: size_text
        //             },
        //         success:function (res) {
        //             res = $.parseJSON(res);
        //             console.log(res.size_text)
        //             $('#size_text').val(res.size_text);

        //         }
        //     })
        // });

        // Product Size
        $('#invoice_no').on('change',function(e) {
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
        // $('#sizee').on('change',function(e) {
        //     var size_id = $('#sizee').val();
        //     $.ajax({
        //         url:'{{ route("productPriceCash") }}',
        //         type:"get",
        //         data: {
        //             size_id: size_id
        //             },
        //         success:function (res) {
        //             res = $.parseJSON(res);
        //             $('#price').val(res.cash_price);
        //         }
        //     })
        // });

        $('.qty').on('keyup',function(e) {
            var product_id = $('#product_id').val();
            var size_id = Number($('#sizee').val());
            var qty = $('#qty').val();
            var price = $('#price').val();
            var discount = Number($('#discount').val());
            var total = Number($('#totalamounval').val());
            var result = 0;

            $('.qty').each(function() {
                result = Number(qty)*Number(price);
            });

            $('#subtotal').val(result);
            $('#sub-total-temp').val(result);

            total_price();
            $.ajax({
                url:'{{ route("productStockCheck") }}',
                type:"get",
                data: {
                    product_id: product_id,
                    size_id: size_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    if(qty > res.quantity){
                        $('#msg').html("In Stock " + (res.quantity));
                    }else if(qty < res.quantity){
                        $('#msg').html('');
                    }
                }
            })
        });

        // Total Price
        function total_price(){
            var total = 0;
            $('input.subtotal').each(function() {
                total +=Number($(this).val());
            });
            $('#totalamounval').val(total);
        }


        $('#pro_dis').keyup(function() {
            var pro_dis = Number($("#pro_dis").val())
            var subTotalTemp = Number($("#sub-total-temp").val())
            var result = (pro_dis * subTotalTemp)/100;
            $('#subtotal').val(subTotalTemp - result);
        })


        $('#discountAmt').keyup(function() {
            // $('#discountTk').attr('readonly',true)
            // $('#discountAmt').attr('readonly',false)
            var sum = 0;
            var sumTk = 0;
            var amt = $("#total_amount").val()
            var discount = $("#discountAmt").val()
            var percent = Number(amt)*Number(discount)/100;

            $('#net_amt').each(function() {
                sum = Number(amt) - Number(percent);
            });
            $('#discountTk').each(function() {
                sumTk = Number(percent);
            });


            // credit_limit
            // var credit_limit = Number($('#credit_limit').val())
            // var due_amt = $('#due_amt').val()
            // var net_amt = $('#net_amt').val()
            // var total = Number(sum) + Number(due_amt);
            // if((credit_limit > 0) && (total > credit_limit)){
            //     $('#credit_limit_m').html(credit_limit - total + ' Credit limit over');
            // }else{
            //     $('#credit_limit_m').html('')
            // }

            $('#net_amt').val(Math.round(sum));
            $('#discountTk').val(sumTk);
        });

        $('#discountTk').keyup(function() {
            // $('#discountAmt').attr('readonly',true)
            // $('#discountTk').attr('readonly',false)
            var sum = 0;
            var sumTk = 0;
            var amt = $("#total_amount").val()
            var discountTk = $("#discountTk").val()
            var percent = Number(discountTk)*100/ Number(amt);

            $('#net_amt').each(function() {
                sum = Number(amt) - Number(discountTk);
            });
            $('#discountTk').each(function() {
                sumTk = Number(percent);
            });

            // credit_limit
            // var credit_limit = Number($('#credit_limit').val())
            // var due_amt = $('#due_amt').val()
            // var net_amt = $('#net_amt').val()
            // var total = Number(sum) + Number(due_amt);
            // if((credit_limit > 0) && (total > credit_limit)){
            //     $('#credit_limit_m').html(credit_limit - total + ' Credit limit over');
            // }else{
            //     $('#credit_limit_m').html('')
            // }

            $('#net_amt').val(Math.round(sum));
            $('#discountAmt').val(sumTk.toFixed(2));
        });

        //autocomplete script
        $(document).on('focus', '.autocomplete_txt', function () {
            var customer_id = $("#customer_id").val()
            type = $(this).data('type');
            if (type == 'invoice_no') autoType = 'invoice_no';
            // if (type == 'medicinesId') autoType = 'id';
            $(this).autocomplete({
                minLength: 0,
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('invoiceSearch') }}",
                        dataType: "json",
                        data: {
                            term: request.term,
                            type: type,
                            customer_id: customer_id,
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
                    $('#inv_id').val(data.inv_id);
                    $('#invoice_no').val(data.invoice_no);
                    $('#product_id' ).val(data.product_id);
                    $('#product_name' ).val(data.product_name);
                    $('#sizee' ).val(data.size);
                    $('#size_id' ).val(data.size_id);
                    $('#qty' ).val(data.quantity);
                    $('#bonus' ).val(data.bonus);
                    $('#rate_per_qty' ).val(data.rate_per_qty);
                    $('#pro_dis' ).val(data.pro_dis);
                    $('#subtotal' ).val(data.amt);
                    // $('#group_name').val(data.generic);
                }
            });
        });
})
</script>

<script>
    // function btnClick() {
    //     var checkLimit = $('#credit_limit_m').text()
    //     var discountAmt = Number($("#discountAmt").val())
    //     var net_amt = Number($("#net_amt").val())
    //     if(checkLimit !=''){
    //         alert('Credit Limit Is Over, Please Increase Your Credit Limit Or Pay Due Amount')
    //         return false;
    //     }

    //     if((discountAmt > 100 || net_amt < 0)){
    //         alert('Check Discount Amount')
    //         return false;
    //     }
    // }
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
