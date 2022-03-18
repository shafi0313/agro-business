@extends('admin.layout.master')
@section('title', 'Products')
@section('content')
@php $p='factory'; $sm="product"; $ssm='storeShow'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Products</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Products Table</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('product.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Product
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Brand Name</th>
                                            <th>Group Name</th>
                                            <th>Category</th>
                                            <th>Pack</th>
                                            <th>Purchase</th>
                                            <th>Price</th>
                                            <th>Dealer Price</th>
                                            <th>MRP</th>
                                            <th>Image</th>
                                            <th class="no-sort" style="width:30px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($porducts as $porduct)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $porduct->name }}</td>
                                            <td>{{ $porduct->generic }}</td>
                                            <td>{{ $porduct->productCat->name }}</td>
                                            <td>{{ $porduct->productPackSize->size }}</td>
                                            <td>{{ $porduct->productPackSize->purchase }}</td>
                                            <td>{{ $porduct->productPackSize->trade_price }}</td>
                                            <td>{{ $porduct->productPackSize->cash }}</td>
                                            <td>{{ $porduct->productPackSize->mrp }}</td>
                                            <td width="70"><img src="{{ asset('images/product/' .$porduct->image) }}" height="100" width="100" alt=""> </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('product.edit', $porduct->id)}}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('product.destroy', $porduct->id) }}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
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

