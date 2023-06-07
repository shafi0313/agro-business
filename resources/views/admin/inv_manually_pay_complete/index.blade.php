@extends('admin.layout.master')
@section('title', 'Products')
@section('content')
@php $p='factory'; $sm="product"; $ssm='storeShow'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Product</li>
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
                            <form action="{{ route('invoiceManuallyPayComplete.index')}}" method="get">
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <label for="invoice_no">Invoice No <span class="t_r">*</span></label>
                                        <input type="search" name="invoice_no" class="form-control @error('invoice_no') is-invalid @enderror" value="{{old('invoice_no')}}" placeholder="Enter Invoice No" required>
                                        @error('invoice_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        
                                    </div>
                                    <div style="margin-top: 40px">
                                        <button type="submit" class="btn btn-success">Search</button>  
                                    </div>                                                                    
                                </div>
                            </form>
                            <br>
                            <hr>
                            @isset ($invoice)
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Date</th>
                                            <th>Payment Date</th>
                                            <th>Sales Amount</th>
                                            <th>Discount</th>
                                            <th>Net Amount</th>
                                            <th>Payment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        <tr>                                            
                                            <td>{{ $invoice->customer->business_name }}</td>
                                            <td>{{ $invoice->invoice_no }}</td>
                                            <td>{{ bdDate($invoice->invoice_date) }}</td>
                                            <td>{{ bdDate($invoice->payment_date) }}</td>
                                            <td class="text-right">{{ $invoice->sales_amt }}</td>
                                            <td class="text-right">{{ $invoice->discount_amt }}</td>
                                            <td class="text-right">{{ $invoice->net_amt }}</td>
                                            <td class="text-right">{{ number_format($invoicePayment,2) }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('invoiceManuallyPayComplete.update') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                                    <button type="submit" class="btn btn-warning"><i class="fa-solid fa-circle-check"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @endisset
                            
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

