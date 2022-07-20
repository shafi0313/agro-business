@extends('admin.layout.master')
@section('title', 'Employee Category')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Tools</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('employee-main-cat.index')}}">Employee Category</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Edit</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Employee Category</h4>
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
                            <form action="{{ route('employee-main-cat.update', $employeeMainCat->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-center">
                                    <div class="form-group col-12">
                                        <label for="size" class="col-sm-2 control-label">Category Name <span class="t_r">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="name" value="{{$employeeMainCat->name}}" required>
                                        </div>
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

