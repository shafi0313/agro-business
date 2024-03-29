@extends('admin.layout.master')
@section('title', 'Sales Stock Report')
@section('content')
@php $p='sales'; $sm="salesCash" @endphp
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
                            <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item submenu">
                                    <a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false">Sales</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">Profile</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                                <br>
                                <div class="tab-pane fade  active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show the report</h1>
                                    <br>
                                    <form action="{{ route('stockReport.salesReport') }}" method="post">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-7">
                                                <div class="form-group row">
                                                    <label for="form_date" class="col-sm-2 col-form-label">Form Date:</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" name="form_date" class="form-control" id="form_date" placeholder="Email">
                                                    </div>

                                                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" name="to_date" class="form-control" id="to_date" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="margin-top: 10px">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show the report</h1>
                                    <br>
                                    <form action="{{ route('stockReport.salesReport') }}" method="post">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-7">
                                                <div class="form-group row">
                                                    <label for="form_date" class="col-sm-2 col-form-label">Form Date:</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" name="form_date" class="form-control" id="form_date" placeholder="Email">
                                                    </div>

                                                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" name="to_date" class="form-control" id="to_date" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="margin-top: 10px">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show the report</h1>
                                    <br>
                                    <form action="{{ route('stockReport.salesReport') }}" method="post">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-7">
                                                <div class="form-group row">
                                                    <label for="form_date" class="col-sm-2 col-form-label">Form Date:</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" name="form_date" class="form-control" id="form_date" placeholder="Email">
                                                    </div>

                                                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" name="to_date" class="form-control" id="to_date" placeholder="Email">
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
    </div>
</div>

@push('custom_scripts')

@endpush
@endsection

