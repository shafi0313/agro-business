@extends('admin.layout.master')
@section('title', 'Product')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Factory</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Store</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('product.index')}}">Product</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Pack Size</h4>
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
                            <form action="{{ route('product.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="name">Category<span class="t_r">*</span></label>
                                        <select name="cat_id" class="form-control @error('name') is-invalid @enderror">
                                            <option selected disabled value>Select</option>
                                            @foreach ($productCats as $productCat)
                                                <option value="{{$productCat->id}}">{{$productCat->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('cat_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="name">Brand Name<span class="t_r">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Enter Brand Name" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="generic">Group Name<span class="t_r">*</span></label>
                                        <input type="text" name="generic" class="form-control @error('generic') is-invalid @enderror" value="{{old('materials')}}" placeholder="Enter Group Name" required>
                                        @error('generic')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 150px">Size</th>
                                                <th>Purchase</th>
                                                {{-- price name change --}}
                                                <th>Dealer Price</th>
                                                <th>Credit Price</th>
                                                <th>Cash Price</th>
                                                <th>MRP</th>
                                                <th style="width: 20px;text-align:center;">
                                                    <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td><select type="text" name="size[]" class="form-control form-control-sm"><option value="">Select</option>@foreach ($packSizes as $packSize)<option value="{{$packSize->size}}">{{$packSize->size}}</option>@endforeach</select></td>
                                                <td><input type="number" name="purchase[]" step="any" id="purchase" class="form-control form-control-sm" /></td>
                                                <td><input type="number" name="cash[]" step="any" id="cash" class="form-control form-control-sm"/></td>
                                                <td><input type="number" name="credit[]" step="any" id="credit" class="form-control form-control-sm"/></td>
                                                <td><input type="number" name="trade_price[]" step="any" id="trade_price" class="form-control form-control-sm"/></td>
                                                <td><input type="number" name="mrp[]" id="mrp" step="any" class="form-control form-control-sm"/></td>
                                                <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tbody id="showItem" class=""></tbody>
                                        </table>
                                    </div>
                                    {{-- <div class="form-group col-sm-12">
                                        <label for="origin">Origin<span class="t_r">*</span></label>
                                        <textarea class="form-control @error('origin') is-invalid @enderror" id="origin" name="origin" {{old('origin')}}></textarea>
                                        @error('origin')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group col-sm-12">
                                        <label for="indications">Main Indications<span class="t_r">*</span></label>
                                        <textarea class="form-control @error('indications') is-invalid @enderror" id="indications" name="indications" {{old('indications')}}></textarea>
                                        @error('indications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group col-sm-12">
                                        <label for="dosage">Dosage<span class="t_r">*</span></label>
                                        <textarea class="form-control @error('dosage') is-invalid @enderror" id="editor2" name="dosage" {{old('dosage')}}></textarea>
                                        @error('dosage')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group col-md-3">
                                        <label for="image" class="placeholder">Image<span class="t_r">*</span></label>
                                        <input id="image" name="image" type="file" class="form-control">
                                    </div>
                                </div>
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
@include('admin.pack_size.create')
@push('custom_scripts')

<script>

	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<tr id="remove_'+i+'" class="post_item">';
	            html +='    <td><select type="text" name="size[]" class="form-control form-control-sm"><option value="">Select</option>@foreach ($packSizes as $packSize)<option value="{{$packSize->size}}">{{$packSize->size}}</option>@endforeach</select></td>';
	            html +='	<td><input type="number" name="purchase[]" step="any" id="purchase_" class="form-control form-control-sm"/></td>';
	            html +='	<td><input type="number" name="cash[]" step="any" id="cash" class="form-control form-control-sm" /></td>';
	            html +='	<td><input type="number" name="credit[]" step="any" id="credit" class="form-control form-control-sm"/></td>';
	            html +='    <td><input type="number" name="trade_price[]" step="any" id="trade_price" class="form-control form-control-sm"/></td>';
	            html +='    <td><input type="number" name="mrp[]" step="any" id="mrp" class="form-control form-control-sm"/></td>';
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

<script src="{{ asset('backend/assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('indications')
</script>
@endpush
@endsection
