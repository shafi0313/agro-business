@extends('admin.layout.master')
@section('title', 'Store')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Business Person/Factory/Store</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('company-store.index')}}">Store</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Edit</li>
                </ul>
            </div>
            <div class="row">
                {{-- <div class="col-md-4">
                    <div class="card card-profile card-secondary">
                        <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                            <div class="profile-picture">
                                <div class="avatar avatar-xl">
                                    <img src="{{ asset('images/users/'.$user->profile_photo_path) }}" alt="{{$user->name}}" class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                                <div class="name">{{$user->name}} </div>
                                <div class="job">{{ ($user->role==2)?'Customer':(($user->role==3)?'Supplier':'Factory') }}</div>
                                <div class="job">
                                    0{{$user->phone}} <br>
                                    {{$user->email}}<br>
                                    {{$user->business_name}}<br>
                                    {{$user->address}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Store</h4>
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
                            <form action="{{ route('company-store.update', $user->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="name">Customer Name<span class="t_r">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$user->name }}" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="business_name">Business Name<span class="t_r">*</span></label>
                                        <input type="text" name="business_name" class="form-control @error('business_name') is-invalid @enderror" value="{{$user->business_name }}" required>
                                        @error('business_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="tmm_so_id">Store Id<span class="t_r">*</span></label>
                                        <input type="text" name="tmm_so_id" class="form-control @error('tmm_so_id') is-invalid @enderror" value="{{$user->tmm_so_id}}">
                                        @error('tmm_so_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="phone">Phone<span class="t_r">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{$user->phone }}" required>
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-sm-6">
                                        <label for="email">Email<span class="t_r">*</span></label>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email }}" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group col-sm-12">
                                        <label for="address">Address<span class="t_r">*</span></label>
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{$user->address }}" placeholder="Enter Address" required>
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <!-- Button trigger modal -->
                                <div align="right">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#customer" style="width: 200px"> Add New File</button>
                                </div>
                                <tr>
                                    <th>Old File</th>
                                    <th>Upload New File</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($userFiles as $userFile)
                                <tr>
                                    @php
                                        $ex = pathinfo($userFile->name);
                                        $exten = $ex['extension'];
                                    @endphp
                                    @if($exten=='jpg' || $exten=='jpeg' || $exten=='png')
                                    <td width="170px"><img  src="{{asset('files/user_file/'.$userFile->name)}}" alt="" height="100px" width="150px"></td>
                                    @else
                                    <td>Its not a image</td>
                                    @endif
                                    <input type="hidden" name="id[]" value="{{$userFile->id}}">
                                    <input type="hidden" name="old_name[]" value="{{$userFile->name}}">
                                    <td style="width: 80px"><input type="file" multiple name="name[]"></td>
                                    <td><input type="text" name="note[]" value="{{$userFile->note}}" class="form-control"></td>
                                    <td style="width: 5px">
                                        <div class="form-button-action">
                                            <a href="{{asset('files/user_file/'.$userFile->name)}}" class="btn btn-link btn-info" download><i class="fas fa-download"></i></a>
                                            <a href="{{route('customer.userFileDestroy', $userFile->id)}}"  class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div align="center" class="mr-auto card-action">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="customer" tabindex="-1" role="dialog" aria-labelledby="customerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="customerLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('customer.userFileStore')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id }}" >
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:300px">File</th>
                        <th>Note</th>
                        <th style="width: 20px;text-align:center;">
                            <button class="btn btn-info btn-sm" style="padding: 4px 13px"><i class="fas fa-mouse"></i></button>
                        </th>
                    </tr>
                    <tr>
                        <td><input type="file" name="name[]" multiple id="medicine_name_1" class="form-control form-control-sm" style="width:200px"/></td>
                        <td><input type="text" name="note[]"          id="qty_1"           class="form-control form-control-sm" placeholder="Note"/></td>
                        <td style="width: 20px"><span class="btn btn-sm btn-success addrow"><i class="fa fa-plus" aria-hidden="true"></i></span></td>
                    </tr>
                    <tbody id="showItem"></tbody>
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

