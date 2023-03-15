@extends('admin.layout.master')
@section('title', 'Today Report')
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}" title="Dashboard"><i
                                    class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item active">Today Report</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Product Sales</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Product Name</th>
                                                <th>Pack Size</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $sal)
                                                @php
                                                    $sale = $sal->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ @$x += 1 }}</td>
                                                    <td>{{ $sale->product->name }}</td>
                                                    <td class="text-center">{{ $sale->packSize->size }}</td>
                                                    <td class="text-center">{{ $sal->sum('quantity') }}</td>
                                                    <td class="text-right">{{ number_format($sal->sum('amt'), 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Product Purchase</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="purchase_table" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Product Name</th>
                                                <th>Pack Size</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchases as $purchas)
                                                @php
                                                    $purchase = $purchas->first();
                                                @endphp
                                                <tr>
                                                    <td>{{ @$x1 += 1 }}</td>
                                                    <td>{{ $purchase->product->name }}</td>
                                                    <td class="text-center">{{ $purchase->packSize->size }}</td>
                                                    <td class="text-center">{{ $purchas->sum('quantity') }}</td>
                                                    <td class="text-right">{{ number_format($purchas->sum('amt'), 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Pay to Supplier</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="payment_table" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Supplier</th>
                                                <th>Payment Type</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts->where('exp_type','')->whereIn('trn_type',[1]) as $account)
                                                <tr>
                                                    <td>{{ @$x2 += 1 }}</td>
                                                    <td>{{ $account->users->business_name }}</td>
                                                    <td>{{ $account->pay_type==1?'Cash':'bank' }}</td>
                                                    <td class="text-right">{{ number_format($account->debit, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <th class="text-right" colspan="3">Total</th>
                                            <td class="text-right">{{ number_format($accounts->where('exp_type','')->whereIn('trn_type',[1])->sum('debit'),2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Receive from Customer</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="receive_table" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Customer</th>
                                                <th>Payment Type</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts->where('exp_type','')->whereIn('trn_type',[2,3]) as $account)
                                                <tr>
                                                    <td>{{ @$x3 += 1 }}</td>
                                                    <td>{{ $account->users->business_name }}</td>
                                                    <td>{{ $account->pay_type==1?'Cash':'bank' }}</td>
                                                    <td class="text-right">{{ number_format($account->credit, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <th class="text-right" colspan="3">Total</th>
                                            <td class="text-right">{{ number_format($accounts->where('exp_type','')->whereIn('trn_type',[2,3])->sum('credit'),2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Other Income</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="other_income_table" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Income Name</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts->whereNotNull('exp_type')->where('credit','!=', 0) as $account)
                                                <tr>
                                                    <td>{{ @$x4 += 1 }}</td>
                                                    <td>{{ $account->officeExp->name }}</td>
                                                    <td>{{ $account->pay_type==1?'Cash':'bank' }}</td>
                                                    <td class="text-right">{{ number_format($account->credit, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <th class="text-right" colspan="3">Total</th>
                                            <td class="text-right">{{ number_format($accounts->whereNotNull('exp_type')->sum('credit'),2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Expense</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="other_income_table" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Expense Name</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts->whereNotNull('exp_type')->where('debit','!=', 0) as $account)
                                                <tr>
                                                    <td>{{ @$x5 += 1 }}</td>
                                                    <td>{{ $account->officeExp->name }}</td>
                                                    <td>{{ $account->pay_type==1?'Cash':'bank' }}</td>
                                                    <td class="text-right">{{ number_format($account->debit, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <th class="text-right" colspan="3">Total</th>
                                            <td class="text-right">{{ number_format($accounts->whereNotNull('exp_type')->sum('debit'),2) }}</td>
                                        </tr>
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
        <script>
            $(document).ready(function() {
                $('#basic-datatables').DataTable({});

                $('#purchase_table, #other_income_table').DataTable({
                    // "pageLength": 50,
                    "lengthMenu": [
                        [50, 100, -1],
                        [50, 100, "All"]
                    ],
                    "order": [],
                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-control form-control-sm"><option value=""></option></select>'
                                    )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });
                        });
                    }
                });

                // Add Row
                $('#add-row').DataTable({
                    "pageLength": 5,
                });

                var action =
                    '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
            });

            $(document).ready(function() {
                $('#basic-datatables').DataTable({});
                $('#payment_table').DataTable({
                    // "pageLength": 50,
                    "lengthMenu": [
                        [50, 100, -1],
                        [50, 100, "All"]
                    ],
                    "order": [],
                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-control form-control-sm"><option value=""></option></select>'
                                    )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });
                        });
                    }
                });

                // Add Row
                $('#add-row').DataTable({
                    "pageLength": 5,
                });

                var action =
                    '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
            });

            $(document).ready(function() {
                $('#basic-datatables').DataTable({});
                $('#receive_table').DataTable({
                    // "pageLength": 50,
                    "lengthMenu": [
                        [50, 100, -1],
                        [50, 100, "All"]
                    ],
                    "order": [],
                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-control form-control-sm"><option value=""></option></select>'
                                    )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });
                        });
                    }
                });

                // Add Row
                $('#add-row').DataTable({
                    "pageLength": 5,
                });

                var action =
                    '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
            });
        </script>
    @endpush
@endsection
