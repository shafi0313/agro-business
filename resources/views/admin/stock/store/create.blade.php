@extends('admin.layout.master')
@section('title', 'Store Stock')
@php $p='factory'; $sm='storeStock'; $ssm='storeShow'; @endphp
@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard')}}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item"><a href="{{ route('stock.store.index')}}">Store Stock</a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item active">Create</li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title"></h4>
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
                            <form action="{{ route('stock.store.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id"  class="autocomplete_txt" />
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="title" class="placeholder">Brand Name</label>
                                        <input type="text"  id="product_name" data-type="product" class="form-control autocomplete_txt">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="title" class="placeholder">Group Name</label>
                                        <input type="text" id="group_name"  class="form-control autocomplete_txt">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="title" class="placeholder">Pack Size</label>
                                        <select name="product_pack_size_id" id="sizee"  class="form-control"></select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="title" class="placeholder">Type</label>
                                        <select class="form-control" name="type" required>
                                            <option>Select</option>
                                            <option value="0">Previous</option>
                                            {{-- <option value="1">Sales</option>
                                            <option value="2">Sales Return</option>
                                            <option value="3">Credit</option>
                                            <option value="4">Credit Return</option>
                                            <option value="5">Sample</option>
                                            <option value="6">Sample Return</option>
                                            <option value="11">Send to production</option> --}}
                                            <option value="20">Expired</option>
                                            <option value="21">Unsold</option>
                                            <option value="20">Damaged</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="title" class="placeholder">Quantity</label>
                                        <input type="text" name="quantity" class="form-control">
                                    </div>

                                </div>
                                <div align="center" class="mr-auto card-action">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('sweetalert::alert')
@push('custom_scripts')
<script>
    // Product Size
    $('#product_name').on('change', function (e) {
        var cat_id = $('#product_id').val();
        $.ajax({
            url: '{{ route("productSize") }}',
            type: "get",
            data: {
                cat_id: cat_id
            },
            success: function (res) {
                res = $.parseJSON(res);
                $('#sizee').html(res.size);
            }
        })
    });
    //autocomplete script
    $(document).on('focus', '.autocomplete_txt', function () {
        type = $(this).data('type');
        if (type == 'product') autoType = 'name';
        // if (type == 'medicinesId') autoType = 'id';
        $(this).autocomplete({
            minLength: 0,
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('productSearch') }}",
                    dataType: "json",
                    data: {
                        term: request.term,
                        type: type,
                    },
                    success: function (data) {
                        var array = $.map(data, function (item) {
                            return {
                                label: item[autoType],
                                value: item[autoType],
                                data: item
                            }
                        });
                        response(array)
                    }
                });
            },
            select: function (event, ui) {
                var data = ui.item.data;
                id_arr = $(this).attr('id');
                id = id_arr.split("_");
                elementId = id[id.length - 1];
                $('#product_id').val(data.id);
                $('#product_name').val(data.name);
                $('#group_name').val(data.generic);
            }
        });
    });

</script>
@endpush
@endsection

