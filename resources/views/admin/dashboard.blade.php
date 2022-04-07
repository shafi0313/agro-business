@extends('admin.layout.master')
@section('title', 'Dashboard')
@section('content')
<?php $p = 'da'; $sm=''?>
<div class="main-panel">
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

                .card-stats .card-body {
                    padding: 10px !important;
                    margin: 0;
                }

                .dash_menu ul {
                    width: 250px;
                }

                .dash_menu ul li {
                    list-style: none;
                    margin-bottom: 5px;
                }

                .dash_menu ul li a {
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

                .dash_menu ul li a:hover:before,
                a {
                    width: 100%;
                }
            </style>
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
                    <div class="card card-stats card-warning card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats">
                                    <div class="numbers">
                                        <a href="{{ route('employee.index')}} ">
                                            <p class="card-category">Total Employee</p>
                                            <h4 class="card-title">{{ $employee }}</h4>
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
                <div class="col-md-6">
                    <style>
                        .clock {
                            background: #ececec;
                            width: 326px;
                            height: 326px;
                            margin: 0% auto 0;
                            border-radius: 50%;
                            border: 14px solid #333;
                            position: relative;
                            /* box-shadow: 0 2vw 4vw -1vw rgba(0,0,0,0.8); */
                        }
                        .clock .dot {
                            width: 14px;
                            height: 14px;
                            border-radius: 50%;
                            background: #ccc;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            margin: auto;
                            position: absolute;
                            z-index: 10;
                            box-shadow: 0 2px 4px -1px black;
                        }
                        .clock .hour-hand {
                            position: absolute;
                            z-index: 5;
                            width: 4px;
                            height: 65px;
                            background: #333;
                            top: 79px;
                            transform-origin: 50% 72px;
                            left: 50%;
                            margin-left: -2px;
                            border-top-left-radius: 50%;
                            border-top-right-radius: 50%;
                        }
                        .clock .minute-hand {
                            position: absolute;
                            z-index: 6;
                            width: 4px;
                            height: 100px;
                            background: #666;
                            top: 46px;
                            left: 50%;
                            margin-left: -2px;
                            border-top-left-radius: 50%;
                            border-top-right-radius: 50%;
                            transform-origin: 50% 105px;
                        }
                        .clock .second-hand {
                            position: absolute;
                            z-index: 7;
                            width: 2px;
                            height: 120px;
                            background: gold;
                            top: 26px;
                            lefT: 50%;
                            margin-left: -1px;
                            border-top-left-radius: 50%;
                            border-top-right-radius: 50%;
                            transform-origin: 50% 125px;
                        }
                        .clock span {
                            display: inline-block;
                            position: absolute;
                            color: #333;
                            font-size: 22px;
                            font-family: 'Poiret One';
                            font-weight: 700;
                            z-index: 4;
                        }
                        .clock .h12 {
                            top: 30px;
                            left: 50%;
                            margin-left: -9px;
                        }
                        .clock .h3 {
                            top: 140px;
                            right: 30px;
                        }
                        .clock .h6 {
                            bottom: 30px;
                            left: 50%;
                            margin-left: -5px;
                        }
                        .clock .h9 {
                            left: 32px;
                            top: 140px;
                        }
                        .clock .diallines {
                            position: absolute;
                            z-index: 2;
                            width: 2px;
                            height: 15px;
                            background: #666;
                            left: 50%;
                            margin-left: -1px;
                            transform-origin: 50% 150px;
                        }
                        .clock .diallines:nth-of-type(5n) {
                            position: absolute;
                            z-index: 2;
                            width: 4px;
                            height: 25px;
                            background: #666;
                            left: 50%;
                            margin-left: -1px;
                            transform-origin: 50% 150px;
                        }
                        .clock .info {
                            position: absolute;
                            width: 120px;
                            height: 20px;
                            border-radius: 7px;
                            background: #ccc;
                            text-align: center;
                            line-height: 20px;
                            color: #000;
                            font-size: 11px;
                            top: 200px;
                            left: 50%;
                            margin-left: -60px;
                            font-family: "Poiret One";
                            font-weight: 700;
                            z-index: 3;
                            letter-spacing: 3px;
                            margin-left: -60px;
                            left: 50%;
                        }
                        .clock .date {
                            top: 80px;
                        }
                        .clock .day {
                            top: 200px;
                        }
                    </style>
                    <div class="clock">
                        <div>
                            <div class="info date"></div>
                            <div class="info day"></div>
                        </div>
                        <div class="dot"></div>
                        <div>
                            <div class="hour-hand"></div>
                            <div class="minute-hand"></div>
                            <div class="second-hand"></div>
                        </div>
                        <div>
                            <span class="h3">3</span>
                            <span class="h6">6</span>
                            <span class="h9">9</span>
                            <span class="h12">12</span>
                        </div>
                        <div class="diallines"></div>
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


    </div>
</div>
@include('admin.layout.footer')
</div>
<script>
    var dialLines = document.getElementsByClassName('diallines');
    var clockEl = document.getElementsByClassName('clock')[0];

    for (var i = 1; i < 60; i++) {
        clockEl.innerHTML += "<div class='diallines'></div>";
        dialLines[i].style.transform = "rotate(" + 6 * i + "deg)";
    }

    function clock() {
        var weekday = [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ],
            d = new Date(),
            h = d.getHours(),
            m = d.getMinutes(),
            s = d.getSeconds(),
            date = d.getDate(),
            month = d.getMonth() + 1,
            year = d.getFullYear(),

            hDeg = h * 30 + m * (360 / 720),
            mDeg = m * 6 + s * (360 / 3600),
            sDeg = s * 6,

            hEl = document.querySelector('.hour-hand'),
            mEl = document.querySelector('.minute-hand'),
            sEl = document.querySelector('.second-hand'),
            dateEl = document.querySelector('.date'),
            dayEl = document.querySelector('.day');

        var day = weekday[d.getDay()];

        if (month < 9) {
            month = "0" + month;
        }

        hEl.style.transform = "rotate(" + hDeg + "deg)";
        mEl.style.transform = "rotate(" + mDeg + "deg)";
        sEl.style.transform = "rotate(" + sDeg + "deg)";
        dateEl.innerHTML = date + "/" + month + "/" + year;
        dayEl.innerHTML = day;
    }
    setInterval("clock()", 100);
</script>
@endsection

