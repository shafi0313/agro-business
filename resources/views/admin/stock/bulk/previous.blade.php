@extends('admin.layout.master')
@section('title', 'Bulk Stock')
@php $p='factory'; $sm='bulkStock'; $ssm='bulkShow'; @endphp
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Bulk Stock</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Stock</h4>
                                <button type="button" class="btn btn-success btn-round ml-auto" id="p" onclick="printDiv('printableArea')">Print</button>
                                <a class="btn btn-primary btn-round ml-3" href="{{route("stock.bulk.create")}}">
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="printableArea">
                                <table id="multi-filter-select" class="display table table-border" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Product Name</th>
                                            <th>Group Name</th>
                                            <th>Pack Size</th>
                                            <th>Net Weight</th>
                                            <th>Quantity</th>
                                            <th class="no-sort text-center" style="width:40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1;@endphp
                                        @foreach($stocks as $stock)
                                            <tr>
                                                <td class="text-center">{{ $x++ }}</td>
                                                <td>{{ $stock->product->name }}</td>
                                                <td>{{ $stock->product->generic }}</td>
                                                <td>{{ $stock->packSize->size }}</td>
                                                <form action="{{ route('stock.bulk.update') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $stock->id }}">
                                                    <td><input type="text" class="form-control" name="net_weight" value="{{ $stock->net_weight}}"></td>
                                                    <td><input type="text" class="form-control" name="quantity" value="{{ $stock->quantity}}"></td>
                                                    <td><button type="submit" class="btn btn-primary">Update</button></td>
                                                </form>
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
@include('admin.include.printJS')
@endpush
@endsection

