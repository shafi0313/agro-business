@extends('admin.layout.master')
@section('title', 'Slider')
@php $p='slider'; $sm="balkPurchase"; @endphp
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('slider.index')}}">Slider</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Edit</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Image Slide</h4>
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
                            <form action="{{ route('pack-size.update', $packSize->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-center">
                                    <div class="form-check col-3">
                                        <label>For <span class="t_r">*</span></label><br>
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="type" value="2" {{($packSize->type=='2')? 'checked':''}}>
                                            <span class="form-radio-sign">Raw Material</span>
                                        </label>

                                        <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="type" value="1" {{($packSize->type=='1')? 'checked':''}}>
                                            <span class="form-radio-sign">Product</span>
                                        </label>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="size" class="col-sm-2 control-label">Size <span class="t_r">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="size" name="size"value="{{$packSize->size}}" required>
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

