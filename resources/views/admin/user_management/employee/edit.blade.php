@extends('admin.layout.master')
@section('title', 'Employee')
@section('content')
@php $p='admin'; $sm='empIndex'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('admin-user.index')}}">Employee</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Add Employee</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Employee</h4>
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
                            <form action="{{ route('employee.update', $employee->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-check col-sm-3">
										<label>Login Permission <span class="t_r">*</span></label><br>
										<label class="form-radio-label" id="permissionYes">
											<input class="form-radio-input" type="radio" name="permission" value="1" {{($employee->is_ == '1') ? 'checked':''}}>
											<span class="form-radio-sign">Yes</span>
										</label>
										<label class="form-radio-label ml-3">
											<input class="form-radio-input" type="radio" name="permission" value="0" id="permissionNo" {{($employee->is_ == '0') ? 'checked':''}}>
											<span class="form-radio-sign">No</span>
										</label>
									</div>
                                    <input type="hidden" class="is" value="{{$employee->is_}}">

                                    <div class="form-group col-sm-6">
                                        <div style="display: none" id="permissionShow">
                                            <label for="business_name">Permission <span class="t_r">*</span></label>

                                            @if (isset($employee->permission->role_id))
                                                @php $role = $employee->permission->role_id @endphp
                                            @else
                                                @php $role = '' @endphp
                                            @endif
                                            <select name="is_" id="" class="form-control @error('is_') is-invalid @enderror" required>
                                                <option {{($role==1?'selected':'')}} value="1">Admin</option>
                                                <option {{($role==2?'selected':'')}} value="2">Editor</option>
                                                <option {{($role==3?'selected':'')}} value="3">Viewer</option>
                                            </select>
                                            @error('is_')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="designation">Designation <span class="t_r">(Select if you want to change the Designation)</span></label>
                                        <select name="employee_main_cat_id" id="designation" class="form-control @error('employee_main_cat_id') is-invalid @enderror">
                                            <option value="">Select</option>
                                            @foreach ($employeeMainCats as $employeeMainCat)
                                            <option value="{{$employeeMainCat->id}}">{{$employeeMainCat->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('employee_main_cat_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4 zsm_id" style="display: none">
                                        <label for="zsm_id">Zonal Sales Manager</label>
                                        <select name="zsm_id" class="form-control">
                                            <option>Select</option>
                                            @foreach ($empDesignations->where('employee_main_cat_id',11) as $empDesignation)
                                            @isset($empDesignation->user->name)
                                            <option value="{{$empDesignation->user_id}}" {{($empDesignation->id==$employee->employee_main_cat_id )?'selected':''}}>{{$empDesignation->user->name}}</option>
                                            @endisset

                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-4 ssm_id" style="display: none">
                                        <label for="sso_id">Senior Sales Manager </label>
                                        <select name="sso_id" class="form-control">
                                            <option selected >Select</option>
                                            @foreach ($empDesignations->where('employee_main_cat_id', 12) as $empDesignation)
                                            <option value="{{$empDesignation->user_id}}">{{$empDesignation->user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="job_loc">Job Location</label>
                                        <input type="text" name="job_loc" class="form-control @error('job_loc') is-invalid @enderror" value="{{$employee->employeeInfo->job_loc}}">
                                        @error('job_loc')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="tmm_so_id">Employee Id</label>
                                        <input type="text" name="tmm_so_id" class="form-control @error('tmm_so_id') is-invalid @enderror" value="{{$employee->tmm_so_id}}">
                                        @error('tmm_so_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="name">Employee Name <span class="t_r">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$employee->name}}">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="f_name">Father Name <span class="t_r">*</span></label>
                                        <input type="text" name="f_name" class="form-control @error('f_name') is-invalid @enderror" value="{{$employee->employeeInfo->f_name}}" required>
                                        @error('f_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="m_name">Mother Name <span class="t_r">*</span></label>
                                        <input type="text" name="m_name" class="form-control @error('m_name') is-invalid @enderror" value="{{$employee->employeeInfo->m_name}}" required>
                                        @error('m_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="d_o_b">Date of Birth <span class="t_r">*</span></label>
                                        <input type="date" name="d_o_b" class="form-control @error('d_o_b') is-invalid @enderror" value="{{$employee->employeeInfo->d_o_b}}" required>
                                        @error('d_o_b')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-5">
                                        <label for="nid">NID <span class="t_r">*</span></label>
                                        <input type="text" name="nid" class="form-control @error('nid') is-invalid @enderror" value="{{$employee->employeeInfo->nid}}" required>
                                        @error('nid')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="phone">Phone <span class="t_r">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{$employee->phone}}" required>
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="blood">Blood Group </label>
                                        <input type="text" name="blood" class="form-control @error('blood') is-invalid @enderror" value="{{$employee->employeeInfo->blood}}">
                                        @error('blood')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check col-sm-2">
										<label>Marital Status <span class="t_r">*</span></label><br>
										<select name="m_status" class="form-control @error('phone') is-invalid @enderror">
                                            <option selected disabled value >Select</option>
                                            <option value="1" {{($employee->employeeInfo->m_status =='1')?'selected':''}}>Married</option>
                                            <option value="2" {{($employee->employeeInfo->m_status =='2')?'selected':''}}>Unmarried</option>
                                        </select>
                                        @error('m_status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
									</div>

                                    <div class="form-group col-sm-5">
                                        <label for="email">Email <span class="t_r">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$employee->email}}" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="c_phone">Company Phone </label>
                                        <input type="text" name="c_phone" class="form-control @error('c_phone') is-invalid @enderror" value="{{$employee->employeeInfo->c_phone}}">
                                        @error('c_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="bank_list_id">Bank Name <span class="t_r">*</span></label>
                                        <select name="bank_list_id" id="" class="form-control @error('bank_list_id') is-invalid @enderror" required>
                                            @isset($selectBank->name)
                                            <option value="{{$selectBank->id}}">{{$selectBank->name}}</option>
                                            @endisset

                                            @foreach ($bankLists as $bankList)
                                            <option value="{{$bankList->id}}">{{$bankList->name}}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror"  value="{{$employee->employeeInfo->bank_name}}"> --}}
                                        @error('bank_list_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-sm-4">
                                        <label for="ac_name">Bank Account Name <span class="t_r">*</span></label>
                                        <input type="text" name="ac_name" class="form-control @error('ac_name') is-invalid @enderror"  required value="{{$employee->employeeInfo->ac_name}}">
                                        @error('ac_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="ac_no">Bank Account No. <span class="t_r">*</span></label>
                                        <input type="text" name="ac_no" class="form-control @error('ac_no') is-invalid @enderror" value="{{$employee->employeeInfo->ac_no}}">
                                        @error('ac_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="branch">Branch Name <span class="t_r">*</span></label>
                                        <input type="text" name="branch" class="form-control @error('branch') is-invalid @enderror" value="{{$employee->employeeInfo->branch}}">
                                        @error('branch')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="cheque_no">Bank Chequeco No. <span class="t_r">*</span></label>
                                        <input type="text" name="cheque_no" class="form-control @error('cheque_no') is-invalid @enderror" value="{{$employee->employeeInfo->cheque_no}}">
                                        @error('cheque_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="j_date">Joining Date <span class="t_r">*</span></label>
                                        <input type="date" name="j_date" class="form-control @error('j_date') is-invalid @enderror" value="{{$employee->employeeInfo->j_date}}" required>
                                        @error('j_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-sm-5">
                                        <label>Password <span class="t_r">*</span></label>
                                        <input type="password" class="form-control"  autocomplete="off" name="password" placeholder="password" autocomplete="new-password"
                                        onblur="this.setAttribute('readonly', 'readonly');"  onfocus="this.removeAttribute('readonly');" readonly>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-sm-5">
                                        <label>Confrim Password <span class="t_r">*</span></label>
                                        <input name="password_confirmation" type="password" class="form-control @error('email') is-invalid @enderror" value="{{$employee->password}}" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                </div>
                                <hr class="bg-warning">
                                {{-- _________________________ Salary Info_________________________ --}}
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <label for="basic_pay">Basic Pay</label>
                                        <input type="number" name="basic_pay" class="form-control totalAmt @error('basic_pay') is-invalid @enderror" value="{{$employee->employeeInfo->basic_pay}}">
                                        @error('basic_pay')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="house_rent">House Rent</label>
                                        <input type="number" name="house_rent" class="form-control totalAmt @error('house_rent') is-invalid @enderror" value="{{$employee->employeeInfo->house_rent}}">
                                        @error('house_rent')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="medical_a">Medical Allowance </label>
                                        <input type="number" name="medical_a" class="form-control totalAmt @error('medical_a') is-invalid @enderror" value="{{$employee->employeeInfo->medical_a}}">
                                        @error('medical_a')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="p_i_bill">Phone + Internet bill </label>
                                        <input type="number" name="p_i_bill" class="form-control totalAmt @error('p_i_bill') is-invalid @enderror" value="{{$employee->employeeInfo->p_i_bill}}">
                                        @error('p_i_bill')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="e_bonus">Encouragingly Bonus</label>
                                        <input type="number" name="e_bonus" class="form-control totalAmt @error('e_bonus') is-invalid @enderror" value="{{$employee->employeeInfo->e_bonus}}">
                                        @error('e_bonus')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="o_l_maintain">Out look Maintain</label>
                                        <input type="number" name="o_l_maintain" class="form-control totalAmt @error('o_l_maintain') is-invalid @enderror" value="{{$employee->employeeInfo->o_l_maintain}}">
                                        @error('o_l_maintain')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="dearness_a">Dearness Allowance</label>
                                        <input type="number" name="dearness_a" id="totalAmt" class="form-control totalAmt @error('dearness_a') is-invalid @enderror" value="{{$employee->employeeInfo->dearness_a}}">
                                        @error('dearness_a')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="travel_a">Traveling Allowance</label>
                                        <input type="number" name="travel_a" class="form-control totalAmt @error('travel_a') is-invalid @enderror" value="{{$employee->employeeInfo->travel_a}}">
                                        @error('travel_a')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group col-sm-2">
                                        <label for="da">DA</label>
                                        <input type="number" name="da" class="form-control totalAmt @error('da') is-invalid @enderror" value="{{old('da')}}">
                                        @error('da')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group col-sm-2">
                                        <label for="ad_salary">Deduction(Ad. Salary)</label>
                                        <input type="number" name="ad_salary" class="form-control totalAmt @error('ad_salary') is-invalid @enderror" value="{{$employee->employeeInfo->ad_salary}}">
                                        @error('ad_salary')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="total">Total Amount</label>
                                        <input type="number" name="total" id="total" class="form-control @error('total') is-invalid @enderror" readonly value="{{$employee->employeeInfo->total}}">
                                        @error('total')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <hr class="bg-warning">
                                {{-- _________________________Nominee Info_________________________ --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="g_name">Guarantor Name</label>
                                        <input type="text" name="g_name" class="form-control @error('g_name') is-invalid @enderror" value="{{$employee->employeeInfo->g_name}}">
                                        @error('g_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="g_phone">Guarantor Phone</label>
                                        <input type="number" name="g_phone" class="form-control @error('g_phone') is-invalid @enderror" value="{{$employee->employeeInfo->g_phone}}">
                                        @error('g_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="relation">Relation</label>
                                        <input type="text" name="relation" class="form-control @error('relation') is-invalid @enderror" value="{{$employee->employeeInfo->relation}}">
                                        @error('relation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="bg-warning">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="address">Mailing Address <span class="t_r">*</span></label>
                                        <textarea name="address" id="" cols="15" rows="6" class="form-control @error('address') is-invalid @enderror" required>{{$employee->address}}</textarea>
                                        {{-- <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{$employee->employeeInfo->address')}}" placeholder="Enter Address" required> --}}
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label for="address">Permanent Address <span class="t_r">*</span></label>
                                        <textarea name="p_address" id="" cols="15" rows="6" class="form-control @error('p_address') is-invalid @enderror" required>{{$employee->employeeInfo->p_address}}</textarea>
                                        {{-- <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{$employee->employeeInfo->address')}}" placeholder="Enter Address" required> --}}
                                        @error('p_address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="bg-warning">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img src="{{ asset('images/users/'.$employee->profile_photo_path) }}" height="200" width="200" alt="">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="image" class="placeholder">Image<span class="t_r">*</span></label>
                                        <input type="hidden" name="old_image" value="{{$employee->profile_photo_path}}">
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
                                                    <a href="{{route('employee.userFileDestroy', $userFile->id)}}"  class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>
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
        <form action="{{route('employee.userFileStore')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$employee->id }}" >
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
    var is = $('.is').val()
    if(is=='1'){
        $('#permissionShow').show()
    }else{
        $('#permissionShow').hide()
    }
    $('#permissionYes').click(function(){
        $('#permissionShow').show()
    })
    $('#permissionNo').click(function(){
        $('#permissionShow').hide()
    })
</script>
<script>
    $('.totalAmt').keyup(function() {

        var total = 0;
        var basic_pay = $("[name='basic_pay']").val()
        var house_rent = $("[name='house_rent']").val()
        var medical_a = $("[name='medical_a']").val()
        var p_i_bill = $("[name='p_i_bill']").val()
        var e_bonus = $("[name='e_bonus']").val()
        var o_l_maintain = $("[name='o_l_maintain']").val()
        var dearness_a = $("[name='dearness_a']").val()
        var travel_a = $("[name='travel_a']").val()
        var ad_salary = $("[name='ad_salary']").val()
        // var net_payable = $("[name='net_payable']").val()

        $('.totalAmt').each(function() {
            total = Number(basic_pay)+Number(house_rent)+Number(medical_a)+Number(p_i_bill)+Number(e_bonus)+Number(o_l_maintain)+Number(dearness_a)+Number(travel_a)-Number(ad_salary);
        });
        $('#total').val(total);
    });
</script>
<script>
    $('#designation').on('change', function(){
        var des = $(this).val()
        if(des==12){
            $('.zsm_id').show()
            $('.ssm_id').hide()
            $('.sm_id').hide()
            $('.customer_id').hide()
        }else if(des==13){
            $('.zsm_id').show()
            $('.ssm_id').show()
            $('.customer_id').show()
        }else{
            $('.zsm_id').hide()
            $('.ssm_id').hide()
            $('.sm_id').hide()
            $('.customer_id').hide()
        }
    })
</script>
@endpush
@endsection

