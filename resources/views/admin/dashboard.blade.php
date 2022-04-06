@extends('admin.layout.master')
@section('title', 'Dashboard')
@section('content')
<?php $p = 'da'; $sm=''?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<div class="main-panel"> <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                {{-- <div class="btn-group btn-group-page-header ml-auto">
                    <button type="button" class="btn btn-light btn-round btn-page-header-dropdown dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="arrow"></div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div> --}}
            </div>
            <style>
                .card-category {
                    font-size: 14px;
                    font-weight: bold;
                }
                .card-stats .card-body  {
                    padding: 10px !important;
                    margin: 0;
                }
                .dash_menu ul {
                    width: 250px;
                }
                .dash_menu ul li{
                    list-style: none;
                    margin-bottom: 5px;
                }
                .dash_menu ul li a{
                    position: relative;
                    text-decoration: none;
                    padding: 6px 10px !important;
                    color: black;
                    z-index: 99999999;
                    display: block;
                    border: 1px solid #6610f2;
                    border-radius: 2px;
                    font-weight: 600;


                }
                .dash_menu ul li a::before {
                    position: absolute;
                    content: "";
                    left: 0;
                    top: 0;
                    height: 100%;
                    width: 0;
                    background: #716aca;
                    transition: .5s;
                    z-index: -1;

                }
                .dash_menu ul li a:hover:before, a{
                    width: 100%;
                }


            </style>

             @role('admin')
             <div class="row">
                 <div class="col-md-6">
                    <div class="dash_menu">
                        <ul>
                            <li><a href="{{ route('product.index') }}">Product</a></li>
                            <li><a href="{{ route('stock.bulk.index') }}">Bulk Stock</a></li>
                            <li><a href="{{ route('stock.store.index') }}">Stock</a></li>
                            <li><a href="{{ route('sales-invoice-cash.index') }}">Sales</a></li>
                            <li><a href="{{ route('salesLedgerBook.index') }}">Sales Ledger Book</a></li>
                            <li><a href="{{ route('report.salesAndStock.selectDate') }}">Sales Report</a></li>
                            <li><a href="{{ route('empReport.user') }}">Employee Report</a></li>
                        </ul>
                    </div>
                 </div>
             </div>

             {{-- <div class="row col-md-12">
                 <table class="table table-bordered">
                     <thead>
                         <tr>
                             <th>Bulk</th>
                             <th>Repaking Unit</th>
                             <th>Store</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td><a href="{{ route('raw-material.index')}}">Bulk Name</a></td>
                             <td><a href="{{ route('repackingCheck.showAccpet')}}">QA/QC</a></td>
                             <td><a href="{{ route('product.index')}}">Product</a></td>
                         </tr>
                         <tr>
                            <td><a href="{{ route('purchase-bulk.index')}}">Purchase</a></td>
                            <td><a href="{{ route('bulkTracking.showInvoice')}}">Production</a></td>
                            <td><a href="{{ route('productionCheck.showAccpet')}}">QA/QC</a></td>
                         </tr>
                         <tr>
                             <td><a href="{{ route('sales-bulk.index')}}">Sales</a></td>
                             <td><a href="{{ route('send-to-production.index')}}">Send to Store</a></td>
                         </tr>
                         <tr>
                             <td><a href="{{ route('send-to-repack-unit.index')}}">Send to Repack Unit</a></td>
                         </tr>
                         <tr>
                             <td><a href="{{ route('purchaseLedgerBook.index')}}">Purchase Ledger Book</a></td>
                         </tr>
                     </tbody>
                 </table>
             </div> --}}
             @endrole

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-info card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <a href="{{ route('customer.index')}} ">
                                            <p class="card-category">Total Customer</p>
                                            <h4 class="card-title">{{ $customers }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                </div>
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <a href="{{ route('supplier.index') }} ">
                                            <p class="card-category">Total Supplier</p>
                                            <h4 class="card-title">{{ $supplier }} </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-secondary card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-pills"></i>
                                    </div>
                                </div>
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <a href="{{ route('product.index') }} ">
                                            <p class="card-category">Total Product</p>
                                            <h4 class="card-title"> {{ $products }} </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.footer')
</div>
@endsection

