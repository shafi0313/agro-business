@extends('admin.layout.master')
@section('title', 'Head Office Expense Report')
@section('content')
@php $p = 'account'; $sm='officeExpRe'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="">Head Office Expense Report</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Select Date</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Select Date</h4>
                            </div>
                        </div>
                        <div class="card-body" >
                            <h1 class="text-center mr-5 mb-3">Select the date and show expense report</h1>
                            <form action="{{ route('officeExp.report') }}" method="post">
                                @csrf

                                <div class="row justify-content-center">
                                    <div class="form-group col-sm-8">
                                        <label for="">Expense Type <span class="t_r">*</span></label>
                                        <select name="exp_type" id="exp_type" class="form-control" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($expenseCats as $expenseCat)
                                            <option value="{{ $expenseCat->id }}">{{ $expenseCat->name }}</option>
                                            @endforeach
                                            <option value="sup">Payment to Suppliers</option>
                                        </select>
                                    </div>
                                    <div class="form-group row col-md-8">
                                        <label for="form_date" class="col-sm-2 col-form-label">Form Date:</label>
                                        <div class="col-sm-4">
                                          <input type="date" name="form_date" class="form-control" id="form_date" required>
                                        </div>

                                        <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                        <div class="col-sm-4">
                                          <input type="date" name="to_date" class="form-control" id="to_date" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary" style="width: 250px">Submit</button>
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

