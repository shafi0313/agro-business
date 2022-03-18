@extends('admin.layout.master')
@section('title', 'Bulk')
@section('content')
@php $p='factory'; $sm="balkName"; $ssm = 'bulkShow' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('raw-material.index')}}">Bulk</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Add</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        {{-- <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Patient</h4>
                            </div>
                        </div> --}}
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
                            <form action="{{ route('raw-material.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="generic">Group Name <span class="t_r">*</span></label>
                                        <input type="text" name="generic" class="form-control @error('generic') is-invalid @enderror" value="{{old('materials')}}" placeholder="Enter Group Name" required>
                                        @error('generic')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Size</th>
                                                {{-- <th>Net Weight</th>
                                                <th>Per Unit</th> --}}
                                                <th>Purchase</th>
                                                <th>Trade Price</th>
                                                <th style="width: 20px;text-align:center;">
                                                    <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td><select type="text" name="size[]" id="size_1" class="form-control form-control-sm" placeholder="Size"><option value="">Select</option>@foreach ($packSizes as $packSize)<option value="{{$packSize->size}}">{{$packSize->size}}</option>@endforeach</select></td>
                                                {{-- <td><input type="number" name="net_weight[]" id="purchase_1" class="form-control form-control-sm" placeholder="Purchase"/></td>
                                                <td><input type="number" name="per_umit[]" id="purchase_1" class="form-control form-control-sm" placeholder="Purchase"/></td> --}}
                                                <td><input type="number" name="purchase[]" id="purchase_1" class="form-control form-control-sm" placeholder="Purchase"/></td>
                                                <td><input type="number" name="trade_price[]" id="trade_price_1" class="form-control form-control-sm" placeholder="Trade Price"/></td>
                                                <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                                            </tr>
                                            <tbody id="showItem" class=""></tbody>
                                        </table>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="indications">Main Indications</label>
                                        <textarea class="form-control @error('indications') is-invalid @enderror" id="editor" name="indications" {{old('indications')}} rows="30"></textarea>
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

@push('custom_scripts')
<script>
	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<tr id="remove_'+i+'" class="post_item">';
	            html +='    <td><select type="text" name="size[]" id="size_'+i+'" class="form-control form-control-sm" placeholder="Size"><option value="">Select</option>@foreach ($packSizes as $packSize)<option value="{{$packSize->size}}">{{$packSize->size}}</option>@endforeach</select></td>';
	            html +='	<td><input type="number" name="purchase[]" id="purchase_'+i+'" class="form-control form-control-sm" placeholder="Purchase"/></td>';
	            html +='    <td><input type="number" name="trade_price[]" id="trade_price_'+i+'" class="form-control form-control-sm" placeholder="Trade Price"/></td>';
	            // html +='    <td><input type="number" name="mrp[]" id="mrp_'+i+'" class="form-control form-control-sm" placeholder="MRP"/></td>';
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

<script>
    ClassicEditor
    .create( document.querySelector('#editor'), {
        removePlugins: [  ],
        toolbar: ['Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' , 'Link'],
    } )
    .catch( error => {
        console.log( error );
    });


</script>
@endpush
@endsection
