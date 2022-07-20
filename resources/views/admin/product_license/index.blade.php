@extends('admin.layout.master')
@section('title', 'Product License')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Tools</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Product License</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Product License</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('product-license.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr class="text-center">
                                            <th style="width:35px">SN</th>
                                            <th>License Name</th>
                                            <th>Information</th>
                                            <th class="no-sort" style="width:80px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($licenseCats as $licenseCat)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $licenseCat->name }}</td>
                                            <td>{{ $licenseCat->info }}</td>
                                            <td class="text-center"><a href="{{route('product-license.show', $licenseCat->id)}}">Show</a></td>
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

