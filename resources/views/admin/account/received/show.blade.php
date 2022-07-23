@extends('admin.layout.master')
@section('title', 'Collection')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Office</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Accounts</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Collection</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Collection</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th style="width:35px">SL</th>
                                            <th>Payment By</th>
                                            <th>Note</th>
                                            <th>MR NO</th>
                                            <th>MR Date</th>
                                            <th>Amount</th>
                                            <th class="no-sort text-center" style="width:80px">Action</th>
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
                                        @foreach($accounts as $account)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ $account->type==1?'Cash':'Bank' }}</td>
                                            <td>{{ $account->note }}</td>
                                            <td>{{ $account->m_r_no }}</td>
                                            <td>{{ bdDate($account->m_r_date) }}</td>
                                            <td>{{ $account->credit }}</td>
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <form action="{{ route('account-received.destroy', is_null($account->tran_id)?0:$account->tran_id) }}" style="display: initial;" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="Delete" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
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

