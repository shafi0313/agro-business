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
                                <div class="col-md-3">
                                    {{-- Company Info --}}
                                    @include('admin.company_info.address_for_page')
                                </div>
                                <div class="col text-center">
                                    <p style="font-size: 30px; font-weight: bold;margin-top:-10px">Sales of Cash Invoice</p>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-size: 18px;font-weight:600;background:green;color:white;margin:0;padding:0px 5px">Bill To</p>
                                    <p style="font-size: 15px">
                                        <span>{{ $customer->business_name }}, {{ $customer->name }}</span><br>
                                        <span>{{ $customer->address }}</span>
                                    </p>
                                </div>
                            </div>


                        <form action="{{ route('salesInvoiceCash.update') }}" method="post" onsubmit="return validate()">
                         @csrf
                            <input type="hidden" name="customer_id" value="{{$customer->id}}">
    {{--__________________________________Invoice Info Start__________________________________--}}
                        <style>
                            .col {
                                padding: 0px 0px !important;
                            }
                        </style>
                            <div class="row justify-content-between">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Invoice No:</label>
                                        <input type="number" readonly name="" value="{{ $invoices->first()->invoice_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Challan No:</label>
                                        <input type="number" readonly name="cancel_challan_no" value="{{ $invoices->first()->challan_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="invoice_date" class="form-label form-label-sm">Invoice Date  <span class="t_r">*</span></label>
                                        <input type="date" name="" value="{{ $invoices->first()->invoice_date }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="" class="form-label form-label-sm">Delivery Date <span class="t_r">*</span></label>
                                        <input type="date" name="" value="{{ $ledgerUpdate->delivery_date }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm text-danger">Payment Date <span class="t_r">*</span></label>
                                        <input type="date" name="" value="{{ $ledgerUpdate->payment_date }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
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

                                {{-- <div class="col">
                                    <div class="form-group">
                                        <label for="">Officer Id <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="">
                                            <option selected value disabled>Select</option>
                                            @foreach ($userId as $id)
                                                <option value="{{$id->first()->user_id}}">{{$id->first()->user_id}}{{ $id->first()->userForSR->tmm_so_id }}=>{{ $id->first()->userForSR->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Inv Type <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="inv_type" id="">
                                            <option selected value disabled>Select</option>
                                            <option value="1" >Cash</option>
                                            <option value="2" >Credit</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
    {{--__________________________________Invoice Info End__________________________________--}}
                            <hr class="bg-warning">
                            <div class="row mx-auto">
                                <table id="editData" class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Brand Name <span class="t_r">*</span></th>
                                            <th>Group Name <span class="t_r">*</span></th>
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
                                    @foreach ($invoices as $invoice)
                                    <tr>
                                        <input type="hidden" name="invoice_id[]" value="{{$invoice->id}}">
                                        <input type="hidden" name="challan_no" value="{{$invoice->challan_no}}">
                                        <input type="hidden" name="product_id[]" value="{{$invoice->product->id}}">
                                        <input type="hidden" name="size[]" value="{{$invoice->packSize->id}}">
                                        <input type="hidden" name="cancel_led_id" value="{{ $ledgerUpdate->id }}">

                                        <td><input type="text" value="{{$invoice->product->name}}" data-type="product" class="form-control form-control-sm" style="width:200px" readonly /></td>
                                        <td><input type="text" value="{{$invoice->product->generic}}" class="form-control form-control-sm" style="min-width:200px" readonly /></td>
                                        <td><input type="text" value="{{$invoice->packSize->size}}" class="form-control form-control-sm" style="width:100px" readonly></td>
                                        <td><input type="number" name="quantity[]" value="{{$invoice->quantity}}" class="form-control form-control-sm qty"/></td>
                                        <td><input type="number" name="rate_per_qty[]" value="{{$invoice->packSize->cash}}" data-type="price" class="form-control form-control-sm qty"/></td>
                                        <td><input type="number" name="bonus[]" value="{{$invoice->bonus}}" class="form-control form-control-sm"/></td>
                                        <td><input type="number" name="pro_dis[]" value="{{$invoice->pro_dis}}" class="form-control form-control-sm"/></td>
                                        <td><input type="number" name="amt[]" value="{{$invoice->amt}}" step="any" class="form-control form-control-sm"></td>
                                        {{-- <td><a href="{{ route('salesInvoiceCash.delete', [$invoice->id,$invoice->challan_no]) }}" class="btn btn-danger btn-sm">Update</a></td> --}}
                                        <td><a href="{{ route('salesInvoiceCash.delete', [$invoice->id,$invoice->challan_no]) }}" class="btn btn-danger btn-sm">x</a></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                    </tr>

                                </table>
                            </div>

                            <input type="hidden" name="customer_id" value="{{$customer->id}}">
                            <input type="hidden" name="invoice_date" value="{{ $invoices->first()->invoice_date }}">
                            <input type="hidden" name="challan_no" value="{{ $invoices->first()->challan_no }}">
                            <input type="hidden" name="invoice_no" value="{{ $invoices->first()->invoice_no }}">
                            <input type="hidden" name="payment_date" value="{{ $ledgerUpdate->payment_date }}">

                            <div class="row justify-content-between">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Invoice No:</label>
                                        <input type="number" readonly name="invoice_no" value="{{ $invoice_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm">Challan No:</label>
                                        <input type="number" readonly name="challan_no" value="{{ $challan_no }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="invoice_date" class="form-label form-label-sm">Invoice Date <span class="t_r">*</span></label>
                                        <input type="date" name="invoice_date" value="{{ $invoices->first()->invoice_date }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ">
                                        <label for="" class="form-label form-label-sm">Delivery Date <span class="t_r">*</span></label>
                                        <input type="date" name="delivery_date" value="{{ $ledgerUpdate->delivery_date }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="" class="form-label form-label-sm text-danger">Payment Date <span class="t_r">*</span></label>
                                        <input type="date" name="payment_date" value="{{ $ledgerUpdate->payment_date }}" class="form-control form-control-sm" required>
                                    </div>
                                </div>
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
                                            <option value="1" >Cash</option>
                                            <option value="3" >Credit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr class="bg-warning">
    {{--__________________________________Product Input Start__________________________________--}}
                            <div class="row mx-auto">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Brand Name <span class="t_r">*</span></th>
                                            <th>Group Name <span class="t_r">*</span></th>
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
                                        <input type="hidden"    id="product_id"  class="autocomplete_txt" />
                                        <td><input type="text"  id="product_name" data-type="product" class="form-control form-control-sm autocomplete_txt" style="width:200px" placeholder="" /></td>
                                        <td><input type="text"  id="group_name"  class="form-control form-control-sm autocomplete_txt" style="min-width:200px" /></td>
                                        <td><select id="sizee"  class="form-control form-control-sm" style="width:100px" ></select></td>
                                        <td><span id="msg"    style="color: red"></span><input type="number" id="qty" class="form-control form-control-sm qty" placeholder="Quantity" /></td>
                                        <td><input type="number" id="price"  data-type="price" class="form-control form-control-sm qty" placeholder="Rate" /></td>
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
                            <table class="table table-responsive table-bordered table-hover table-sm product_table ">
                                <thead class="text-center" style="font-size: 15px;">
                                    <tr>
                                        <th width="4%">SN</th>
                                        <th width="%">Brand Name:</th>
                                        <th width="%">Group Name:</th>
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
                                    @isset($customer->customerInfo->credit_limit)
                                    <input type="hidden" id="credit_limit" value="{{ $customer->customerInfo->credit_limit }}">
                                    @else
                                    <input type="hidden" id="credit_limit" value="-1">
                                    @endisset

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
                            <div class="form-check">
                                <label class="form-check-label" >
                                    <input class="form-check-input" type="checkbox" id="cancel_note">
                                    <span class="form-check-sign" style="font-size: 16px">Cancel Note</span>
                                </label>
                            </div>
                            <div class="col-md-12" id="cancel_note_text" style="display: none">
                                <div class="form-group ">
                                    {{-- <label for="" class="form-label form-label-sm">Note</label> --}}
                                    <textarea name="cancel_note" class="form-control"   style="width: 100%;"></textarea>
                                </div>
                            </div>
    {{--__________________________________Product Show End__________________________________--}}
                            <hr class="bg-warning">
    {{--__________________________________ Product Input Start__________________________________--}}
                            <div class="form-check">
                                <label class="form-check-label" >
                                    <input class="form-check-input" type="checkbox" id="due" name="due" value="1">
                                    <span class="form-check-sign" style="font-size: 16px">Due Invoice</span>
                                </label>
                            </div>
                            <div id="due_text" style="display: none">
                                <table class="table table-bordered table-responsive">
                                    <tr>
                                        <th>Invoice No</th>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Sales Amount</th>
                                        <th>Payment</th>
                                        <th>Due</th>
                                        <th style="width: 20px;text-align:center;">
                                            <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                        </th>
                                    </tr>

                                    <tr>
                                        {{-- <td><select name="inv_no[]" id="inv_no_1" onchange="return inv_no(1)" class="form-control form-control-sm" style="width:100px" ><option>Select</option>@foreach ($ledger as $item) <option value="{{$item->id}}">{{$item->invoice_no}} </option>@endforeach</select></td> --}}
                                        <td><input type="text" name="inv_no[]" id="inv_no"  class="form-control form-control-sm" autocomplete="off"/>
                                            <div class="invv" id="invv"></div>
                                        </td>
                                        <td class="text-center"><i id="search_btn" class="fas fa-search" style="cursor: pointer"></i></td>
                                        <td ><input type="date"    id="inv_date" data-type="product" class="form-control form-control-sm autocomplete_txt" readonly/></td>
                                        <td><input type="number"   id="inv_amt"  class="form-control form-control-sm" readonly/></td>
                                        <td><input type="number"   id="inv_payment" class="form-control form-control-sm" /></td>
                                        <td><input type="number"   id="inv_total"          value="0"   class="form-control form-control-sm" readonly/></td>
                                        <td><button class="btn btn-success btn-sm add_due" type="button">Add</button></td>
                                    </tr>
                                </table>
    {{--__________________________________ Product Input End__________________________________--}}

    {{--__________________________________Due Invoice Show Start__________________________________--}}
                                <table class="table table-responsive table-bordered due_table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Invoice No</th>
                                            <th>Date</th>
                                            <th>Sales Amount</th>
                                            <th>Payment</th>
                                            <th>Due</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot >
                                        <tr>
                                            <th colspan="5" class="text-right">Total:</th>
                                            <th class="text-right due_sub_total">0.00 </th>
                                            <th><input type="hidden" name="due_total_amount" id="due_total_amount"></th>
                                        </tr>

                                    </tfoot>
                                </table>
    {{--__________________________________Due Invoice Show End__________________________________--}}




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
    function validate() {
        $("#btn_submit").attr('disabled', 'disabled');
    }

    $(document).ready(function(){
        $('.add_porduct').on('click', function() {
            var product_name    = $('#product_name').val();
            var product_id      = $('#product_id').val();
            var group_name      = $('#group_name').val();
            var size_text       = $('#size_text').val();
            var size_id         = $('#sizee').val();
            var quantity        = $('#qty').val();
            var rate_per_qty    = $('#price').val();
            var bonus           = $('#bonus').val();
            var pro_dis           = $('#pro_dis').val();
            var checkStock = $('#msg').text()
            // Validation
            if (product_name == '') {
                toast('warning', 'Please select brand name');
                $('#product_name').focus();
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

            var proDiscount = Number((quantity*rate_per_qty)*pro_dis/100);

            var totalamount =  quantity*rate_per_qty - proDiscount;
            var html = '<tr>';
            html += '<tr class="trData"><td class="serial text-center"></td><td>' + product_name + '</td><td>' + group_name + '</td><td class="text-center">'+ size_text +'</td><td class="text-center">' + quantity + '</td><td class="text-right">' + parseFloat(rate_per_qty).toFixed(2) + '</td><td class="text-center">'+bonus+'</td><td class="text-center">'+pro_dis+'</td><td class="text-right">' + parseFloat(totalamount).toFixed(2) + '</td><td align="center">';
            html += '<input type="hidden" name="product_id[]" value="' + product_id + '" />';
            html += '<input type="hidden" name="size[]" value="' + size_id + '" />';
            html += '<input type="hidden" name="quantity[]" value="' + quantity + '" />';
            html += '<input type="hidden" name="rate_per_qty[]" value="' + rate_per_qty + '" />';
            html += '<input type="hidden" name="bonus[]" value="' + bonus + '" />';
            html += '<input type="hidden" name="pro_dis[]" value="' + pro_dis + '" />';
            html += '<input type="hidden" name="amt[]" value="' + totalamount + '" />';
            html += '<a class="product_delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
            toast('success','Product Added');

            // Value reset
            $('.product_table tbody').append(html);
            $('#product_name').val('');
            $('#group_name').val('');
            $('#sizee').val('');
            $('#size_text').val('');
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
            var editsubtotal = $('.editsubtotal').val()
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
            })
        });

        // Product Size
        $('#product_name').on('change',function(e) {
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

        $('.qty').on('keyup',function(e) {
            var product_id = $('#product_id').val();
            var size_id = Number($('#sizee').val());
            var qty = Number($('#qty').val());
            var price = $('#price').val();
            var discount = $('#discount').val();
            var total = $('#totalamounval').val();
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

        // Discount
        $('#discountAmt').keyup(function() {
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
            var inv_type = Number($('#inv_type').val())
            var credit_limit = Number($('#credit_limit').val())
            var due_amt = $('#due_amt').val()
            var net_amt = $('#net_amt').val()
            var total = Number(sum) + Number(due_amt);

            if((credit_limit > 0) && (total > credit_limit) && (inv_type==3)){
                $('#credit_limit_m').html(credit_limit - total + ' Credit limit over');
            }else{
                $('#credit_limit_m').html('')
            }

            $('#net_amt').val(Math.round(sum));
            $('#discountTk').val(sumTk);
        });

        $('#discountTk').keyup(function() {
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
            var inv_type = Number($('#inv_type').val())
            var credit_limit = Number($('#credit_limit').val())
            var due_amt = $('#due_amt').val()
            var net_amt = $('#net_amt').val()
            var total = Number(sum) + Number(due_amt);
            if((credit_limit > 0) && (total > credit_limit) && (inv_type==3)){
                $('#credit_limit_m').html(credit_limit - total + ' Credit limit over');
                alert('fuck')
            }else{
                $('#credit_limit_m').html('')
            }

            $('#net_amt').val(Math.round(sum));
            $('#discountAmt').val(sumTk.toFixed(2));
        });

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

<script>
    $(document).ready(function(){
        $("#due").click(function(){
            $("#due_text").slideToggle();
        });

        $("#note").click(function(){
            $("#note_text").slideToggle();
        });

        $("#cancel_note").click(function(){
            $("#cancel_note_text").slideToggle();
        });


        $('#inv_no').keyup(function(e) {
            var inv_no = $('#inv_no').val();
            if(inv_no != ''){
                $.ajax({
                    url:'{{ route("salesInvoice.due") }}',
                    method: 'get',
                    data: {inv_no: inv_no},
                    success: function(data){
                        $("#invv").fadeIn("fast").html(data)
                    }
                })
            }else{
                $("#invv").fadeOut("fast")
            }
        });

        $(document).on('click','#invv li', function(){
            $('#inv_no').val($(this).text());
            $('#invv').fadeOut();
            $('#search_btn').on('click', function(e){
                e.preventDefault();
                var inv = $('#inv_no').val();
                $.ajax({
                    url:'{{ route("dueAmtInvoice") }}',
                    method: 'get',
                    data: {inv: inv},
                    success: function(data){
                        data = $.parseJSON(data);
                        $('#inv_date').val(data.invoice_date);
                        $('#inv_amt').val(data.sales_amt);
                    }
                })
            })
        });

        $('.add_due').on('click', function() {
            var inv_no  = $('#inv_no').val();
            var inv_date  = $('#inv_date').val();
            var inv_amt  = $('#inv_amt').val();
            var inv_payment = $('#inv_payment').val();
            var inv_total = $('#inv_total').val();

            if (inv_payment == '') {
                toast('warning', 'Please enter payment');
                $('#job_title').focus();
                return false;
            }

            // var totalamount =  quantity*rate_per_qty;
            var html = '<tr>';
            html += '<tr><td class="text-center due_serial"></td><td>' + inv_no + '</td><td>' + inv_date + '</td><td class="text-center">'+ inv_amt +'</td><td class="text-center">' + inv_payment + '</td><td class="text-right">' + parseFloat(inv_total).toFixed(2) + '</td><td align="center">';
            html += '<input type="hidden" name="inv_no[]" value="' + inv_no + '" />';
            html += '<input type="hidden" name="inv_date[]" value="' + inv_date + '" />';
            html += '<input type="hidden" name="inv_amt[]" value="' + inv_amt + '" />';
            html += '<input type="hidden" name="inv_payment[]" value="' + inv_payment + '" />';
            html += '<input type="hidden" name="inv_total[]" value="' + inv_total + '" />';
            html += '<a class="due_delete" href="#"><i class="fas fa-trash"></i></a></td></tr>';
            toast('success','Added');

            // Value reset
            $('.due_table tbody').append(html);
            $('#inv_no').val('');
            $('#inv_date').val('');
            $('#inv_amt').val('');
            $('#inv_payment').val('');
            $('#inv_total').val('');
            dueSerial();
        });

        $('#inv_payment').on('keyup', function(){
            var summ = 0;
            var inv_amtt = $('#inv_amt').val();
            var inv_paymentt = $('#inv_payment').val();
            $('#inv_total').each(function() {
                summ = Number(inv_amtt) - Number(inv_paymentt);
            });
            $('#inv_total').val(summ);
        })


        // Delete
        $('.due_table').on('click', '.due_delete', function(e) {
            var element = $(this).parents('tr');
            element.remove();
            toast('warning','item removed!');
            e.preventDefault();
            dueSerial();
        });

        // Subtotal
        function dueSerial() {
            var j = 1;
            var dueSubTotal = 0;
            $('.due_serial').each(function(key, element) {
                $(element).html(j);
                var dueTotal = $(element).parents('tr').find('input[name="inv_total[]"]').val();
                dueSubTotal += + parseFloat(dueTotal);
                j++;
            });

            $('.due_sub_total').html(dueSubTotal.toFixed(2));
            $('#due_total_amount').val(dueSubTotal);
        };
    });
</script>

<script>
    function btnClick() {
        var checkLimit = $('#credit_limit_m').text()
        var discountAmt = Number($("#discountAmt").val())
        var net_amt = Number($("#net_amt").val())
        if(checkLimit !=''){
            alert('Credit Limit Is Over, Please Increase Your Credit Limit Or Pay Due Amount')
            return false;
        }

        if((discountAmt > 100 || net_amt < 0)){
            alert('Check Discount Amount')
            return false;
        }
    }
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
