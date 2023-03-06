@extends('admin.layout.master')
@section('title', 'Bulk Sales Report')
@section('content')
@php $p='factory'; $ssm='bulkShow'; $sm="bulkReport" @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Select Date</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- <div class="d-flex align-items-center">
                                <h4 class="card-title">Select Date</h4>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('report.profitLoss.show') }}" method="get">
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <div class="form-group row">
                                            <label for="form_date" class="col-sm-2 col-form-label">Form Date:</label>
                                            <div class="col-sm-4">
                                            <input type="month" name="start_date" class="form-control" id="start_date" placeholder="Email">
                                            </div>

                                            <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                            <div class="col-sm-4">
                                            <input type="month" name="end_date" class="form-control" id="end_date" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 10px">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
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

