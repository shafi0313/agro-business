@extends('admin.layout.master')
@section('title', 'Sales Trush')
@section('content')
@php $p='sales'; $sm='salesTrash' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Trash Invoice</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">All Trash Invoice List</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Invoice No</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th class="no-sort text-center" style="width:70px">Report</th>
                                            {{-- <th class="no-sort text-center" style="width:60px">Restore</th> --}}
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($customerInvoices as $customerInvoice)
                                        <tr>
                                            @php $invoice = $customerInvoice->first();@endphp

                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $invoice->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td>{{ $invoice->customer->name }}</td>
                                            <td>{{ ($invoice->invoice_status=='0')?'Sales Invoice':'Return Invoice' }}</td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('showInvoiceTrush', [$invoice->customer_id,$invoice->invoice_no]) }}">Show</a>
                                                </div>
                                            </td>
                                            {{-- <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('salesInvoiceRestore', $invoice->invoice_no) }} " title="Restore" class="btn btn-link" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash-restore"></i>
                                                    </a>
                                                </div>
                                            </td> --}}
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
<script >
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
        });

        $('#multi-filter-select').DataTable( {
            "lengthMenu": [[20, 25, 50, -1], [25, 50, 100, "All"]],
            // "pageLength": 50,
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                            );

                        column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        // $('#addRowButton').click(function() {
        //     $('#add-row').dataTable().fnAddData([
        //         $("#addName").val(),
        //         $("#addPosition").val(),
        //         $("#addOffice").val(),
        //         action
        //         ]);
        //     $('#addRowModal').modal('hide');

        // });
    });
</script>

@endpush
@endsection

