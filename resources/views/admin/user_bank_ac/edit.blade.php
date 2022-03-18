@extends('admin.layout.master')
@section('title', 'Bank')
@section('content')
@php $p='tools'; $sm="userBank"; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('bank-list.index')}}">Bank</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create Bank</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Edit Bank</h4>
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Launch demo modal
                                  </button> --}}
                                  <a class="btn btn-primary btn-round ml-auto text-light" data-toggle="modal" data-target="#addSize" >
                                    <i class="fa fa-plus"></i>
                                    Add New Bank
                                  </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('user-bank-ac.update', $userBankAc->id)}}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="user_id">Account Holder <span class="t_r">*</span></label>
                                        <select name="user_id" class="form-control" required>
                                            <option value="{{$userBankAc->user_id}}">{{$userBankAc->user->name}}</option>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="bank_id">Bank Name <span class="t_r">*</span></label>
                                        <select name="bank_list_id" class="form-control" required>
                                            <option value="{{$userBankAc->bank_list_id}}">{{$userBankAc->bank->name}}</option>
                                            @foreach ($bankLists as $bankList)
                                            <option value="{{$bankList->id}}">{{$bankList->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="ac_name">Account Name  <span class="t_r">*</span></label>
                                        <input type="text" name="ac_name" class="form-control @error('ac_name') is-invalid @enderror" value="{{ $userBankAc->ac_name }}">
                                        @error('ac_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="ac_no">Account No. <span class="t_r">*</span></label>
                                        <input type="text" name="ac_no" class="form-control @error('ac_no') is-invalid @enderror" value="{{ $userBankAc->ac_no }}">
                                        @error('ac_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="previous">Opening Balance</label>
                                        <input type="text" name="previous" class="form-control @error('previous') is-invalid @enderror">
                                        @error('previous')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="date">Date <span class="t_r">*</span></label>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror">
                                        @error('date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="branch">Branch Name <span class="t_r">*</span></label>
                                        <input type="text" name="branch" class="form-control @error('branch') is-invalid @enderror" value="{{ $userBankAc->branch }}">
                                        @error('branch')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $userBankAc->address }}">
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div align="center" class="m-auto card-action">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    {{-- Page Content End --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->

@push('custom_scripts')

@endpush

@endsection

