@extends('admin.layout.master')
@section('title', ucfirst($role->name).' '.__('app.manage').' '.__('app.permissions'))
@section('content')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">@lang('role.role')</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
                                @if (user()->id == 1)
                                    <a href="{{route('admin.permission.index')}}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i>@lang('app.manage') @lang('role.permissions')</a>
                                    </a>
                                    @endif
                                    @can('role-add')
                                    <a data-toggle="modal" data-target="#createModal" class="btn btn-primary btn-round text-light" style="min-width: 200px">
                                        <i class="fa fa-plus"></i> @lang('app.add') @lang('role.role')
                                    </a>
                                    @endcan
                            </div>
                        </div>
                        <div class="card-body justify-content-center">
                                <div class="row">
                                    <div class="col-sm-4 mx-auto">
                                        <p>@lang('role.switch-role')</p>
                                        <div>
                                            <select class="form-control" onchange="location = $(this).find(':selected').data('route')">
                                                @foreach ($roles as $tmp_role)
                                                <option value="{{ $tmp_role->id }}" @if ($tmp_role->id == $role->id) selected @endif
                                                    data-route="{{route('admin.role.show',$tmp_role->id)}}">{{
                                                    ucfirst($tmp_role->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form method="POST" action="{{route('admin.role.permission',$role->id)}}">
                                            @csrf
                                            <div class="form-row py-3">
                                                <div class="col-sm-8 mx-auto">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        {{__('app.update')}}
                                                        {{__('app.permission')}}
                                                    </button>
                                                </div>
                                            </div>
                                            {{--! Dashboard --}}
                                            <div class="form-row my-5">
                                                <div class="col-sm-3">
                                                    <label for="title">@lang('nav.dashboard') @lang('app.moderation')</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p>@lang('role.do-you', ['plugin'=> __('nav.dashboard')])</p>
                                                    <div>
                                                        <input type="radio" value="access-dashboard" class="flat-red " name="permissions[]"
                                                            id="access-dashbiar" @if($permissions['access-dashboard']==1) checked @endif>
                                                        <label class="chk-label-margin mx-1" for="access-dashbiar">
                                                            @lang('app.yes')
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="radio" class="flat-red " name="permissions[]" id="no-access"
                                                            @if($permissions['access-dashboard']==0) checked @endif>
                                                        <label class="chk-label-margin mx-1" for="no-access">
                                                            @lang('app.no')
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--! Roles --}}
                                            @include('roles.permissions.roles')
                                            {{--! Permissions --}}
                                            @include('roles.permissions.permissions')
                                            {{--! activity --}}
                                            @include('roles.permissions.activity')
                                            {{--! setting --}}
                                            @include('roles.permissions.setting')
                                            {{--! employee --}}
                                            @include('roles.permissions.employee')
                                            {{--! about --}}
                                            @include('roles.permissions.about')
                                            {{--! slider --}}
                                            @include('roles.permissions.slider')
                                            {{--! Pack Size --}}
                                            @include('roles.permissions.pack_size')
                                            {{--! Bank List --}}
                                            @include('roles.permissions.bank_list')
                                            {{--! Employee Category --}}
                                            @include('roles.permissions.employee_category')
                                            {{--! Product Category --}}
                                            @include('roles.permissions.product_category')
                                            {{--! License Category --}}
                                            @include('roles.permissions.license_category')
                                            {{--! Product License --}}
                                            @include('roles.permissions.product_license')
                                            {{--! User bank account --}}
                                            @include('roles.permissions.user_bank_account')
                                            {{--! Office Expense Category --}}
                                            @include('roles.permissions.office_expense_category')
                                            {{--! Office Income Category --}}
                                            @include('roles.permissions.office_income_category')
                                            {{--! Customer --}}
                                            @include('roles.permissions.customer')
                                            {{--! Supplier --}}
                                            @include('roles.permissions.supplier')
                                            {{--! Store --}}
                                            @include('roles.permissions.store')
                                            {{--! factory --}}
                                            @include('roles.permissions.factory')
                                            {{--! collection --}}
                                            @include('roles.permissions.collection')
                                            {{--! payment --}}
                                            @include('roles.permissions.payment')
                                            {{--! deposit --}}
                                            @include('roles.permissions.deposit')
                                            {{--! withdraw --}}
                                            @include('roles.permissions.withdraw')
                                            {{--! expense --}}
                                            @include('roles.permissions.expense')
                                            {{--! expense-report --}}
                                            @include('roles.permissions.expense_report')
                                            {{--! income --}}
                                            @include('roles.permissions.income')
                                            {{--! income-report --}}
                                            @include('roles.permissions.income_report')
                                            {{--! cashbook --}}
                                            @include('roles.permissions.cashbook')
                                            {{--! author-ledger-book --}}
                                            @include('roles.permissions.author_edger_book')
                                            {{--! main_account --}}
                                            @include('roles.permissions.main_account')
                                            {{--! bank-statement --}}
                                            @include('roles.permissions.bank_statement')
                                            {{--! bulk_name --}}
                                            @include('roles.permissions.bulk_name')
                                            {{--! bulk-purchase --}}
                                            @include('roles.permissions.bulk_purchase')
                                            {{--! bulk-sales --}}
                                            @include('roles.permissions.bulk_sales')
                                            {{--! bulk-stock --}}
                                            @include('roles.permissions.bulk_stock')
                                            {{--! send-to-repack-unit --}}
                                            @include('roles.permissions.send_to_repack_unit')
                                            {{--! purchase-ledger-book --}}
                                            @include('roles.permissions.purchase_ledger_book')
                                            {{--! bulk-report --}}
                                            @include('roles.permissions.bulk_report')
                                            {{--! repack-unit-qa/qc --}}
                                            @include('roles.permissions.repack_unit_qa_qc')
                                            {{--! repack-unit-production --}}
                                            @include('roles.permissions.repack_unit_production')



                                            <div class="form-row py-3">
                                                <div class="col-sm-8 mx-auto">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        {{__('app.update')}}
                                                        {{__('app.permission')}}
                                                    </button>
                                                </div>
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
    <!-- Datatables -->
    @include('admin.include.data_table_js')
@endpush
@endsection






