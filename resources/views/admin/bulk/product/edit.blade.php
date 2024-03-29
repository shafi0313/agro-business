@extends('admin.layout.master')
@section('title', 'Bulk Name')
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
                    <li class="nav-item"><a href="{{ route('raw-material.index')}}">Bulk Name</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Edit</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                  <a class="btn btn-primary btn-round ml-auto text-light" data-toggle="modal" data-target="#addSize" >
                                    <i class="fa fa-plus"></i>
                                    Add New Size
                                  </a>
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
                            <form action="{{ route('raw-material.update', $product->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="generic">Group Name <span class="t_r">*</span></label>
                                        <input type="text" name="generic" class="form-control @error('generic') is-invalid @enderror" value="{{ $product->generic }}">
                                        @error('generic')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-bordered mt-4">
                                            <tr>
                                                <th>Size</th>
                                                <th>Purchase</th>
                                                <th>Trade Price</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            @foreach ($packSizes as $packSize)
                                            <tr>
                                                <input type="hidden" name="id[]" value="{{$packSize->id}}">
                                                <td>
                                                    <select type="text" name="size[]" class="form-control form-control-sm" placeholder="Size" >
                                                        @foreach ($packSizess as $packSizes)
                                                            <option {{($packSize->size==$packSizes->size)?'selected':''}} value="{{$packSizes->size}}">{{$packSizes->size}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="purchase[]" id="purchase" value="{{$packSize->purchase}}" class="form-control form-control-sm" placeholder="Purchase"/></td>
                                                <td><input type="number" name="trade_price[]" id="trade_price" value="{{$packSize->trade_price}}" class="form-control form-control-sm" placeholder="Trade Price"/></td>
                                                <td class="text-center">
                                                    <div class="form-button-action">
                                                        <a href="{{route('rawMaterial.deletePackSize',$packSize->id)}}" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-times"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="indications">Main Indications</label>
                                        <textarea class="form-control @error('indications') is-invalid @enderror" id="editor" name="indications"></textarea>
                                        <script>document.getElementById("editor").value = "{!! $product->indications !!}";</script>
                                        @error('indications')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
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
<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="addSize" tabindex="-1" role="dialog" aria-labelledby="addSizeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 16px" id="addSizeLabel">Add New Size & Price</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('rawMaterial.addSizePriceAdd') }}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id}}">
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Size</th>
                        <th>Purchase</th>
                        <th>Trade Price</th>
                        <th>MRP</th>
                        <th style="width: 20px;text-align:center;">
                            <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                        </th>
                    </tr>
                    <tr>
                        <td><select type="text" name="size[]" class="form-control form-control-sm" placeholder="Size"><option value="">Select</option>@foreach ($packSizess as $packSizes)<option value="{{$packSizes->size}}">{{$packSizes->size}}</option>@endforeach</select></td>
                        <td><input type="number" name="purchase[]" id="purchase" class="form-control form-control-sm" placeholder="Purchase" required/></td>
                        <td><input type="number" name="trade_price[]" id="trade_price" class="form-control form-control-sm" placeholder="Trade Price" required/></td>
                        <td><input type="number" name="mrp[]" id="mrp" class="form-control form-control-sm" placeholder="MRP" required/></td>
                        <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                    </tr>
                    <tbody id="showItem" class=""></tbody>
                </table>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@push('custom_scripts')
<script>
    /*Add Row Item*/
	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<tr id="remove_'+i+'" class="post_item">';
	            html +='    <td><select type="text" name="size[]" class="form-control form-control-sm" placeholder="Size"><option value="">Select</option>@foreach ($packSizess as $packSizes)<option value="{{$packSizes->size}}">{{$packSizes->size}}</option>@endforeach</select></td>';
	            html +='	<td><input type="number" name="purchase[]" id="purchase_" class="form-control form-control-sm" placeholder="Purchase" required/></td>';
	            html +='    <td><input type="number" name="trade_price[]" id="trade_price" class="form-control form-control-sm" placeholder="Trade Price" required/></td>';
	            html +='    <td><input type="number" name="mrp[]" id="mrp" class="form-control form-control-sm" placeholder="MRP" required/></td>';
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
    CKEDITOR.replace('editor')
</script>
@endpush

@endsection

