@extends('admin.layout.master')
@section('title', 'Bank Statement')
@section('content')
@php $p = 'account'; $sm='bankStat'; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard')}}" title="Dashboard"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="">Bank Statement</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Select Date</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Select Date</h4>
                                <button  type="button" class="btn btn-success btn-sm ml-auto" data-toggle="modal" data-target="#exampleModal">Add Previous</button>
                            </div>
                        </div>
                        <div class="card-body" >
                            <h1 class="text-center mr-5 mb-3">Select the date and show bank statement</h1>
                            <form action="{{ route('bankStatement.index') }}" method="get">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_date" class="form-label">Select Bank:</label>
                                            <select name="bank_id" id="bank" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="-1">All Bank</option>
                                                @foreach ($userBankAcs as $userBankAc)
                                                <option value="{{$userBankAc->id}}">{{$userBankAc->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6">
                                        <div class="form-group  bankListShow">
                                            <label for="bank_ac_no">Account No <span class="t_r">*</span></label>
                                            <select name="user_bank_ac_id" id="ac_no" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row justify-content-center">
                                    <div class="form-check col-md-6">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="-2" name="all_report" id="all_report">
                                            <span class="form-check-sign">All Date</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group row col-md-6">
                                        <label for="form_date" class="col-sm-2 col-form-label">Form Date:</label>
                                        <div class="col-sm-4">
                                          <input type="date" name="form_date" class="form-control" id="form_date">
                                        </div>

                                        <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                        <div class="col-sm-4">
                                          <input type="date" name="to_date" class="form-control" id="to_date" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary" style="width: 250px">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.footer')
</div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bank Previous</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('bankStatement.bankPreStore') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_date" class="form-label">Select Bank <span class="t_r">*</span></label>
                                    <select name="bank_id" id="m_bank" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($userBankAcs as $userBankAc)
                                        <option value="{{$userBankAc->id}}">{{$userBankAc->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group  bankListShow">
                                    <label for="bank_ac_no">Account No <span class="t_r">*</span></label>
                                    <select name="user_bank_ac_id" id="m_ac_no" class="form-control" required></select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bank_ac_no">Date <span class="t_r">*</span></label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="credit">Amount <span class="t_r">*</span></label>
                                    <input type="text" name="credit" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="bank_ac_no">Note</label>
                                    <input type="text" name="note" class="form-control">
                                </div>
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
    });
</script>
<script>
    $('#all_report').on('click', function(){
        $('#form_date').val('')
        $('#to_date').val('')
    })

    $('#form_date').on('click', function(){
        $('#all_report').prop('checked', false)
    })
</script>

<script>
    $(document).ready(function(){
        // Bank Information
        $('#m_bank').on('change',function(e) {
            var bank_id = $(this).val();
            $.ajax({
                url:'{{ route("received.bankInfo") }}',
                type:"get",
                data: {
                    bank_id: bank_id
                    },
                success:function (res) {
                    res = $.parseJSON(res);
                    $('#m_ac_no').html(res.bank);
                }
            })
        });
    });
</script>

@endpush
@endsection

