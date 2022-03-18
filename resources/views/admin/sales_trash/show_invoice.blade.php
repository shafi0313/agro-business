@extends('admin.layout.master')
@section('title', 'Invoice')
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
                    <li class="nav-item active">Invoice</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h2><strong>Customer Name: </strong>{{$customerInfo->customer->name}}</h2>
                                    <p>
                                        <span><strong>Invoice No: </strong>{{$customerInfo->invoice_no}}</span><br>
                                        <span><strong>Invoice Date: </strong>{{ \Carbon\Carbon::parse($customerInfo->invoice_date)->format('d/m/Y') }}</span><br>
                                        <span><strong>Customer Phone: </strong>{{$customerInfo->customer->phone}}</span><br>
                                        <span><strong>Customer Address: </strong>{{$customerInfo->customer->address}}</span><br>
                                    </p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Products</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Bonus</th>
                                            <th>Rate Per QTY</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($showInvoices as $showInvoice)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $showInvoice->product->name }}</td>
                                            <td class="text-center">{{ $showInvoice->packSize->size }}</td>
                                            <td class="text-center">{{ $showInvoice->quantity }}</td>
                                            <td class="text-center">{{ $showInvoice->bonus }}</td>
                                            <td class="text-right">{{ number_format($showInvoice->rate_per_qty,2) }}</td>
                                            <td class="text-center">{{ $showInvoice->discount }}%</td>
                                            <td class="text-right">{{ number_format($showInvoice->amt,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <style>
                                        tfoot tr td{text-align: center;font-weight: bold}
                                    </style>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="3">Total: </td>
                                            <td>{{ $showInvoices->sum('quantity') }}</td>
                                            <td>{{ $showInvoices->sum('bonus') }}</td>
                                            <td class="text-right">{{ number_format($showInvoices->sum('rate_per_qty'),2) }}</td>
                                            <td>{{ $showInvoices->sum('discount') }} %</td>
                                            <td class="text-right">{{ number_format($showInvoices->sum('amt'),2) }}</td>
                                        </tr>
                                    </tfoot>
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
            "pageLength": 10,
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

