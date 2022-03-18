@extends('admin.layout.master')
@section('title', 'Bank')
@section('content')
@php $p='tools'; $sm="userBank"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Bank</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Bank</h4>
                                <a class="btn btn-primary btn-round ml-auto" href="{{ route('user-bank-ac.create') }}">
                                    <i class="fa fa-plus"></i>
                                    Add New Bank
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>User name</th>
                                            <th>Bank name</th>
                                            <th>Account Name.</th>
                                            <th>Account No.</th>
                                            <th>Branch Name</th>
                                            <th>Address</th>
                                            <th class="no-sort" style="width:80px">Action</th>
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
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach($userBankAcs as $userBankAc)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $userBankAc->user->name }}</td>
                                            <td>{{ $userBankAc->bank->name }}</td>
                                            <td>{{ $userBankAc->ac_name }}</td>
                                            <td>{{ $userBankAc->ac_no }}</td>
                                            <td>{{ $userBankAc->branch }}</td>
                                            <td>{{ $userBankAc->address }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('user-bank-ac.edit', $userBankAc->id) }}" title="Edit" class="btn btn-link btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user-bank-ac.destroy', $userBankAc->id) }}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
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

