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
                            <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item submenu">
                                    <a class="nav-link active show" id="bulk_sales-tab" data-toggle="pill" href="#bulk_sales" role="tab" aria-controls="bulk_sales" aria-selected="false">Bulk Sales Report</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="bulk_purchase-tab" data-toggle="pill" href="#bulk_purchase" role="tab" aria-controls="bulk_purchase" aria-selected="false">Bulk Purchase Report</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="send_to_unit-tab" data-toggle="pill" href="#send_to_unit" role="tab" aria-controls="send_to_unit" aria-selected="true">Send to Repack Unit</a>
                                </li>
                                <li class="nav-item submenu">
                                    <a class="nav-link" id="balk_challan-tab" data-toggle="pill" href="#balk_challan" role="tab" aria-controls="balk_challan" aria-selected="true">Bulk Sales & Send to Repack Unit Challan</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                                <br>
                                <div class="tab-pane fade  active show" id="bulk_sales" role="tabpanel" aria-labelledby="bulk_sales-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show bulk sales report</h1>
                                    <br>
                                    <form action="{{ route('report.bulk.sales') }}" method="post">
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

                                <div class="tab-pane fade" id="bulk_purchase" role="tabpanel" aria-labelledby="bulk_purchase-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show bulk purchase report</h1>
                                    <br>
                                    <form action="{{ route('report.bulk.purchase') }}" method="post">
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

                                <div class="tab-pane fade" id="send_to_unit" role="tabpanel" aria-labelledby="send_to_unit-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show send to repack unit report</h1>
                                    <br>
                                    <form action="{{ route('report.bulk.sendToRepackUnit') }}" method="post">
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

                                <div class="tab-pane fade" id="balk_challan" role="tabpanel" aria-labelledby="balk_challan-tab">
                                    <h1 class="text-center mr-5 mb-3">Select the date and show Bulk Sales & Send to Repack Unit Challan</h1>
                                    <br>
                                    <form action="{{ route('salesBulk.bulkSalesRepackChallan') }}" method="post">
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

