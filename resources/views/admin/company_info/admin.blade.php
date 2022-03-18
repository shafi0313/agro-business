@extends('admin.layout.master')
@section('title', 'Company Information')
@php $p='admin'; $sm="companyInfoAdmin" @endphp
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('slider.index')}}">Company Information</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Update</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Company Information</h4>
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
                            <form action="{{ route('admin.companyInfo.adminUpdate')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="name">Company Name <span class="t_r">*</span></label>
                                        <input id="name" name="name" type="text" class="form-control" value="{{ env('APP_NAME') }}" readonly>
                                        @if ($errors->has('name'))
                                            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone Number <span class="t_r">*</span></label>
                                        <input id="phone" name="phone" type="text" class="form-control" value="{{ $data->phone }}" required>
                                        @if ($errors->has('phone'))
                                            <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="email">Email Address </label>
                                        <input name="email" type="email" class="form-control" value="{{ $data->email }}">
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="address">Address <span class="t_r">*</span></label>
                                        <input name="address" type="text" class="form-control" value="{{ $data->address }}" required>
                                        @if ($errors->has('address'))
                                            <div class="alert alert-danger">{{ $errors->first('address') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <img src="{{ asset('files/images/icon/'.$data->logo) }}" height="100">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="logo">Logo <span class="t_r">*</span></label>
                                        <input name="logo" type="file" accept="image/*" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <img src="{{ asset('files/images/icon/'.$data->favicon) }}" height="100">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="favicon">Favicon <span class="t_r">*</span></label>
                                        <input id="favicon" name="favicon" type="file" accept="image/*" class="form-control">
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

@push('custom_scripts')
@endpush
@endsection

