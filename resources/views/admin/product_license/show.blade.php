@extends('admin.layout.master')
@section('title', 'Product License')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Tools</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Product License</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Product License</h4>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('product-license.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Product
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw text-center">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            {{-- <th>License Name</th> --}}
                                            <th>Brand Name</th>
                                            <th>AP/Reg. No.</th>
                                            <th>Group Name</th>
                                            <th>Issue Date</th>
                                            <th>Expired Date</th>
                                            <th>Renewal Date</th>
                                            <th class="no-sort" style="width:80 px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div style="font-size: 30px; text-align:center"><b>License Name: </b>{{$licese->name}}</div>
                                        @php $x=1; @endphp
                                        @foreach($products as $product)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $product->product->name }}</td>
                                            <td>{{ $product->reg_no }}</td>
                                            <td>{{ $product->product->generic }}</td>
                                            <td>{{ \Carbon\Carbon::parse($product->issue_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($product->expired_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($product->renewal_date)->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('product-license.edit', $product->id) }}" title="Edit" class="btn btn-link btn-primary">
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

