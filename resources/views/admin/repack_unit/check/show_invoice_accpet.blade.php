@extends('admin.layout.master')
@section('title', 'Challan Check')
@section('content')
@php $p='factory'; $sm='qaqc'; $ssm='repackUnitShow' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Challan</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {{-- Customer Information --}}
                                    {{-- @include('admin.company_info.customer_info') --}}
                                    <span><strong>Challan No: </strong>{{$customerInfo->challan_no}}</span><br>
                                    <span><strong>Date: </strong>{{ \Carbon\Carbon::parse($customerInfo->invoice_date)->format('d/m/Y') }}</span><br>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="text-center bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Group Name</th>
                                            <th>Weight</th>
                                            <th>Quantity</th>
                                            <th>Net Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($showInvoices as $showInvoice)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $showInvoice->product->generic }}</td>
                                            <td class="text-center">{{ $showInvoice->packSize->size }}</td>
                                            <td class="text-center">{{ $showInvoice->quantity }}</td>
                                            <td class="text-center">{{ $showInvoice->net_weight }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- For Accpet or reject --}}
                                <form action="{{route('repack-check.store')}}" method="post">
                                    @foreach($showInvoices as $showInvoice)
                                        @csrf
                                        <input type="hidden" name="id[]" value="{{ $showInvoice->id }}">
                                        <input type="hidden" name="challan_no" value="{{ $showInvoice->challan_no }}">
                                        <input type="hidden" name="product_id[]" value="{{ $showInvoice->product->id }}">
                                        <input type="hidden" name="size[]" value="{{ $showInvoice->size }}">
                                        <input type="hidden" name="quantity[]" value="{{ $showInvoice->quantity }}">
                                        <input type="hidden" name="net_weight[]" value="{{ $showInvoice->net_weight }}">
                                        <input type="hidden" name="amt[]" value="{{ $showInvoice->amt }}">
                                        @php
                                            $check = $showInvoice->status;
                                        @endphp
                                    @endforeach
                                    <div class="text-center" style="display: {{($check!='0')?'none':''}}">
                                        <input type="submit" value="Reject" name="r" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <input type="submit" value="Accept" name="a" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')">
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

@push('custom_scripts')
@include('admin.include.data_table_js')
@endpush
@endsection

