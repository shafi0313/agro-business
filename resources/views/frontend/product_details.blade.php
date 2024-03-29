@extends('frontend.layouts.app')
@section('content')
    <!-- Header -->
    <section class="page_header">
        <div class="container">
            <div class="row product_content_area">
                <div class="col-md-12">
                    <h3>Product Details</h3>
                    <a href="{{ Route('index') }}">Home > </a> <span>Product Details</span>
                </div>
            </div>
        </div>
    </section>
    <style>
        p {
            margin-bottom: 5px !important;
        }
    </style>

    <section class="read_product_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-4">
                    <h1 class="product_tilte">{{ $product->name }}</h1>
                    <h5 class="display-5">{{ $product->generic }} </h5>
                    @if (setting('enable_product_date_time') == 1)
                        <p>
                            <span><i class="fas fa-calendar-alt"></i>
                                {{ date('d M, Y', strtotime($product->updated_at)) }}</span>
                            <span>&nbsp;<i class="fas fa-clock"> </i>
                                {{ date('h:i A', strtotime($product->updated_at)) }}</span>
                        </p>
                    @endif
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="read_product_img">
                        <img style="width:400px;" class="img-fluid" src="{{ imagePath('product', $product->image) }}"
                            alt="{{ $product->name }}"></td>
                    </div>
                </div>
                <div class="col-md-7">
                    <h3>Introduction:</h3>
                    <p class="product_text">{!! $product->indications !!}</p>
                    <br>
                    <div class="course_f_price d-flex">
                        <table class="table table-border table-sm col-6">
                            <tr>
                                <th>Size</th>
                                @if (setting('enable_product_price') == 1)
                                    <th>Price</th>
                                @endif

                            </tr>
                            @foreach ($prices as $price)
                                <tr>
                                    <td>{{ $price->size }}</td>
                                    @if (setting('enable_price') == 1)
                                        <td>
                                            <small class="text-muted">MRP:
                                                <span style="font-size: 18px">&#2547;</span>
                                                {{ number_format($price->mrp, 2) }}
                                            </small>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
