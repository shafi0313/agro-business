@extends('admin.layout.master')
@section('title', 'Supplier')
@section('content')
@php $p='business'; $sm="supplier"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('supplier.index')}}">Supplier</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Add Supplier</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Supplier</h4>
                            </div>
                        </div>
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
                            <form action="{{ route('supplier.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="business_name">Supplier Name <span class="t_r">*</span></label>
                                        <input type="text" name="business_name" class="form-control @error('business_name') is-invalid @enderror" value="{{old('business_name')}}" placeholder="Supplier Name" required>
                                        @error('business_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="name">Proprietor <span class="t_r">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Proprietor" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="tmm_so_id">Supplier Id</label>
                                        <input type="text" name="tmm_so_id" class="form-control @error('tmm_so_id') is-invalid @enderror" value="{{old('tmm_so_id')}}" placeholder="Enter Supplier Id">
                                        @error('tmm_so_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="phone">Phone<span class="t_r">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" placeholder="Enter Phone" required>
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="email">Email <span class="t_r">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="Enter Email" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-sm-6">
                                        <label for="credit_limit">Credit Limit <span class="t_r">*</span></label>
                                        <input type="number" name="credit_limit" class="form-control @error('credit_limit') is-invalid @enderror" value="{{old('credit_limit')}}" placeholder="Enter Credit Limit" required>
                                        @error('credit_limit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                </div>
                                {{-- <hr class="bg-warning"> --}}
                                {{-- _________________________Nominee Info_________________________ --}}
                                {{-- <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nominee_name">Nominee Name</label>
                                        <input type="text" name="nominee_name" class="form-control @error('nominee_name') is-invalid @enderror" value="{{old('nominee_name')}}" placeholder="Enter Nominee Name">
                                        @error('nominee_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nominee_phone">Nominee Phone</label>
                                        <input type="number" name="nominee_phone" class="form-control @error('nominee_phone') is-invalid @enderror" value="{{old('nominee_phone')}}" placeholder="Enter Nominee Phone">
                                        @error('nominee_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="relation">Relation</label>
                                        <input type="text" name="relation" class="form-control @error('relation') is-invalid @enderror" value="{{old('relation')}}" placeholder="Enter Relation">
                                        @error('relation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <hr class="bg-warning">
                                <div class="row">
                                    {{-- <div class="form-group col-sm-6">
                                        <label for="shop_address">Shop Address<span class="t_r">*</span></label>
                                        <textarea name="shop_address" id="" cols="15" rows="6" class="form-control @error('shop_address') is-invalid @enderror" value="{{old('shop_address')}}" placeholder="Enter Shop Address" required></textarea>
                                        @error('shop_address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group col-sm-6">
                                        <label for="address">Address <span class="t_r">*</span></label>
                                        <textarea name="address" id="" cols="15" rows="6" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Enter Mailing Address" required></textarea>
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="bg-warning">
                                    {{-- Calculation --}}

                                    {{-- <div id="cal" style="display:none"> --}}
                                        <div class="form-check">
                                            <label class="form-check-label" >
                                                <input class="form-check-input" type="checkbox" value="1" name="preCal" id="preCal">
                                                <span class="form-check-sign">Previous Calculation</span>
                                            </label>
                                        </div>

                                        {{-- <div class="col-md-12"><h3 style="margin-left: 8px; font-weight:bold; display:none">Previous Calculation</h3></div> --}}
                                        <div id="cal" class="row col-md-12" style="display: none">
                                            <div class="form-group col-sm-6">
                                                <label for="payment_notetep">Note<span class="t_r">*</span></label>
                                                <input type="text" name="payment_note" class="form-control @error('payment_note') is-invalid @enderror" value="{{old('payment_note')}}" placeholder="Enter Note">
                                                @error('payment_note')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label for="">Purchase<span class="t_r">*</span></label>
                                                <input type="text" class="form-control num" id="pr" value="0">
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label for="">Payment<span class="t_r">*</span></label>
                                                <input type="text" class="form-control num" id="py" value="0">
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label for="total">Total<span class="t_r">*</span></label>
                                                <input type="text" name="total" class="form-control num" id="total" readonly>
                                            </div>
                                        </div>
                                    {{-- </div> --}}

                                    <hr class="bg-warning">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="image" class="placeholder">Photo</label>
                                            <input id="image" name="image" type="file" class="form-control">
                                        </div>
                                    </div>


                                    {{-- File --}}
                                    <div class="row col-md-12"><h3 style="margin-left: 8px; font-weight:bold">Documents</h3></div>
                                    <table class="table table-bordered">
                                        {{-- <h2>Documents</h2> --}}
                                        <tr>
                                            <th style="width:250px">File</th>
                                            <th>Note</th>
                                            <th style="width: 20px;text-align:center;">
                                                <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td><input type="file" name="name[]" multiple id="medicine_name_1" class="form-control form-control-sm" style="width:250px"/></td>
                                            <td><input type="text" name="note[]"          id="qty_1"           class="form-control form-control-sm" placeholder="Note"/></td>
                                            <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                                        </tr>
                                        <tbody id="showItem"></tbody>
                                    </table>

                                <div align="center" class="mr-auto card-action">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
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
    $('#preCal').click(function(){
        $('#cal').slideToggle()
    })

    $('.num').keyup(function() {
        var sum = 0;
        var pr = $("#pr").val()
        var py = $("#py").val()

        $('.num').each(function() {
            sum = pr - py;
        });
        $('#total').val(sum);
    });

</script>

<script>
	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<tr id="remove_'+i+'" class="post_item">';
	            html +='    <td><input type="file" name="name[]" multiple id="medicine_name_1" class="form-control form-control-sm" style="width:200px"/></td>';
	            html +='	<td><input type="text" name="note[]"          id="qty_1"           class="form-control form-control-sm" placeholder="Note"/></td>';
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

