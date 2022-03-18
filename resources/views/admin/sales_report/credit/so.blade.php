@extends('admin.layout.master')
@section('title', 'Employee Sales Report')
@section('content')
@php $p='tools'; $sm="userIndex"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Employee Sales Report</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Employee Sales Report</h4>
                                {{-- <a class="btn btn-primary btn-round ml-auto" href="{{ route('company-store.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Store
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Name</th>
                                            <th>Sales Amount</th>
                                            <th>Collection Amount</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($reports as $report)
                                        @php $sReport = $report->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><span style="padding-left: 50px"></span>{{ $sReport->so->name }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->sum('amt'),2) }}</td>
                                        </tr>
                                        @endforeach

                                        @foreach($reports as $report)
                                        @php $sReport = $report->first(); @endphp
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td><span style="padding-left: 70px"></span>{{ $sReport->customer->business_name }} => {{ $sReport->customer->name }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',1)->sum('amt'),2) }}</td>
                                            <td class="text-right">{{ number_format($report->where('type',2)->sum('amt'),2) }}</td>
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

