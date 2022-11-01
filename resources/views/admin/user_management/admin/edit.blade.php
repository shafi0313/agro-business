@extends('admin.layout.master')
@section('title', 'Author')
@section('content')
@php $p='admin'; $sm='adminIndex'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('admin-user.index')}}">Author</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Edit Author</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Author</h4>
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
                            <form action="{{ route('admin-user.update', $adminUsers->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="business_name">Permission <span class="t_r">*</span></label>
                                        <select name="permission" id="" class="form-control @error('permission') is-invalid @enderror">
                                            <option selected >Select</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($role->id==$modelHasRole)>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('permission')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="name">Author Name <span class="t_r">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$adminUsers->name}}" placeholder="Enter Author Name" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="tmm_so_id">Author Id</label>
                                        <input type="text" name="tmm_so_id" class="form-control @error('tmm_so_id') is-invalid @enderror" value="{{$adminUsers->tmm_so_id}}" placeholder="Enter Author Id">
                                        @error('tmm_so_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="phone">Phone<span class="t_r">*</span></label>
                                        <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{$adminUsers->phone}}" placeholder="Enter Phone" required>
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="email">Email <span class="t_r">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$adminUsers->email}}" placeholder="Enter Email" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label>Password <span class="t_r">*</span></label>
                                        <input type="password" class="form-control"  autocomplete="off" name="password" placeholder="password" autocomplete="new-password"
                                        onblur="this.setAttribute('readonly', 'readonly');"  onfocus="this.removeAttribute('readonly');" readonly>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-sm-6">
                                        <label>Password <span class="t_r">*</span></label>
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{$adminUsers->password}}" required>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label>Confrim Password <span class="t_r">*</span></label>
                                        <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{$adminUsers->password}}" required>
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                </div>
                                <hr class="bg-warning">
                                {{-- _________________________Nominee Info_________________________ --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="nominee_name">Nominee Name</label>
                                        <input type="text" name="nominee_name" class="form-control @error('nominee_name') is-invalid @enderror" value="{{$adminUsers->nominee_name}}" placeholder="Enter Nominee Name">
                                        @error('nominee_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="nominee_phone">Nominee Phone</label>
                                        <input type="number" name="nominee_phone" class="form-control @error('nominee_phone') is-invalid @enderror" value="{{$adminUsers->nominee_phone}}" placeholder="Enter Nominee Phone">
                                        @error('nominee_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="relation">Relation</label>
                                        <input type="text" name="relation" class="form-control @error('relation') is-invalid @enderror" value="{{$adminUsers->relation}}" placeholder="Enter Relation">
                                        @error('relation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="bg-warning">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="address">Address <span class="t_r">*</span></label>
                                        <textarea name="address" id="" cols="15" rows="6" class="form-control @error('address') is-invalid @enderror"  placeholder="Enter Mailing Address" required>{{$adminUsers->address}}</textarea>
                                        {{-- <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Enter Address" required> --}}
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
                                            <img src="{{asset('uploads/images/product/'.$adminUsers->profile_photo_path)}}" alt="">
                                            <input id="image" name="oldImage" type="hidden" value="{{$adminUsers->profile_photo_path}}" class="form-control">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="image" class="placeholder">Photo</label>
                                            <input id="image" name="image" type="file" class="form-control">
                                        </div>
                                    </div>
                        </div>
                    {{-- Page Content End --}}
                    </div>



                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <!-- Button trigger modal -->
                                        <div align="right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Supplier" style="width: 200px"> Add New File</button>
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
                                                    <a href="{{route('admin.userFileDestroy', $userFile->id)}}"  class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>
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
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Supplier" tabindex="-1" role="dialog" aria-labelledby="SupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="SupplierLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.userFileStore')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$adminUsers->id }}" >
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
    @include('admin.layout.footer')
  </div>
@push('custom_scripts')
<script>
    $('#preCal').click(function(){
        $('#cal').slideToggle()
    })
</script>
@endpush
@endsection

