@extends('admin.layout.master')
@section('title', 'Label Send To Repack Unit')
@section('content')
@php $p='factory'; $sm='labelSentR'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('label-send-to-repack-unit.index')}}">Label Send To Repack Unit</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Send</li>
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
                                    <p style="font-size: 30px; font-weight: bold;margin-top:-10px">Label Send To Repack Unit</p>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-size: 18px;font-weight:600;background:green;color:white;margin:0;padding:0px 5px">Bill To</p>
                                    <p style="font-size: 15px">
                                        <span>{{ $supplier->name }}</span><br>
                                        <span>{{ $supplier->address }}</span>
                                    </p>
                                </div>
                            </div>

                        <form action="{{ route('label-send-to-repack-unit.store') }}" method="post">
                         @csrf
                            <input type="hidden" name="supplier_id" value="{{$supplier->id}}">
                            <div class="row " >
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""   class="form-label form-label-sm">Challan No<span class="t_r">*</span></label>
                                        <input type="number" name="challan_no" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{-- <div class="form-group">
                                        <label for=""   class="form-label form-label-sm">Invoice No </label>
                                        <input type="number" name="invoice_no" class="form-control form-control-sm">
                                    </div> --}}
                                </div>
                                {{-- <div class="col-md-3"></div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for=""   class="form-label form-label-sm">Date <span class="t_r">*</span></label>
                                        <input type="date" name="invoice_date" class="form-control form-control-sm" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">SK Id <span class="t_r">*</span></label>
                                        <select class="form-control form-control-sm" name="user_id" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($userId as $id)
                                                <option value="{{ $id->id }}">{{ $id->tmm_so_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Brand Name</th>
                                    <th>Pack Size</th>
                                    <th>Per kg/ltr</th>
                                    <th>Rate</th>
                                    <th>Net Weight</th>
                                    <th>Amount</th>
                                    <th>Total Piece</th>
                                    <th style="width: 20px;text-align:center;">
                                        <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                    </th>
                                </tr>

                                <tr>
                                    <input type="hidden"      name="weight[]"       id="weight_1"       onkeyup="return weight(1)"       data-type="weight"  class="form-control form-control-sm autocomplete_txt" />
                                    <input type="hidden"      name="product_id[]"   id="product_id_1"   onkeyup="return product_id(1)"   data-type="medicinesId"  class="form-control form-control-sm autocomplete_txt" />
                                    <td><input type="text"                          id="product_name_1" onkeyup="return product_name(1)" data-type="product" class="form-control form-control-sm autocomplete_txt" style="min-width:200px" required/></td>
                                    <td><select               name="size[]"         id="sizee_1"        onchange="return sizee(1)"       class="form-control form-control-sm" style="min-width:100px" required></select></td>
                                    <td><input type="number"  name="per_kg[]"       id="per_kg_1"                                        class="form-control form-control-sm" required/></td>
                                    <td><input type="number"  name="rate_per_qty[]" id="rate_per_qty_1"       step="any"                           class="form-control form-control-sm"/></td>
                                    <td><input type="number"  name="net_weight[]"   id="net_weight_1"    onkeyup="return net_weight(1)"  class="form-control form-control-sm"/></td>
                                    <td><input type="number"  name="amt[]"          id="subtotal_1"      step="any"                      class="form-control form-control-sm subtotal" value="0" readonly></td>
                                    <td><input type="number"  name="total_piece[]"  id="total_piece_1"   onkeyup="return total_piece(1)" class="form-control form-control-sm" value="0" readonly/></td>
                                    <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                                </tr>

                                <tbody id="showItem"></tbody>
                                <tfoot id="totalamount">
                                    <tr>
                                        <td style="text-align: right; font-size:16px; font-weight:bold" colspan="5">Total:</td>
                                        <td style="text-align: right; font-size:16px; font-weight:bold" colspan="2"><input type="text" id="totalamounval" name="total_amt" class="form-control form-control-sm" readonly></div></td>
                                    </tr>
                                </tfoot>
                            </table>

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

@push('custom_scripts')
<script>

    function sizee(id){
        $('#sizee_'+id).on('click',function(e) {
            var cat_id = $('#sizee_'+id).val();
            $.ajax({
                url:'{{ route("bulkSize") }}',
                type:"get",
                data: {
                    cat_id: cat_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    console.log(res.tradeWeight)
                    $('#weight_'+id).val(res.tradeWeight);
                }
            })
        });
    };

    function product_name(id){
        $('#product_name_'+id).on('change',function(e) {
            var size = $('#sizee_'+id).val();
            var cat_id = $('#product_id_'+id).val();
            $.ajax({
                url:'{{ route("productSizeCash") }}',
                type:"get",
                data: {
                    cat_id: cat_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    console.log(res.size)
                    $('#sizee_'+id).html(res.size);
                }
            })
        });
    };

    function net_weight(id)
	{
        var rate_per_qty = $('#rate_per_qty_'+id).val();
        var per_kg = $('#per_kg_'+id).val();
        var net_weight = $('#net_weight_'+id).val();
		var total_piece = Number(per_kg) * Number(net_weight);
		var amt = Number(rate_per_qty) * Number(net_weight);
        $('#total_piece_'+id).val(total_piece);
        $('#subtotal_'+id).val(amt);
		total_price();
    }

	/**call every keyup from any function*/
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
        if (type == 'medicinesId') autoType = 'id';
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
                $('#product_id_' + elementId).val(data.id);
                $('#product_name_' + elementId).val(data.name);
                // $('#price_' + elementId).val(data.trade_price);
            }
        });
    });

    /*Add Row Item*/
	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
                html +='<tr id="remove_'+i+'" class="post_item">';
                html +='    <input type="hidden"      name="weight[]"       id="weight_'+i+'"       onkeyup="return weight('+i+')"       data-type="weight"  class="form-control form-control-sm autocomplete_txt" />'
                html +='    <input type="hidden"      name="product_id[]"   id="product_id_'+i+'"   onkeyup="return product_id('+i+')"   data-type="medicinesId"  class="form-control form-control-sm autocomplete_txt" />'
                html +='    <td><input type="text"                          id="product_name_'+i+'" onkeyup="return product_name('+i+')" data-type="product" class="form-control form-control-sm autocomplete_txt" style="min-width:200px" required/></td>'
                html +='    <td><select               name="size[]"         id="sizee_'+i+'"        onchange="return sizee('+i+')"       class="form-control form-control-sm" style="min-width:100px" required></select></td>'
                html +='    <td><input type="number"  name="per_kg[]"       id="per_kg_'+i+'"                                        class="form-control form-control-sm" required/></td>'
                html +='    <td><input type="number"  name="rate_per_qty[]" id="rate_per_qty_'+i+'"           step="any"                       class="form-control form-control-sm"/></td>'
                html +='    <td><input type="number"  name="net_weight[]"   id="net_weight_'+i+'"    onkeyup="return net_weight('+i+')"  class="form-control form-control-sm"/></td>'
                html +='    <td><input type="number"  name="amt[]"          id="subtotal_'+i+'"      step="any"                      class="form-control form-control-sm subtotal" readonly></td>'
                html +='    <td><input type="number"  name="total_piece[]"  id="total_piece_'+i+'"   onkeyup="return total_piece('+i+')" class="form-control form-control-sm" readonly/></td>'
	            html +='	<td style="width: 20px"  class="col-md-2"><span class="btn btn-sm btn-danger" onclick="return remove('+i+')"><i class="fa fa-times" aria-hidden="true"></i></span></td>';
	            html +='</tr>';
	            $('#showItem').append(html);
			});
	});
	function remove(id)
	{
		$('#remove_'+id).remove();
		total_price();
    }
</script>


@endpush
@endsection
