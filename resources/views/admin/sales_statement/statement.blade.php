@extends('admin.layout.master')
@section('title', 'Sales Statement')
@section('content')
@php $p = 'account'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Supplier</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Supplier Table</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('supplier.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Supplier
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Name</th>
                                            <th>Sales Amounts</th>
                                            <th>Payment</th>
                                            <th>Dues</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($salesStatements as $salesStatement)
                                        <tr>
                                            @php $statement = $salesStatement->first(); @endphp

                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $statement->customer->name }}</td>
                                            <td class="text-right">{{ number_format($salesStatement->sum('sales_amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($salesStatement->sum('payment'),2) }}</td>

                                            <td class="text-right">{{ number_format(abs($salesStatement->sum('sales_amt')) - $salesStatement->sum('payment'),2) }}</td>
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

