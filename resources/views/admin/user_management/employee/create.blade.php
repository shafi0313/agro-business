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
                            <form action="{{ route('employee.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-check col-sm-3">
										<label>Login Permission <span class="t_r">*</span></label><br>
										<label class="form-radio-label" id="permissionYes">
											<input class="form-radio-input" type="radio" name="permission_status" value="1" >
											<span class="form-radio-sign">Yes</span>
										</label>
										<label class="form-radio-label ml-3">
											<input class="form-radio-input" type="radio" name="permission_status" value="0" checked id="permissionNo">
											<span class="form-radio-sign">No</span>
										</label>
									</div>

                                    <div class="form-group col-sm-6">
                                        <div style="display: none" id="permissionShow">
                                            <select name="permission" id="" class="form-control @error('permission') is-invalid @enderror">
                                                <option selected >Select</option>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('permission')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="designation">Designation <span class="t_r">*</span></label>
                                        <select name="employee_main_cat_id" id="designation" class="form-control @error('employee_main_cat_id') is-invalid @enderror" required>
                                            <option value selected disabled>Select Designation </option>
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
                                            <option selected >Select</option>
                                            @foreach ($empDesignations->where('employee_main_cat_id',11) as $empDesignation)
                                            <option value="{{$empDesignation->user_id}}">{{$empDesignation->user->name}}</option>
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

                                    <div class="form-group col-sm-4 sm_id" style="display: none">
                                        <label for="so_id">Sales Manager </label>
                                        <select name="so_id" class="form-control">
                                            <option selected >Select</option>
                                            @foreach ($empDesignations->where('employee_main_cat_id', 13) as $empDesignation)
                                            <option value="{{$empDesignation->user_id}}">{{$empDesignation->user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="job_loc">Job Location</label>
                                        <input type="text" name="job_loc" class="form-control @error('job_loc') is-invalid @enderror" value="{{old('job_loc')}}">
                                        @error('job_loc')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="tmm_so_id">Employee Id</label>
                                        <input type="text" name="tmm_so_id" class="form-control @error('tmm_so_id') is-invalid @enderror" value="{{old('tmm_so_id')}}" placeholder="Enter Employee Id">
                                        @error('tmm_so_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="name">Employee Name <span class="t_r">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Enter Employee Name" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="f_name">Father Name <span class="t_r">*</span></label>
                                        <input type="text" name="f_name" class="form-control @error('f_name') is-invalid @enderror" value="{{old('f_name')}}" placeholder="Enter Father Name" required>
                                        @error('f_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="m_name">Mother Name <span class="t_r">*</span></label>
                                        <input type="text" name="m_name" class="form-control @error('m_name') is-invalid @enderror" value="{{old('m_name')}}" placeholder="Enter Mother Name" required>
                                        @error('m_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="d_o_b">Date of Birth <span class="t_r">*</span></label>
                                        <input type="date" name="d_o_b" class="form-control @error('d_o_b') is-invalid @enderror" value="{{old('d_o_b')}}" placeholder="Enter Date of Birth" required>
                                        @error('d_o_b')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-5">
                                        <label for="nid">NID <span class="t_r">*</span></label>
                                        <input type="text" name="nid" class="form-control @error('nid') is-invalid @enderror" value="{{old('nid')}}" placeholder="Enter NID" required>
                                        @error('nid')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="phone">Personal Phone <span class="t_r">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" placeholder="Enter Phone" required>
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="blood">Blood Group </label>
                                        <input type="text" name="blood" class="form-control @error('blood') is-invalid @enderror" value="{{old('blood')}}" placeholder="Enter Blood Group">
                                        @error('blood')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check col-sm-2">
										<label>Marital Status <span class="t_r">*</span></label><br>
										<select name="m_status" class="form-control @error('phone') is-invalid @enderror">
                                            <option selected disabled value >Select</option>
                                            <option value="1" >Married</option>
                                            <option value="2" >Unmarried</option>
                                        </select>
                                        @error('m_status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
									</div>

                                    <div class="form-group col-sm-5">
                                        <label for="email">Email <span class="t_r">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="Enter Email" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="c_phone">Company Phone </label>
                                        <input type="text" name="c_phone" class="form-control @error('c_phone') is-invalid @enderror" value="{{old('c_phone')}}" placeholder="Enter Company Phone">
                                        @error('c_phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="bank_list_id">Bank Name <span class="t_r">*</span></label>
                                        <select name="bank_list_id" class="form-control" required>
                                            <option value selected disabled>Select Bank</option>
                                            @foreach ($bankLists as $bankList)
                                            <option value="{{$bankList->id}}">{{$bankList->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_list_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="ac_name">Bank Account Name  <span class="t_r">*</span></label>
                                        <input type="text" name="ac_name" class="form-control @error('ac_name') is-invalid @enderror" value="{{old('ac_name')}}" placeholder="Enter Bank Account Name.">
                                        @error('ac_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="ac_no">Bank Account No. <span class="t_r">*</span></label>
                                        <input type="text" name="ac_no" class="form-control @error('ac_no') is-invalid @enderror" value="{{old('ac_no')}}" placeholder="Enter Bank Account No.">
                                        @error('ac_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="branch">Branch Name <span class="t_r">*</span></label>
                                        <input type="text" name="branch" class="form-control @error('branch') is-invalid @enderror" value="{{old('branch')}}" placeholder="Enter Branch Name">
                                        @error('branch')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="cheque_no">Bank Chequeco No. <span class="t_r">*</span></label>
                                        <input type="text" name="cheque_no" class="form-control @error('cheque_no') is-invalid @enderror" value="{{old('cheque_no')}}" placeholder="Enter Bank Chequeco No.">
                                        @error('cheque_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="j_date">Joining Date <span class="t_r">*</span></label>
                                        <input type="date" name="j_date" class="form-control @error('j_date') is-invalid @enderror" value="{{old('j_date')}}" placeholder="Enter Joining Date" required>
                                        @error('j_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-5">
                                        <label>Password <span class="t_r">*</span></label>
                                        <input name="password" type="password" class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-5">
                                        <label>Confrim Password <span class="t_r">*</span></label>
                                        <input name="password_confirmation" type="password" class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <hr class="bg-warning">
                                {{-- _________________________ Salary Info_________________________ --}}
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <label for="basic_pay">Basic Pay</label>
                                        <input type="number" name="basic_pay" class="form-control totalAmt @error('basic_pay') is-invalid @enderror" value="{{old('basic_pay')}}">
                                        @error('basic_pay')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="house_rent">House Rent</label>
                                        <input type="number" name="house_rent" class="form-control totalAmt @error('house_rent') is-invalid @enderror" value="{{old('house_rent')}}">
                                        @error('house_rent')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="medical_a">Medical Allowance </label>
                                        <input type="number" name="medical_a" class="form-control totalAmt @error('medical_a') is-invalid @enderror" value="{{old('medical_a')}}">
                                        @error('medical_a')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="p_i_bill">Phone+Internet bill </label>
                                        <input type="number" name="p_i_bill" class="form-control totalAmt @error('p_i_bill') is-invalid @enderror" value="{{old('p_i_bill')}}">
                                        @error('p_i_bill')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="e_bonus">Encouragingly Bonus</label>
                                        <input type="number" name="e_bonus" class="form-control totalAmt @error('e_bonus') is-invalid @enderror" value="{{old('e_bonus')}}">
                                        @error('e_bonus')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="o_l_maintain">Out look Maintain</label>
                                        <input type="number" name="o_l_maintain" class="form-control totalAmt @error('o_l_maintain') is-invalid @enderror" value="{{old('o_l_maintain')}}">
                                        @error('o_l_maintain')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="dearness_a">Dearness Allowance</label>
                                        <input type="number" name="dearness_a" id="totalAmt" class="form-control totalAmt @error('dearness_a') is-invalid @enderror" value="{{old('dearness_a')}}">
                                        @error('dearness_a')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="travel_a">Traveling Allowance</label>
                                        <input type="number" name="travel_a" class="form-control totalAmt @error('travel_a') is-invalid @enderror" value="{{old('travel_a')}}">
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
                                        <label for="ad_salary">Deduction (Ad. Salary)</label>
                                        <input type="number" name="ad_salary" class="form-control totalAmt @error('ad_salary') is-invalid @enderror" value="{{old('ad_salary')}}">
                                        @error('ad_salary')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="total">Total Amount</label>
                                        <input type="number" name="total" id="total" class="form-control @error('total') is-invalid @enderror" readonly>
                                        @error('total')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="bg-warning">
                                {{-- _________________________ Nominee Info_________________________ --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="g_name">Guarantor Name</label>
                                        <input type="text" name="g_name" class="form-control @error('g_name') is-invalid @enderror" value="{{old('g_name')}}" placeholder="Enter Guarantor Name">
                                        @error('g_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="g_phone">Guarantor Phone</label>
                                        <input type="number" name="g_phone" class="form-control @error('g_phone') is-invalid @enderror" value="{{old('g_phone')}}" placeholder="Enter Guarantor Phone">
                                        @error('g_phone')
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
                                </div>

                                <hr class="bg-warning">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="address">Mailing Address <span class="t_r">*</span></label>
                                        <textarea name="address" id="" cols="15" rows="6" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Enter Mailing Address" required></textarea>
                                        {{-- <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Enter Address" required> --}}
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label for="address">Permanent Address <span class="t_r">*</span></label>
                                        <textarea name="p_address" id="" cols="15" rows="6" class="form-control @error('p_address') is-invalid @enderror" value="{{old('p_address')}}" placeholder="Enter Permanent Address" required></textarea>
                                        {{-- <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Enter Address" required> --}}
                                        @error('p_address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

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
                                            <td><input type="file" name="name[]" multiple id="document_1" class="form-control form-control-sm" style="width:250px"/></td>
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
    @include('admin.layout.footer')
</div>

@push('custom_scripts')
<script>
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
<script>
	$(document).ready(function(){
		var i = 1;
		$('.addrow').click(function()
			{i++;
				html ='';
				html +='<tr id="remove_'+i+'" class="post_item">';
	            html +='    <td><input type="file" name="name[]" multiple id="document_1" class="form-control form-control-sm" style="width:200px"/></td>';
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

