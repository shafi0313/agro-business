@extends('admin.layout.master')
@section('title', 'Collection')
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Office</li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('account-received.index')}}">Collection</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Collection From</li>
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
                            <form action="{{ route('account-received.store')}}" method="post" onsubmit="return validate()">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ $user->id }}">
                                <input type="hidden" name="type" class="type">
                                <input type="hidden" name="pay_type" class="type">
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="date">Date <span class="t_r">*</span></label>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{old('date')}}" required>
                                        @error('date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="account_entry_id">Reference <span class="t_r">*</span></label>
                                        <select name="tmm_so_id" id="" class="form-control" required>
                                            <option selected value disabled>Select</option>
                                            @foreach ($tmmSoIds as $tmmSoId)
                                                {{-- <option value="{{ $tmmSoId->user_id }}">{{ $tmmSoId->user->tmm_so_id }} => {{$tmmSoId->user->name}}</option> --}}
                                                <option value="{{ $tmmSoId->id }}">{{ $tmmSoId->tmm_so_id }} => {{$tmmSoId->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="account_entry_id">Payment By <span class="t_r">*</span></label>
                                        <select name="payment_by" id="payment_by" class="form-control" required>
                                            <option>Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Bank">Bank</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="invoice_no">Invoice No <span class="t_r">*</span></label>
                                        <select name="invoice_no" id="invoice_no" class="form-control" >
                                            <option selected value disabled>Select</option>
                                            @foreach ($invNos as $invNo)
                                                <option value="{{ $invNo->invoice_no }}">{{ $invNo->invoice_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="account_entry_id">Inv/Trn. Type</label>
                                        <input type="text" id="invType" class="form-control" readonly>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="">Sales Amount <span class="t_r">*</span></label>
                                        <input name="" id="sales_amt" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="">Net Sales Amount <span class="t_r">*</span></label>
                                        <input name="" id="get_net_amt" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="">Total Payment <span class="t_r">*</span></label>
                                        <input name="" id="payment" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="">Due Amount <span class="t_r">*</span></label>
                                        <input id="due_amt" name="due_amt" class="form-control due_amt" readonly>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="date">Discount % <span class="t_r">*</span></label>
                                        <input type="text" id="discount" name="discount" class="form-control @error('discount') is-invalid @enderror">
                                        @error('discount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="date">Discount Taka <span class="t_r">*</span></label>
                                        <input type="text" step="any" id="discountTk" name="discount_amt" class="form-control">
                                        @error('discount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="date">Net Amount <span class="t_r">*</span></label>
                                        <input type="text" step="any" id="net_amt" name="net_amt" class="form-control" readonly>
                                        @error('discount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="form-group col-sm-4 bankListShow" style="display: none">
                                        <label for="account_entry_id">Bank Name <span class="t_r">*</span></label>
                                        <select id="bank" class="form-control" >
                                            <option selected value disabled>Select</option>
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
                                        <input name="cheque_no" id="ac_no" class="form-control">
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="credit">Amount<span class="t_r">*</span></label>
                                        <input type="text" step="any" id="amount" name="credit" class="form-control amount @error('credit') is-invalid @enderror" required>
                                        @error('credit')
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
                                        <label for="m_r_date">Money Receipt Date</label>
                                        <input type="date" name="m_r_date" class="form-control @error('m_r_date') is-invalid @enderror" value="{{old('m_r_date')}}">
                                        @error('m_r_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label for="m_r_no">Money Receipt No</label>
                                        <input type="text" name="m_r_no" class="form-control @error('m_r_no') is-invalid @enderror" onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" value="{{old('m_r_no')}}">
                                        @error('m_r_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div align="center" class="mr-auto card-action">
                                    <button type="submit" class="btn btn-success" id="btn_submit">Submit</button>
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
    function validate() {
        $("#btn_submit").attr('disabled', 'disabled');
    }

    $('#btn_submit').on('click', function(){
        var invoice_no = $("#invoice_no").val()

        var amount = Number($('#amount').val())
        var net_amt = Number($('#net_amt').val())
        var due_amt = Number($('#due_amt').val())
        var discountTk = Number($('#discountTk').val())
        var discount = Number($('#discount').val())
        console.log(invoice_no)
        if(invoice_no != null){
            if(discount > 100 || net_amt < 0){
                alert('Check Discount and Net Amount')
                return false;
            };

            if(discountTk != '' && net_amt == ''){
                if(amount > discountTk){
                    alert('Check Invoice Amount')
                    return false;
                }
            }else if(net_amt != ''){
                if( amount > net_amt ){
                    alert('Check Invoice Amount')
                    return false;
                }
            }else{
                if(amount > due_amt){
                    alert('Check Invoice Amount')
                    return false;
                }
            }
        }
    })
</script>

<script>
    $(document).ready(function(){
        $("#payment_by").on('change', function(){
            var pay_method = $(this).val();
            if(pay_method == 'Bank'){
                $(".bankListShow").css('display', 'block');
            } else {
                $(".bankListShow").css('display', 'none');
            }
        });
    });
</script>

<script>
$(document).ready(function(){
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

    // Bank Information
    $('#invoice_no').on('change',function(e) {
        var invoice_no = $(this).val();
        $('#discount').val('');
        $('#discountTk').val('');
        $('#net_amt').val('');

        $.ajax({
            url:'{{ route("received.salesInvInfo") }}',
            type:"get",
            data: {
                invoice_no: invoice_no
                },
            success:function (res) {
                res = $.parseJSON(res);
                var due = res.net_amt - res.payment; // see later
                $('#sales_amt').val(res.sales_amt);
                $('#get_net_amt').val(res.net_amt);
                $('#payment').val(res.payment);
                $('#due_amt').val(due);
                $('#net_amt').val(due);
                $('.type').val(res.type);
                if(res.type==1){
                    $("#invType").val('Cash')
                }else{
                    $("#invType").val('Credit')
                }
            }
        })
    });
});
</script>

<script>
    $("#discount").on('keyup',function() {
        var sales_amt = $('#sales_amt').val()
        var due_amt = $('#due_amt').val()
        var discount = $('#discount').val()
        var sum = 0;
        var sumTk = 0;
        var percent = Number(sales_amt)*Number(discount)/100;
        $('#discountTk').each(function() {
            sumTk = Number(percent);
        });

        $('#net_amt').each(function() {
            sum = Number(due_amt) - Number(percent);
        });
        $('#discountTk').val(sumTk);
        $('#net_amt').val(Math.round(sum));

        if(sumTk < 0){
            // $('#discount').val('');
            $('#discountTk').val('');
            $('#net_amt').val('');
        }
    });

    $('#discountTk').on('keyup',function() {
        var sales_amt = $('#sales_amt').val()
        var discountTk = $("#discountTk").val()
        var due_amt = $('#due_amt').val()
        var sum = 0;
        var sumTk = 0;
        var percent = Number(discountTk)*100/ Number(sales_amt);
        $('#discount').each(function() {
            sumTk = Number(percent);
        });

        if(sumTk < 0 ){
            sumTk = 0
        }

        $('#net_amt').each(function() {
            sum = Number(due_amt) - Number(discountTk);
        });

        $('#discount').val(sumTk.toFixed(2));
        $('#net_amt').val(Math.round(sum));

        if(discountTk < 0){
            $('#discount').val('');
            // $('#discountTk').val('');
            $('#net_amt').val('');
        }
    });
</script>
@endpush
@endsection

