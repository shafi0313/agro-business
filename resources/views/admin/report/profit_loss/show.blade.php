@extends('admin.layout.master')
@section('title', 'Bulk Sales Report')
@section('content')
    @php
        $p = 'factory';
        $ssm = 'bulkShow';
        $sm = 'bulkReport';
    @endphp
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}" title="Dashboard"><i
                                    class="flaticon-home"></i></a></li>
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
                                                <input type="month" name="start_date" class="form-control" id="start_date">
                                                </div>

                                                <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                                <div class="col-sm-4">
                                                <input type="month" name="end_date" class="form-control" id="end_date">
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

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                <h4 class="card-title">Profit Loss Report</h4>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-bordered table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Month, Year</th>
                                                <th>Sales</th>
                                                {{-- <th>Previous</th> --}}
                                                <th>Cost of Goods Sold</th>
                                                <th>Gross Profit</th>
                                                <th>Expenses</th>
                                                <th>Net Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profitLosses->groupBy('dateGroup') as $profitLos)
                                                @php
                                                    $profitLoss = $profitLos->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ @$x += 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($profitLoss->date)->format('M Y') }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($sales = $profitLos->sum('credit'), 2) }}</td>
                                                    {{-- <td class="text-right">{{ number_format($sales = $profitLos->where('trn_type','!=',3)->sum('credit'),2) }}</td> --}}
                                                    {{-- <td class="text-right">{{ number_format($previous = $profitLos->where('trn_type',3)->sum('credit'),2) }}</td> --}}
                                                    <td class="text-right">
                                                        {{ number_format($purchase = $profitLos->whereNull('exp_type')->sum('debit'), 2) }}
                                                    </td>
                                                    <td class="text-right">{{ number_format($sales - $purchase, 2) }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($expense = $profitLos->whereNotNull('exp_type')->sum('debit'), 2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($sales - ($purchase + $expense), 2) }}</td>
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
    <script>
        $('#start_date').val('{{ $start_date }}');
        $('#end_date').val('{{ $end_date }}');
    </script>
    @endpush
@endsection
