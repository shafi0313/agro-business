@extends('admin.layout.master')
@section('title', 'payment')
@section('content')
@php $p = 'account'; $sm='payment'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('account-payment.index')}}">payment</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">payment To</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- Page Content Start --}}
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
                            <div class="col-md-12 text-center">
                                <h2>{{ $user->business_name }}</h2>
                                <h2>{{ $user->name }}</h2>
                                <p>
                                    <span>{{ $user->phone }}</span><br>
                                    <span>{{ $user->address }}</span>
                                </p>
                            </div>
                            <form action="{{ route('account-payment.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="supplier_id" value="{{ $user->id }}">
                                <input type="hidden" id="totalCashCredit" value="{{ $totalCashCredit }}">
                                <input type="hidden" id="totalBankCredit">
                                <input type="hidden" id="getTotalBankCredit">
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="date">Date <span class="t_r">*</span></label>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{old('date')}}" placeholder="" required>
                                        @error('date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="account_entry_id">Reference <span class="t_r">*</span></label>
                                        <select name="tmm_so_id" id="" class="form-control" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($tmmSoIds as $tmmSoId)
                                                <option value="{{ $tmmSoId->id }}">{{ $tmmSoId->tmm_so_id }} => {{$tmmSoId->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="account_entry_id">Payment By <span class="t_r">*</span></label>
                                        <select name="payment_by" id="payment_by" class="form-control" required>
                                            <option>Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Bank">Bank</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="form-group col-sm-4 bankListShow" style="display: none">
                                        <label for="account_entry_id">Bank Name <span class="t_r">*</span></label>
                                        <select id="bank" class="form-control" >
                                            <option selected value>Select</option>
                                            @foreach ($bankLists as $bankList)
                                                <option value="{{ $bankList->id }}">{{ $bankList->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4 bankListShow" style="display: none">
                                        <label for="bank_ac_no">Account No <span class="t_r">*</span></label>
                                        <select name="user_bank_ac_id" id="ac_no" class="form-control"></select>
                                    </div>
                                    <div class="form-group col-sm-4 bankListShow" style="display: none">
                                        <label for="cheque_no">Cheque/DS/V No <span class="t_r">*</span></label>
                                        <input name="cheque_no" class="form-control">
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="debit">Amount<span id="amtMsg" class="t_r">*</span></label>
                                        <input type="number" id="amount" name="debit" class="form-control @error('debit') is-invalid @enderror" required>
                                        @error('debit')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label for="note">Particular</label>
                                        <input type="text" name="note" class="form-control @error('note') is-invalid @enderror" value="{{old('note')}}" placeholder="">
                                        @error('note')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="m_r_date">Payment Date</label>
                                        <input type="date" name="m_r_date" class="form-control @error('m_r_date') is-invalid @enderror" value="{{old('m_r_date')}}">
                                        @error('m_r_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="m_r_no">Payment Voucher No.</label>
                                        <input type="number" name="m_r_no" class="form-control @error('m_r_no') is-invalid @enderror" value="{{ App\Models\Account::where('trn_type',1)->max('m_r_no')+1 }}">
                                        @error('m_r_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div align="center" class="mr-auto card-action">
                                    <button type="submit" value="Submit" class="btn btn-success" onclick='return btnClick();'>Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
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

@push('custom_scripts')
<script>
    $(document).ready(function(){
        $("#payment_by").on('change', function(){
            $('#amtMsg').text('');
            $('#ac_no').val(0);
            $('#bank').val(0);
            var pay_method = $(this).val();
            if(pay_method == 'Bank'){
                $(".bankListShow").css('display', 'block');

                // Bank Information
                $('#bank').on('change',function(e) {
                    var bank_id = $(this).val();
                    $.ajax({
                        url:'{{ route("received.bankInfo") }}',
                        type:"get",
                        data: {
                            bank_id: bank_id
                            },
                        success:function (res) {
                            res = $.parseJSON(res);
                            $('#ac_no').html(res.bank);
                        }
                    })
                });

                // Get bank amount for submit check
                $('#ac_no').on('change',function(e) {
                    var ac_no_id = $('#ac_no').val();
                    if(ac_no_id != null && pay_method == 'Bank'){
                        var inputAmt = Number($('#amount').val())
                        $.ajax({
                            url:'{{ route("payment.bankBalance") }}',
                            type:"get",
                            data: {
                                ac_no_id: ac_no_id
                                },
                            success:function (res) {
                                res = $.parseJSON(res);
                                $('#getTotalBankCredit').val(res.amt);
                            }
                        })
                    }
                });

                // Get bank amount for keyup message
                $('#amount').on('keyup',function(e) {
                    var ac_no_id = $('#ac_no').val();
                    if(ac_no_id != null && pay_method == 'Bank'){
                        var inputAmt = Number($('#amount').val())
                        $.ajax({
                            url:'{{ route("payment.bankBalance") }}',
                            type:"get",
                            data: {
                                ac_no_id: ac_no_id
                                },
                            success:function (res) {
                                res = $.parseJSON(res);
                                if(inputAmt > res.amt ){
                                    $('#amtMsg').html(" Available balance: " + res.amt);
                                    $('#totalBankCredit').val(res.amt);
                                }else{
                                    $('#amtMsg').html('');
                                }
                            }
                        })
                    }
                });
            } else {
                $(".bankListShow").css('display', 'none');
            }
        });
    });
</script>
<script>
        function btnClick() {
            var payment_by = $('#payment_by').find(":selected").text();
            var check = $('#amtMsg').text()
            var totalCashCredit = Number($('#totalCashCredit').val())
            var totalBankCredit = Number($('#getTotalBankCredit').val())
            var amount = Number($('#amount').val())
            if(payment_by=="Cash" && amount > totalCashCredit){
                alert('Cash Limit Over '+ totalCashCredit)
                return false;
            }else if(payment_by=="Bank" && amount > totalBankCredit){
                alert('Cash Limit Over '+ totalBankCredit)
                return false;
            }
            if(check !=''){
                alert('No available balance')
                return false;
            }
        }
</script>
@endpush
@endsection

