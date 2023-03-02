@extends('admin.layout.master')
@section('title', 'Sales of Cash Invoice')
@section('content')
@php $p='sales'; $sm='salesCash' @endphp
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
                    <li class="nav-item">Sales</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Sales</a></li>
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
                                <div class="col text-center">
                                    <p style="font-size: 20px; font-weight: bold;margin-top:-10px">Create Invoice</p>
                                </div>
                            </div>

                        <form action="{{ route('create-invoice.store') }}" method="post">
                         @csrf
                            <input type="hidden" name="inv_stock_check" id="inv_stock_check" value="{{setting('inv_stock_check')}}">
    {{--__________________________________Invoice Info Start__________________________________--}}
                        <style>
                            .col {
                                padding: 0px 0px !important;
                            }
                        </style>
                            <div class="row justify-content-between">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Customer <span class="t_r">*</span></label>
                                        <select name="customer_id" id="customer_id" class="form-control select2single" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Invoice No:</label>
                                        <input type="number" readonly name="invoice_no" value="{{ $invoice_no }}" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Challan No:</label>
                                        <input type="number" readonly name="challan_no" value="{{ $challan_no }}" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="invoice_date" class="form-label form-label-sm">Invoice Date <span class="t_r">*</span></label>
                                        <input type="date" name="invoice_date" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="" class="form-label form-label-sm">Delivery Date <span class="t_r">*</span></label>
                                        <input type="date" name="delivery_date" class="form-control " required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm text-danger">Payment Date <span class="t_r">*</span></label>
                                        <input type="date" name="payment_date" class="form-control " required>
                                    </div>
                                </div>

                                {{-- @if (setting('inv_officer_id') == 1)
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Officer Id <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="user_id"  {{ setting('inv_officer_id')==1?'required':'' }}>
                                            <option selected value disabled>Select</option>
                                            @foreach ($userId as $id)
                                                <option value="{{$id->user_id}}">{{$id->user_id}}{{ $id->userForSR->tmm_so_id }}=>{{ $id->userForSR->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif --}}

                                {{-- <div class="col">
                                    <div class="form-group">
                                        <label for="">Inv Type <span class="t_r">*</span></label>
                                        <select class="form-control " name="inv_type" id="inv_type" required>
                                            <option selected value disabled>Select</option>
                                            <option value="1" >Cash</option>
                                            <option value="3" >Credit</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
    {{--__________________________________Invoice Info End__________________________________--}}
                            <hr class="bg-warning">
    {{--__________________________________Product Input Start__________________________________--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-responsive w-100">
                                        <thead>
                                            <tr>
                                                <th width="14%">Product Name <span class="t_r">*</span></th>
                                                <th width="14%">Size <span class="t_r">*</span></th>
                                                <th width="14%">Quantity <span class="t_r">*</span></th>
                                                <th width="14%">Rate Per Qty <span class="t_r">*</span></th>
                                                <th width="14%">Bonus</th>
                                                <th width="14%">Discount</th>
                                                <th width="14%">Amount</th>
                                                <th style="width: 20px;text-align:center;">
                                                    <button type="button" class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <input type="hidden" id="sub-total-temp">
                                            <td>
                                                <select name="product_id" id="product_id" class="form-control select2single">
                                                    <option value="">Select</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><select id="size_id"  class="form-control"></select></td>
                                            <td><span id="msg" style="color: red"></span><input type="number" id="qty" class="form-control  qty" placeholder="Quantity" /></td>
                                            <td><input type="number" id="price"  data-type="price" class="form-control  qty" placeholder="Rate" /></td>
                                            <td><input type="number" id="bonus" value="0" class="form-control " placeholder=""/></td>
                                            <td><input type="number" id="pro_dis" value="0" class="form-control " placeholder=""/></td>
                                            <td><input type="number" id="subtotal" step="any" class="form-control  subtotal" placeholder="amount" readonly ></td>
                                            <td><button class="btn btn-success btn-sm add_porduct" type="button">Add</button></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
    {{--__________________________________Product Input Start__________________________________--}}
                            <hr class="bg-warning">
    {{--__________________________________Product Show Start__________________________________--}}
                            <table class="table table-responsive table-bordered table-hover product_table ">
                                <thead class="text-center" style="font-size: 15px;">
                                    <tr>
                                        <th width="4%">SN</th>
                                        <th width="%">Product Name:</th>
                                        <th width="8%">Size: </th>
                                        <th width="7%">Quantity:</th>
                                        <th width="11%">Rate Per Qty:</th>
                                        <th width="10%">Bonus</th>
                                        <th width="10%">Discount</th>
                                        <th width="12%">Amount</th>
                                        <th width="3%"></th>
                                    </tr>
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
                                        <td colspan="2"><input type="number" id="discountAmt" step="any" name="discount" class="form-control " style="width:50%; display:inline-block" placeholder="%"><input placeholder="Amount" style="width:50%;display:inline-block" type="number" name="discount_amt" id="discountTk" step="any" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Net Payable:</td>
                                        <td colspan="2"><input type="number" id="net_amt" step="any" name="net_amt" class="form-control " readonly><span id="credit_limit_m" class="text-danger"></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{--__________________________________Product Show End__________________________________--}}
                            {{--__________________________________ Payment Start __________________________________--}}
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="account_entry_id">Payment By </label>
                                    <select name="payment_by" id="payment_by" class="form-control" >
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4 bankListShow" style="display: none">
                                    <label for="account_entry_id">Bank Name <span class="t_r">*</span></label>
                                    <select id="bank" class="form-control requiredBank">
                                        <option selected value disabled>Select</option>
                                        @foreach ($bankLists as $bankList)
                                            <option value="{{ $bankList->id }}">{{ $bankList->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-4 bankListShow" style="display: none">
                                    <label for="bank_ac_no">Account No <span class="t_r">*</span></label>
                                    <select name="user_bank_ac_id" id="ac_no" class="form-control requiredBank"></select>
                                </div>

                                <div class="form-group col-sm-4 bankListShow" style="display: none">
                                    <label for="cheque_no">Cheque/DS/V No <span class="t_r">*</span></label>
                                    <input name="cheque_no" id="ac_no" class="form-control requiredBank">
                                </div>

                                <div class="form-group col-sm-4 paymentAmt" style="display: none">
                                    <label for="credit">Amount <span class="t_r">*</span></label>
                                    <input type="text" step="any" id="amount" name="credit" class="form-control required amount @error('credit') is-invalid @enderror">
                                    @error('credit')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{--__________________________________ Payment End __________________________________--}}

                            <hr class="bg-warning">
                            <div class="form-check">
                                <label class="form-check-label" >
                                    <input class="form-check-input" type="checkbox" id="note">
                                    <span class="form-check-sign" style="font-size: 16px">Note</span>
                                </label>
                            </div>
                            <div class="col-md-12" id="note_text" style="display: none">
                                <div class="form-group ">
                                    <textarea name="note" class="form-control"   style="width: 100%;"></textarea>
                                </div>
                            </div>

                            <hr class="bg-warning">
    {{--__________________________________ Product Input Start__________________________________--}}


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
    $(document).ready(function(){
        $('.add_porduct').on('click', function() {
            let product_id      = $("#product_id :selected").val();
            let product_name      = $("#product_id :selected").text();

            let size_id      = $("#size_id :selected").val();
            let size_name      = $("#size_id :selected").text();

            let quantity        = $('#qty').val();
            let rate_per_qty    = $('#price').val();
            let bonus           = $('#bonus').val();
            let pro_dis           = $('#pro_dis').val();
            let checkStock = $('#msg').text()
            // Validation
            if (product_id == '') {
                toast('warning', 'Please select product name');
                $('#product_id').focus();
                return false;
            }
            if (quantity == '') {
                toast('warning', 'Please enter quantity');
                $('#qty').focus();
                return false;
            }
            if ($('#inv_stock_check').val() == 1 && checkStock != '') {
                toast('error', 'Out Of stock');
                return false;
            }

            let proDiscount = Number((quantity*rate_per_qty)*pro_dis/100);
            let totalamount =  quantity*rate_per_qty - proDiscount;
            let html = '<tr>';
            html += '<tr class="trData"><td class="serial text-center"></td><td>' + product_name + '</td><td class="text-center">'+ size_name +'</td><td class="text-center">' + quantity + '</td><td class="text-right">' + parseFloat(rate_per_qty).toFixed(2) + '</td><td class="text-center">'+bonus+'</td><td class="text-center">'+pro_dis+'</td><td class="text-right">' + parseFloat(totalamount).toFixed(2) + '</td><td align="center">';
            html += '<input type="hidden" name="product_id[]" value="' + product_id + '" />';
            html += '<input type="hidden" name="size_id[]" value="' + size_id + '" />';
            html += '<input type="hidden" name="quantity[]" value="' + quantity + '" />';
            html += '<input type="hidden" name="rate_per_qty[]" value="' + rate_per_qty + '" />';
            html += '<input type="hidden" name="bonus[]" value="' + bonus + '" />';
            html += '<input type="hidden" name="pro_dis[]" value="' + pro_dis + '" />';
            html += '<input type="hidden" name="amt[]" value="' + totalamount + '" />';
            html += '<a class="product_delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
            toast('success','Product Added');

            // Value reset
            $('.product_table tbody').append(html);
            $("#product_id").val(null).trigger('change')
            $("#size_id").val(null).trigger('change')
            $('#qty').val('');
            $('#price').val('');
            $('#bonus').val(0);
            $('#pro_dis').val(0);
            $('#subtotal').val('');
            $('#discountAmt').val('');

            serialMaintain();
        });

        // Delete
        $('.product_table').on('click', '.product_delete', function(e) {
            let element = $(this).parents('tr');
            element.remove();
            toast('warning','Product Removed!');
            e.preventDefault();
            serialMaintain();
        });

        // Subtotal
        function serialMaintain() {
            let i = 1;
            let subtotal = 0;
            $('.serial').each(function(key, element) {
                $(element).html(i);
                let total = $(element).parents('tr').find('input[name="amt[]"]').val();
                subtotal += + parseFloat(total);
                i++;
            });

            $('.sub-total').html(subtotal.toFixed(2));
            $('#total_amount').val(subtotal);
            $('#net_amt').val(subtotal);
        };

        // Product Size
        $('#product_id').on('change',function(e) {
            let cat_id = $(this).val();
            $.ajax({
                url:'{{ route("productSize") }}',
                type:"get",
                data: {
                    cat_id: cat_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    $('#size_id').html(res.size);
                }
            })
        });

        // Product Price
        $('#size_id').on('change',function(e) {
            let size_id = $(this).val();
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

        $('.qty').on('keyup',function(e) {
            let product_id = $("#product_id :selected").val();
            let size_id    = $("#size_id :selected").val();
            let qty        = Number($('#qty').val());
            let price      = $('#price').val();
            let discount   = $('#discount').val();
            let total      = $('#totalamounval').val();
            let result     = 0;

            $('.qty').each(function() {
                result = Number(qty)*Number(price);
            });
            $('#subtotal').val(result);
            $('#sub-total-temp').val(result);
            total_price();

            if($('#inv_stock_check').val() == 1){
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
            }
        });

        // Total Price
        function total_price(){
            let total = 0;
            $('input.subtotal').each(function() {
                total +=Number($(this).val());
            });
            $('#totalamounval').val(total);
        }

        $('#pro_dis').keyup(function() {
            let pro_dis = Number($("#pro_dis").val())
            let subTotalTemp = Number($("#sub-total-temp").val())
            let result = (pro_dis * subTotalTemp)/100;
            $('#subtotal').val(subTotalTemp - result);
        })

        // Discount
        $('#discountAmt').keyup(function() {
            let sum = 0;
            let sumTk = 0;
            let amt = $("#total_amount").val()
            let discount = $("#discountAmt").val()
            let percent = Number(amt)*Number(discount)/100;

            $('#net_amt').each(function() {
                sum = Number(amt) - Number(percent);
            });
            $('#discountTk').each(function() {
                sumTk = Number(percent);
            });

            $('#net_amt').val(Math.round(sum));
            $('#discountTk').val(sumTk);
        });

        $('#discountTk').keyup(function() {
            let sum = 0;
            let sumTk = 0;
            let amt = $("#total_amount").val()
            let discountTk = $("#discountTk").val()
            let percent = Number(discountTk)*100/ Number(amt);

            $('#net_amt').each(function() {
                sum = Number(amt) - Number(discountTk);
            });
            $('#discountTk').each(function() {
                sumTk = Number(percent);
            });

            $('#net_amt').val(Math.round(sum));
            $('#discountAmt').val(sumTk.toFixed(2));
        });
})


        $("#note").click(function(){
            $("#note_text").slideToggle();
        });

    function btnClick() {
        let discountAmt = Number($("#discountAmt").val())
        let net_amt = Number($("#net_amt").val())
        if((discountAmt > 100 || net_amt < 0)){
            alert('Check Discount Amount')
            return false;
        }
    }
</script>


<script>
$(document).ready(function(){
    $("#payment_by").on('change', function(){
            var pay_method = $(this).val();
            if(pay_method == 'Bank'){
                $(".bankListShow").css('display', 'block');
                $(".requiredBank").prop("required", true);
            } else {
                $(".bankListShow").css('display', 'none');
            }

            if(pay_method != ''){
                $(".paymentAmt").css('display', 'block');
                $(".required").prop("required", true);

            } else {
                $(".paymentAmt").css('display', 'none');
                $(".required").prop("required", false);
            }
        });
    // Bank Information
    $('#bank').on('change',function(e) {
        var bank_id = $(this).val();
        $.ajax({
            url:'{{ route("received.bankInfo") }}',
            type:"get",
            data: {
                bank_id: bank_id
                },
            success:function (res) {
                res = $.parseJSON(res);
                $('#ac_no').html(res.bank);
            }
        })
    });

    // Bank Information
    $('#invoice_no').on('change',function(e) {
        var invoice_no = $(this).val();
        $('#discount').val('');
        $('#discountTk').val('');
        $('#net_amt').val('');

        $.ajax({
            url:'{{ route("received.salesInvInfo") }}',
            type:"get",
            data: {
                invoice_no: invoice_no
                },
            success:function (res) {
                res = $.parseJSON(res);
                var due = res.net_amt - res.payment; // see later
                $('#sales_amt').val(res.sales_amt);
                $('#get_net_amt').val(res.net_amt);
                $('#payment').val(res.payment);
                $('#due_amt').val(due);
                $('#net_amt').val(due);
                $('.type').val(res.type);
                if(res.type==1){
                    $("#invType").val('Cash')
                }else{
                    $("#invType").val('Credit')
                }
            }
        })
    });
});
</script>
@include('admin.include.toast')
@endpush
@endsection
