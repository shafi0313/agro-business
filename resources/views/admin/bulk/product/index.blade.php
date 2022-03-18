@extends('admin.layout.master')
@section('title', 'Bulk')
@section('content')
@php $p='factory'; $sm="balkName"; $ssm = 'bulkShow'  @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Bulk</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Bulk</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('raw-material.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Bulk
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SN</th>
                                            <th>Group Name</th>
                                            <th>Indications</th>
                                            <th>Pack Size</th>
                                            <th>Purchase</th>
                                            <th class="no-sort" style="width:100px;text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($porducts as $porduct)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $porduct->generic }}</td>
                                            <td>{!! \Illuminate\Support\Str::limit($porduct->indications, 20, '...') !!}</td>
                                            <td class="text-center">{{ $porduct->productPackSize->size }}</td>
                                            <td class="text-right">{{ number_format($porduct->productPackSize->purchase,2) }}</td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <a href="{{ route('raw-material.edit', $porduct->id)}}" data-toggle="tooltip" title="" class="btn btn-link btn-primary" data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('raw-material.destroy', $porduct->id) }}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Delete" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
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

