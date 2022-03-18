@extends('admin.layout.master')
@section('title', 'Repack Unit Stock')
@section('content')
@php $p='productStock'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Repack Unit Stock</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">All Repack Unit Stock List</h4>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('customer.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Customer
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm table-bordered">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Net Weight</th>
                                            <th class="text-center">Damaged</th>
                                            <th class="text-center">Total Stock</th>
                                            {{-- <th class="text-center">Amount</th> --}}
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $key => $stock)
                                        <tr>
                                            <td class="text-center">{{ ++$key }} </td>
                                            <td>{{ $stock->product->name }} </td>
                                            <td>{{ $stock->productPackSize->size }} </td>
                                            <td class="text-center">{{ $stock->quantity }} </td>
                                            <td class="text-center">{{ $stock->net_weight }} </td>
                                            <td class="text-center">{{ $stock->damage }} </td>
                                            @php
                                                if($stock->damage < 1 ){
                                                    $total = $stock->quantity + $stock->damage;
                                                }else{
                                                    $total = $stock->quantity - $stock->damage;
                                                }
                                            @endphp
                                            <td class="text-center {{($total<0)? 'bg-danger text-light':'' }}">{{ $total }} </td>
                                            {{-- <td class="text-center">{{ $stock->amt }} </td> --}}
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('bulkStock.edit',$stock->id) }}" class="btn btn-link btn-info" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom_scripts')
@include('admin.include.data_table_js')
@endpush
@endsection

