@extends('admin.layout.master')
@section('title', 'Sales of Cash Invoice')
@section('content')
@php $p='sales'; $sm='salesCash' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Sales</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('sales-invoice-cash.index')}}">Sales</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">All Invoice List</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h2><strong>Customer Name: </strong>{{$customerInfo->customer->business_name}}</h2>
                                    <h2><strong>Proprietor: </strong>{{$customerInfo->customer->name}}</h2>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th style="width:40px">SL</th>
                                            <th>Challan No</th>
                                            <th>Invoice No</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th class="no-sort" style="width:105px">Print</th>
                                            {{-- <th class="no-sort" style="width:40px">Report</th> --}}
                                            <th class="no-sort" style="width:121px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($customerInvoices as $customerInvoice)
                                        @php $invoice = $customerInvoice->first();@endphp
                                        <tr class="text-center {{$invoice->inv_cancel!=0?'text-danger':''}}">

                                            @if ($invoice->inv_cancel==1)
                                                @php $inv_cancel = "text-center far fa-times-circle" @endphp
                                            @elseif ($invoice->inv_cancel==2)
                                                @php $inv_cancel = "text-center far fa-question-circle" @endphp
                                            @else
                                                @php $inv_cancel = 'text-center '  @endphp
                                            @endif

                                            <td>{{ $x++ }}</td>
                                            <td>{{ $invoice->challan_no }}</td>
                                            <td class="{{$inv_cancel}}">{{ $invoice->invoice_no }}</td>
                                            <td>{{ $invoice->type==1?'Cash':'Credit' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                            <td class="text-right">{{ number_format($customerInvoice->sum('amt'),2) }}</td>
                                            <td>
                                                <a href="{{ route('salesInvoiceCash.printInvoice', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Invoice</a>
                                                <span>|</span>
                                                <a href="{{ route('salesInvoiceCash.printChallan', [$invoice->customer_id, $invoice->invoice_no]) }}" target="_blank">Challan</a>
                                            </td>
                                            {{-- <td>
                                                <a href="{{ route('salesInvoiceCash.show', [$invoice->customer_id, $invoice->invoice_no]) }}">Show</a>
                                            </td> --}}
                                            <td>
                                                {{-- <form action="{{ route('salesInvoiceCash.destroy', $invoice->invoice_no) }}" style="display: initial;" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="quantity[]" value="{{ $invoice->quantity }}">
                                                    <input type="hidden" name="bonus[]" value="{{ $invoice->bonus }}">
                                                    <input type="hidden" name="product_id[]" value="{{ $invoice->product_id }}">
                                                    <input type="hidden" name="size[]" value="{{ $invoice->size }}">
                                                    @method('DELETE')
                                                    <button title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form> --}}
                                                <a href="{{ route('salesInvoiceCash.edit', [$invoice->customer_id,$invoice->challan_no]) }}" onclick="return confirm('Are you sure?')">Reinvoice</a>
                                                <span>|</span>
                                                <a href="{{ route('salesInvoiceCash.cancelInv', $invoice->challan_no) }}" class="text-danger" onclick="return confirm('Are you sure?')">Cancel</a>

                                            </td>
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
@include('admin.include.data_table_js')
@endpush
@endsection

