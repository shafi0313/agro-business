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
                                    {{-- <span><strong>Challan No: </strong>{{$customerInfo->challan_no}}</span><br>
                                    <span><strong>Date: </strong>{{ \Carbon\Carbon::parse($customerInfo->invoice_date)->format('d/m/Y') }}</span><br> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped table-hover" >
                                    <thead class="text-center bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Brand Name</th>
                                            <th>Group Name</th>
                                            <th>Date</th>
                                            <th>Challan No</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Use Weight</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($poductionCals as $poductionCal)
                                        <tr class="text-center">
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{$poductionCal->product->name}}</td>
                                            <td>{{$poductionCal->product->generic}}</td>
                                            <td>{{ \Carbon\Carbon::parse($poductionCal->date)->format('d/m/Y') }}</td>
                                            <td>{{$poductionCal->challan_no}}</td>
                                            <td>{{$poductionCal->packSize->size}}</td>
                                            <td>{{$poductionCal->quantity}}</td>
                                            <td>{{$poductionCal->use_weight}}</td>
                                            <td>
                                                @isset($poductionCal->production_id)
                                                <div class="form-button-action">
                                                    <a href="{{ route('production.productionDelete', $poductionCal->production_id)}}" title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    {{-- <form action="{{ route('company-store.destroy',$user->id)}}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                                @endisset

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

