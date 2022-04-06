@extends('admin.layout.master')
@section('title', 'Production')
@section('content')
@php $p='factory'; $sm='bulkProduction'; $ssm='repackUnitShow' @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Production</li>
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
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="table table-bordered table-striped table-hover" >
                                    <thead class="text-center bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Group Name</th>
                                            <th>Weight</th>
                                            <th>Quantity</th>
                                            <th>Net Weight</th>
                                            <th>Use Weight</th>
                                            <th>Tracking</th>
                                            <th>Challan No</th>
                                            <th>Date</th>
                                            <th class="no-sort" style="max-width: 80px">Action</th>
                                            <th class="no-sort" style="max-width: 85px">Send</th>
                                            <th class="no-sort">Show</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x= $showInvoices->count(); @endphp
                                        @foreach($showInvoices as $showInvoice)
                                        <tr class="{{ ($showInvoice->tracking=='2')?'text-primary':'' }}">
                                            <td class="text-center">{{ $x-- }}</td>
                                            <td>{{ $showInvoice->product->generic }}</td>
                                            <td class="text-center">{{ $showInvoice->packSize->size }}</td>
                                            <td class="text-center">{{ $showInvoice->quantity }}</td>
                                            <td class="text-center">{{ $showInvoice->net_weight }}</td>
                                            <td class="text-center">{{ $showInvoice->use_weight }}</td>
                                            <td class="text-center">{{ ($showInvoice->tracking =='1')?'On Going':(($showInvoice->tracking =='2')?'Complete':'') }}</td>
                                            <td class="text-center">{{ $showInvoice->challan_no }}</td>
                                            <td class="text-center">{{ bdDate($showInvoice->invoice_date) }}</td>
                                            <td class="text-center d-flex">
                                                <form action="{{ route('bulkTrackingUpdateOnGoing.update', $showInvoice->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tracking" value="1">
                                                    <button class="btn btn-sm btn-secondary"  title="On Going" type="submit"  {{ ($showInvoice->tracking=='2')?'disabled':'' }}><i class="fas fa-cogs"></i></button>
                                                </form>

                                                <form action="{{ route('bulkTrackingUpdateComplete.update', $showInvoice->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="tracking" value="2">
                                                    <button class="btn btn-sm btn-primary" title="Complete" type="submit" {{ ($showInvoice->tracking=='2')?'disabled':'' }}><i class="far fa-check-circle"></i></button>
                                                </form>
                                            </td>
                                            <td class="text-center"><a href="{{route('production.create', $showInvoice->id)}}" style="{{ ($showInvoice->tracking=='2')?'display:none':'' }}" >Send to Store</a></td>
                                            <td class="text-center"><a href="{{route('repackingCheck.productionCalShow', $showInvoice->id)}}">Show</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @php $check=''; @endphp
                                {{-- For Accpet or reject --}}
                                <form action="{{route('repack-check.store')}}" method="post">
                                    @foreach($showInvoices as $showInvoice)
                                        @csrf
                                        <input type="hidden" name="id[]" value="{{ $showInvoice->id }}">
                                        <input type="hidden" name="product_id[]" value="{{ $showInvoice->product->id }}">
                                        <input type="hidden" name="size[]" value="{{ $showInvoice->size }}">
                                        <input type="hidden" name="quantity[]" value="{{ $showInvoice->quantity }}">
                                        <input type="hidden" name="net_weight[]" value="{{ $showInvoice->net_weight }}">
                                        <input type="hidden" name="amt[]" value="{{ $showInvoice->amt }}">
                                        @php $check = $showInvoice->status; @endphp
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
@include('admin.include.printJS')
@endpush
@endsection

