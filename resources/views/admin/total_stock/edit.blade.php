@extends('admin.layout.master')
@section('title', 'Bulk Stock')
@section('content')
@php $p='factory'; $sm="bulkStock"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('bulkStock.index')}}">Bulk Stock</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create Product</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Porduct</h4>
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
                            <form action="{{ route('bulkStock.update', $stock->id)}}" method="post">
                                @csrf
                                {{-- @method('PUT') --}}

                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ $stock->quantity}}">
                                        @error('quantity')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="net_weight">Net Weight</label>
                                        <input type="text" name="net_weight" class="form-control @error('net_weight') is-invalid @enderror" value="{{ $stock->net_weight}}">
                                        @error('net_weight')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="damage">Damage</label>
                                        <input type="text" name="damage" class="form-control @error('damage') is-invalid @enderror" value="{{ $stock->damage}}">
                                        @error('damage')
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

