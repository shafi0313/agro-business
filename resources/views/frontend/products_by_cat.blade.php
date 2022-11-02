@extends('frontend.layouts.app')
@section('title', 'Products')
@section('content')

    <!-- Header -->
    <section class="page_header">
        <div class="container">
            <div class="row product_content_area">
                <div class="col-md-12">
                    <h3>Product Details</h3>
                    <a href="{{ Route('index') }}">Home > </a> <span>{{ $products->first()->productCat->name }}</span>
                </div>
            </div>
        </div>
    </section>
    <br>
    <br>

    <div class="container">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="ltn__product-item ltn__product-item-3 text-center">
                        <div class="product-img">
                            <a href="{{ route('productDetails', $product->id) }}"><img
                                    src="{{ imagePath('product', $product->image) }}" alt="#"></a>
                            {{-- <div class="product-badge">
                        <ul>
                            <li class="sale-badge">-19%</li>
                        </ul>
                    </div> --}}
                            <div class="product-hover-action">
                                <ul>
                                    <li>
                                        <a href="{{ route('productDetails', $product->id) }}" title="Quick View">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </li>
                                    {{-- <li>
                                <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </li> --}}
                                    {{-- <li>
                                <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                    <i class="far fa-heart"></i></a>
                            </li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="product-info">
                            {{-- <div class="product-ratting">
                        <ul>
                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                            <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                            <li><a href="#"><i class="far fa-star"></i></a></li>
                            <li class="review-total"> <a href="#"> (24)</a></li>
                        </ul>
                    </div> --}}
                            <h2 class="product-title"><a href="{{ route('productDetails', $product->id) }}">{{ $product->name }}</a></h2>
                            <h2 class="product-title"><a href="{{ route('productDetails', $product->id) }}">{{ $product->generic }}</a></h2>
                            <div class="product-price">
                                {{-- <span>{{ $product->productPack->mrp }}</span> --}}
                                {{-- <del>$46.00</del> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
