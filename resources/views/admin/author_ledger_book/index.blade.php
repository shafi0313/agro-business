@extends('admin.layout.master')
@section('title', 'Author ledger Book')
@section('content')
@php $p = 'account'; $sm='autherLedger' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Author ledger Book</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Author</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Business Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:170px;text-align:center">Invoice</th>
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
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($authors as $author)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $author->tmm_so_id }}</td>
                                            <td>{{ $author->name }}</td>
                                            <td>{{ $author->business_name }}</td>
                                            <td>{{ $author->phone }}</td>
                                            <td>{{ $author->address }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('authorLedgerBook.reportAll', $author->id)}}">Show All</a>
                                                <span> || </span>
                                                <a href="{{ route('authorLedgerBook.selectDate', $author->id)}}">Show By Date</a>
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

