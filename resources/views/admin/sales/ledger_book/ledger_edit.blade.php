@extends('admin.layout.master')
@section('title', 'Collection')
@section('content')
@php $p = 'account'; $sm='receved'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
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
                            <form action="{{ route('salesLedgerBook.ledgerReportUpdate', $ledgerBook->id)}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="date">Sales Amount <span class="t_r">*</span></label>
                                        <input type="number" step="any" id="sales_amt" name="sales_amt" class="form-control @error('sales_amt') is-invalid @enderror" value="{{$ledgerBook->sales_amt}}" placeholder="" required>
                                        @error('sales_amt')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="date">Discount % <span class="t_r">*</span></label>
                                        <input type="number" step="any" id="discount" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{$ledgerBook->discount}}" placeholder="" required>
                                        @error('discount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="date">Discount Taka <span class="t_r">*</span></label>
                                        {{-- <input type="number" id="discount" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{$ledgerBook->discount}}" placeholder="" required> --}}
                                        <input type="number" step="any" id="discountTk" name="" class="form-control">
                                        @error('discount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="date">Net Amount <span class="t_r">*</span></label>
                                        <input type="number" step="any" id="net_amt" name="net_amt" class="form-control @error('net_amt') is-invalid @enderror">
                                        @error('net_amt')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div align="center" class="mr-auto card-action">
                                    <button type="submit" class="btn btn-success">Submit</button>
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
    $("#discount").on('keyup',function() {
        var sales_amt = $('#sales_amt').val()
        var discount = $('#discount').val()
        var sum = 0;
        var sumTk = 0;
        var percent = Number(sales_amt)*Number(discount)/100;
        $('#net_amt').each(function() {
            sum = Number(sales_amt) - Number(percent);
        });

        $('#discountTk').each(function() {
            sumTk = Number(percent);
        });

        $('#net_amt').val(Math.round(sum));
        $('#discountTk').val(sumTk);
    });

    $('#discountTk').keyup(function() {
        var sales_amt = $('#sales_amt').val()
        var discountTk = $("#discountTk").val()
        var sum = 0;
        var sumTk = 0;
        var percent = Number(discountTk)*100/ Number(sales_amt);
        $('#discount').each(function() {
            sumTk = Number(percent);
        });

        $('#net_amt').each(function() {
            sum = Number(sales_amt) - Number(discountTk);
        });
        $('#net_amt').val(Math.round(sum));
        $('#discount').val(sumTk.toFixed(2));
    });
</script>

@endpush
@endsection

