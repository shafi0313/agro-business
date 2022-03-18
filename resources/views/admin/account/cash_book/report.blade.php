@extends('admin.layout.master')
@section('title', 'Cash Book')
@section('content')
@php $p = 'account'; $sm='cashBook'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Cash Book</li>
                </ul>
            </div>
            <link rel="stylesheet" href="{{ asset('backend/day/assets/css/normalize.css') }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Cash Book</h4>
                                <button type="button" class="btn btn-success btn-sm ml-auto " id="p" onclick="printDiv('printArea')"><i class="fas fa-print"></i> Print</button>
                                <button type="button" class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#exampleModal">
                                    Add Cash Previous
                                  </button>
                            </div>
                        </div>
                        <div class="card-body" id="printArea">
                            @php $pageTitle='Cash Book Report' @endphp
                            @include('admin.include.print_page_heading')
                            <div class="page-number"></div>
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-hover" >
                                    <thead class="bg-secondary thw text-center">
                                        <tr>
                                            <th style="width:35px" rowspan="2">SL</th>
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">Particulars</th>
                                            <th rowspan="2">Bank Name</th>
                                            <th rowspan="2">Cheque/DS No</th>
                                            <th colspan="2" class="text-center">Cash</th>
                                            <th colspan="2" class="text-center">Bank</th>
                                            <th rowspan="2">Balance</th>
                                        </tr>
                                        <tr>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $openingDate = Carbon\carbon::parse($form_date)->subDay(); @endphp
                                        <tr>
                                            <th colspan="6">Opening Balance. &nbsp; Until {{ Carbon\carbon::parse($openingDate)->format('d/m/Y') }}</th>
                                            <td style="font-weight: bold;text-align:right">{{ Number_format($cashOpening,2) }}</td>
                                            <td></td>
                                            <td style="font-weight: bold;text-align:right">{{ Number_format($bankOpening,2) }}</td>
                                            <td style="font-weight: bold;text-align:right">{{ Number_format($cashOpening + $bankOpening,2) }}</td>
                                        </tr>
                                        @php $x=1; $balance=0; $expBalance=0; @endphp
                                        @php $openingCal = $cashOpening + $bankOpening; @endphp
                                        @foreach($accounts as $key => $account)
                                        <tr>
                                            <td class="text-center">{{ $x++ }}</td>
                                            <td>{{ bdDate($account->date) }}</td>
                                            <td>{{ $account->note }}</td>

                                            @if ($account->trn_type==1 && $account->type==1)
                                                <td>Cash Withdraw</td>
                                            @elseif($account->type==2)
                                                <td>{{ $account->userBank->bank->name }}</td>
                                            @elseif($account->trn_type==2 && $account->type==1)
                                                <td>Cash Deposit</td>
                                            @elseif($account->trn_type==3 && $account->type==1)
                                                <td>Cash Previous</td>
                                            @endif

                                            <td>{{ $account->m_r_no }}</td>
                                            @if ($account->type == 1)
                                                <td class="text-right">{{ number_format($account->debit,2) }}</td>
                                                <td class="text-right">{{ number_format($account->credit,2) }}</td>
                                            @else
                                                <td class="text-right">0</td>
                                                <td class="text-right">0</td>
                                            @endif

                                            @if ($account->type == 2)
                                                <td class="text-right">{{ number_format($account->debit,2) }}</td>
                                                <td class="text-right">{{ number_format($account->credit,2) }}</td>
                                            @else
                                                <td class="text-right">0</td>
                                                <td class="text-right">0</td>
                                            @endif

                                            @php $b = $account->credit - $account->debit; @endphp
                                            <td class="text-right" style="font-weight: bold">{{ number_format($openingCal+$balance += $b,2) }}</td>
                                        </tr>
                                        @endforeach

                                        @php $officeExpDebit = $officeExpCredit = 0; @endphp
                                        @foreach ($OfficeExpenses->groupBy(['exp_type']) as $OfficeExpense)
                                        @php $exp = $OfficeExpense->first(); @endphp
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            @isset($exp->exp_type)
                                            <td colspan="4">{{ $exp->officeExpMainCat->name }}</td>
                                            @else
                                            <td colspan="4"></td>
                                            @endisset

                                            @if ($exp->type == 1)
                                                @if($OfficeExpense->sum('debit') != null || $OfficeExpense != 0))
                                                    @php $officeExpDebit = $OfficeExpense->sum('debit') @endphp
                                                @else
                                                    @php $officeExpDebit = 0; @endphp
                                                @endif

                                                @if($OfficeExpense->sum('credit') != null)
                                                    @php $officeExpCredit = $OfficeExpense->sum('credit') @endphp
                                                @else
                                                    @php $officeExpCredit = 0; @endphp
                                                @endif

                                                <td class="text-right">{{ number_format($officeExpDebit,2) }}</td>
                                                <td class="text-right">{{ number_format($officeExpCredit,2) }}</td>
                                            @else
                                                <td class="text-right">0</td>
                                                <td class="text-right">0</td>
                                            @endif

                                            @if ($exp->type == 2)
                                                <td class="text-right">{{ number_format($OfficeExpense->sum('debit'),2) }}</td>
                                                <td class="text-right">{{ number_format($OfficeExpense->sum('credit'),2) }}</td>
                                            @else
                                                <td class="text-right">0</td>
                                                <td class="text-right">0</td>
                                            @endif
                                            @php $expBl = $OfficeExpense->sum('credit') - $OfficeExpense->sum('debit') @endphp
                                            <td style="font-weight: bold;text-align:right">{{ number_format($openingCal + $balance + $expBalance+=$expBl,2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tr style="text-align:right; font-weight: bold;">
                                        <td colspan="5">Total:</td>
                                        <td>{{ number_format($accounts->where('type', 1)->sum('debit') + abs($officeExpCash),2) }}</td>
                                        <td>{{ number_format($accounts->where('type', 1)->sum('credit') + abs($cashOpening),2) }}</td>
                                        <td>{{ number_format($accounts->where('type', 2)->sum('debit') + abs($officeExpBank),2) }}</td>
                                        <td>{{ number_format($accounts->where('type', 2)->sum('credit') + abs($bankOpening),2) }}</td>
                                        <td>{{ number_format(($openingCal+$accountsTotalCredit+$officeExpDebit) - ($accountsTotalDebit+$officeExpCredit),2) }}</td>
                                    </tr>
                                    <tr style="text-align:right; font-weight: bold;">
                                        <td colspan="5">Closing Balance:</td>
                                        <td colspan="2">{{ number_format($accounts->where('type', 1)->sum('credit') + $cashOpening - ($accounts->where('type', 1)->sum('debit') + abs($officeExpCash)),2) }}</td>
                                        <td colspan="2">{{ number_format($accounts->where('type', 2)->sum('credit') + $bankOpening - ($accounts->where('type', 2)->sum('debit')+abs($officeExpBank)),2) }}</td>
                                        <td>{{ number_format($openingCal+$accountsTotalCredit - $accountsTotalDebit,2) }}</td>
                                    </tr>
                                </table>
                                @include('admin.include.footer_signature2')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add/Edit Previous</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('cashBook.cashPreStore')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="credit">Credit <span class="t_r">*</span></label>
                        <input type="text" name="credit" class="form-control @error('credit') is-invalid @enderror" required>
                        @error('credit')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="date">Date <span class="t_r">*</span></label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@push('custom_scripts')
@include('admin.printJS');
@endpush
@endsection

