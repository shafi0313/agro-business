@extends('admin.layout.master')
@section('title', 'Product License')
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
                    <li class="nav-item"><a href="{{ route('product.index')}}">Show Product</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Product License</h4>
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Launch demo modal
                                  </button> --}}
                                  {{-- <a class="btn btn-primary btn-round ml-auto text-light" data-toggle="modal" data-target="#addSize" >
                                    <i class="fa fa-plus"></i>
                                    Add New Size
                                  </a> --}}
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
                            <form action="{{ route('product-license.update', $product->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label for="license_cat_id">Licenses <span class="t_r">*</span></label>
                                        <select name="license_cat_id" class="form-control @error('license_cat_id') is-invalid @enderror">
                                            @foreach ($licenseCats as $licenseCat)
                                                <option value="{{$licenseCat->id}}" {{$product->license_cat_id == $licenseCat->id?'selected':''}}>{{$licenseCat->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('license_cat_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="product_id">Products <span class="t_r">*</span></label>
                                        <select name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                                            @foreach ($getProducts as $getProduct)
                                                <option value="{{$getProduct->id}}" {{$product->product_id == $getProduct->id?'selected':''}}>{{$getProduct->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="reg_no">AP/Reg. No. <span class="t_r">*</span></label>
                                        <input type="text" name="reg_no" class="form-control @error('reg_no') is-invalid @enderror" value="{{ $product->reg_no }}" required>
                                        @error('reg_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="issue_date">Issue Date <span class="t_r">*</span></label>
                                        <input type="text" name="issue_date" class="form-control @error('issue_date') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($product->issue_date)->format('d/m/Y') }}" required>
                                        @error('issue_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="expired_date">Expired Date <span class="t_r">*</span></label>
                                        <input type="text" name="expired_date" class="form-control @error('expired_date') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($product->expired_date)->format('d/m/Y') }}" required>
                                        @error('expired_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="renewal_date">Renewal Date <span class="t_r">*</span></label>
                                        <input type="text" name="renewal_date" class="form-control @error('renewal_date') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($product->renewal_date)->format('d/m/Y') }}" required>
                                        @error('renewal_date')
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

@push('custom_scripts')


@endpush
@endsection

