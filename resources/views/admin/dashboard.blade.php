@extends('admin.layout.master')
@section('title', 'Dashboard')
@section('content')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dashboard.css') }}">
    @php
        $p = 'da';
        $sm = '';
    @endphp
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Welcome: {{ auth()->user()->name }}</h4>
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
                @if (setting('dashboard_report') == 1)
                    @role('admin|account')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="text-center font-weight-bold">@lang('dashboard.todaysAccount')</h2>
                                    </div>
                                    <div class="card-body py-0 my-0">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="card card-primary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.sales')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547; {{ number_format($data['todaysSale'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card card-danger text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.salesReturn')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['todaysSaleReturn'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card card-info text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.collection')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['todaysCollection'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-danger text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.expense')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['todaysExpense'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-primary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.profitLoss')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['todaysProfitLoss'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="text-center font-weight-bold">@lang('dashboard.weekAccount')</h2>
                                    </div>
                                    <div class="card-body py-0 my-0">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="card card-success text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.sales')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisWeekSale'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card card-danger text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.salesReturn')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisWeekSaleReturn'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card card-primary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.collection')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisWeekCollection'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-danger text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.expense')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisWeekExpense'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-primary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.profitLoss')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisWeekProfitLoss'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="text-center font-weight-bold">@lang('dashboard.monthAccount')</h2>
                                    </div>
                                    <div class="card-body py-0 my-0">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="card card-secondary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.sales')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisMonthSale'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card card-danger text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.salesReturn')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format(abs($data['thisMonthSaleReturn']), 2) }}
                                                            </h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card card-primary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.collection')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisMonthCollection'], 2) }}
                                                            </h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-danger text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.expense')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisMonthExpense'], 2) }}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-primary text-center">
                                                    <div class="card-header">
                                                        <div class="card-title">@lang('app.profitLoss')</div>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <div class="mb-1">
                                                            <h1>&#2547;{{ number_format($data['thisMonthProfitLoss'], 2) }}
                                                            </h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endrole
                @endif
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
                                            <a href="{{ route('customer.index') }} ">
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
                                            <a href="{{ route('employee.index') }} ">
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


                <div class="row">
                    <div class="col-md-6">
                        <div class="dash_menu">
                            <ul>
                                <li><a href="{{ route('product.index') }}">Product</a></li>
                                <li><a href="{{ route('stock.bulk.index') }}">Bulk Stock</a></li>
                                <li><a href="{{ route('stock.store.index') }}">Stock</a></li>
                                <li><a href="{{ route('sales-invoice-cash.index') }}">@lang('app.sales')</a></li>
                                <li><a href="{{ route('salesLedgerBook.index') }}">@lang('app.sales') Ledger Book</a></li>
                                <li><a href="{{ route('report.salesAndStock.selectDate') }}">@lang('app.sales') Report</a>
                                </li>
                                <li><a href="{{ route('empReport.user') }}">Employee Report</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
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

                {{-- <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary text-center">
                        <div class="card-header">
                            <div class="card-title">Today's Sale</div>
                            <div class="card-category">{{ bdDate(now()) }}</div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="mb-4 mt-2">
                                <h1>&#2547; {{ number_format($todaysSale,2) }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-secondary text-center">
                        <div class="card-header">
                            <div class="card-title">Today's @lang('app.collection')</div>
                            <div class="card-category">{{ bdDate(now()) }}</div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="mb-4 mt-2">
                                <h1>&#2547; {{ number_format($todaysCollection,2) }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-success text-center">
                        <div class="card-header">
                            <div class="card-title">Today's @lang('app.expense')</div>
                            <div class="card-category">{{ bdDate(now()) }}</div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="mb-4 mt-2">
                                <h1>&#2547; {{ number_format($todaysExpense,2) }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

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
