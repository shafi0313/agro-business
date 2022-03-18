@extends('admin.layout.master')
@section('title', 'Doctors')
@section('content')
@php $p='factory'; $sm="balkRepack"; $ssm = 'bulkShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Doctors</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                    <a href="{{ route('admin.dashboard')}}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Tables</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Datatables</a>
                    </li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
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
                            <form action="{{ route('doctor.update', $admins->id)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="form-group form-floating-label col-md-6">
                                        <input id="name" name="name" type="text" class="form-control input-border-bottom" value="{{$admins->name}}" required="">
                                        <label for="name" class="placeholder">Name</label>
                                    </div>

                                    <div class="form-group form-floating-label col-md-6">
                                        <select class="form-control input-solid" id="specialist" name="doctor_specialist" required=""alue="{{$admins->doctor_specialist}}>
                                            <option value="">&nbsp;</option>
                                            @foreach($doctorSpecialists as $doctorSpecialist)
                                            <option value="{{ $doctorSpecialist->specialist }}">{{ $doctorSpecialist->specialist }}</option>
                                            @endforeach
                                        </select>
                                        <label for="specialist" class="placeholder">Specialist</label>
                                    </div>

                                    <div class="form-group form-floating-label col-md-4">
                                        <input id="phone" name="phone" type="text" value="{{$admins->phone}}" class="form-control input-border-bottom" required="">
                                        <label for="phone" class="placeholder">Phone</label>
                                    </div>

                                    <div class="form-group form-floating-label col-md-3">
                                        <input id="age" name="age" type="text" value="{{$admins->age}}" class="form-control input-border-bottom" required="">
                                        <label for="age" class="placeholder">Age</label>
                                    </div>

                                    <div class="form-check col-md-2">
                                        <label>Gender</label><br>
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="gender" value="male" {{$admins->gender=='male'?'checked':''}}>
                                            <span class="form-radio-sign">Male</span>
                                        </label>
                                        <label class="form-radio-label ml-4">
                                            <input class="form-radio-input" type="radio" name="gender" value="female" {{$admins->gender=='female'?'checked':''}}>
                                            <span class="form-radio-sign">Female</span>
                                        </label>
                                    </div>

                                    <div class="form-group form-floating-label col-md-3">
                                        <input id="fees" name="fees" value="{{$admins->fees}}" type="text" class="form-control input-border-bottom" required="">
                                        <label for="fees" class="placeholder">Fees</label>
                                    </div>


                                    <div class="form-group form-floating-label col-md-6">
                                        <input id="email" name="email" type="email" value="{{$admins->email}}" class="form-control input-border-bottom" required="">
                                        <label for="email" class="placeholder">Email</label>
                                    </div>

                                    <div class="form-group form-floating-label col-md-6">
                                        <input id="address" name="address" type="text" value="{{$admins->address}}" class="form-control input-border-bottom" required="">
                                        <label for="address" class="placeholder">Address</label>
                                    </div>

                                    <div class="form-group form-floating-label col-md-6">
                                    <input id="password" name="password" type="password" class="form-control input-border-bottom" value="{{$admins->password}}" required="">
                                        <label for="password" class="placeholder">Password</label>
                                    </div>
                                    <div class="form-group form-floating-label col-md-6">
                                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control input-border-bottom" required="">
                                        <label for="password_confirmation" class="placeholder">Confirm Password</label>
                                    </div>
                                </div>
                                <div align="center" class="card-action">
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

@push('custom_scripts')
@endpush
@endsection

