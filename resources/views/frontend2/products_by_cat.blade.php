@extends('frontend.layout.master')
@section('title', 'All Products')
@section('content')
@php $p='product' @endphp
<!-- Header -->
<section class="page_header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Products By Group</h3>
                <a href="{{ Route('index') }}">Home</a><span> > Products By Group</span>
            </div>
        </div>
    </div>
</section>

<h3 class="course_title">{{$allProducts->first()->productCat->name}}</h3>
<div class="divider_2"></div>
{{-- <section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 p_image">
                <img src="{{ asset('frontend/images/page/basic_computer_traning.jpg') }}" alt="">
            </div>
        </div>
    </div>
</section> --}}

<!-- Products -->
<section id="courses">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="card-deck text-center">
                        @foreach($allProducts as $product)
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card_img"> <img
                                        src="{{ asset('uploads/images/product/' .$product->image) }}"
                                        class="card-img-top" alt="..."> </div>
                                <a href="{{ route('productDetails', $product->id) }}">
                                    <div class="overlay"> <span>READ MORE</span> </div>
                                </a>
                                <div class="card-body">
                                    <a href="{{$product->link}}">
                                        <h1 class="card-text">{{ $product->name }}</h1>
                                    </a>
                                    <p style="font-size:14px">{{ $product->generic }}</p>

                                    <div class="small_logo">
                                        <img src="{{ asset('images/icons/company_logo_c.jpg') }}" class="img-fluid"
                                            alt="">
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="course_f_price">
                                        <strong class="text-muted text-decoration-none" >
                                            <a href="{{ route('productDetails', $product->id) }}">Price</a>
                                        </strong>
                                    </div>
                                </div>
                        </div>
                        <br>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
