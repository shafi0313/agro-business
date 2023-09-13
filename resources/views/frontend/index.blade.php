@extends('frontend.layouts.app')
@section('content')
<!-- SLIDER AREA START (slider-3) -->
<div class="ltn__slider-area ltn__slider-3  section-bg-1">
    <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1 arrow-white">
        <!-- ltn__slide-item -->
        @foreach ($sliders as $slider)
        <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3 text-color-white bg-image" data-bg="{{ imagePath('slider', $slider->image) }}">
            <div class="ltn__slide-item-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 align-self-center">
                            <div class="slide-item-info">
                                <div class="slide-item-info-inner ltn__slide-animation">
                                    {{-- <h6 class="slide-sub-title animated"><img src="{{ asset('frontend/img/icons/icon-img/1.png') }}" alt="#"> 100% genuine Products</h6> --}}
                                    <h1 class="slide-title animated ">{{ $slider->title }}</h1>
                                    <div class="slide-brief animated">
                                        <p>{{ $slider->sub_title }}</p>
                                    </div>
                                    @if (!empty($slider->link))
                                    <div class="btn-wrapper animated">
                                        <a href="{{ URL::to($slider->link) }}" class="theme-btn-1 btn btn-effect-1 text-uppercase">{{ $slider->link_name }}</a>
                                    </div>
                                    @endif                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach       
    </div>
</div>
<!-- SLIDER AREA END -->

<!-- BANNER AREA START -->
{{-- <div class="ltn__banner-area mt-120">
    <div class="container">
        <div class="row ltn__custom-gutter--- justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="{{ asset('frontend/img/banner/1.jpg') }}" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="{{ asset('frontend/img/banner/2.jpg') }}" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="{{ asset('frontend/img/banner/1.jpg') }}" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- BANNER AREA END -->

<!-- BANNER AREA START -->
{{-- <div class="ltn__banner-area mt-120 mt--90 d-none">
    <div class="container">
        <div class="row ltn__custom-gutter--- justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="{{ asset('frontend/img/banner/1.jpg') }}" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="{{ asset('frontend/img/banner/2.jpg') }}" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="{{ asset('frontend/img/banner/1.jpg') }}" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- BANNER AREA END -->

<!-- BANNER AREA START -->
{{-- <div class="ltn__banner-area mt-120  d-none">
    <div class="container">
        <div class="row ltn__custom-gutter--- justify-content-center">
            <div class="col-lg-6 col-md-6">
                <div class="ltn__banner-item">
                    <div class="ltn__banner-img">
                        <a href="shop.html"><img src="img/banner/13.png" alt="Banner Image"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ltn__banner-item">
                            <div class="ltn__banner-img">
                                <a href="shop.html"><img src="img/banner/14.png" alt="Banner Image"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ltn__banner-item">
                            <div class="ltn__banner-img">
                                <a href="shop.html"><img src="img/banner/15.png" alt="Banner Image"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- BANNER AREA END -->



<div class="ltn__product-tab-area ltn__product-gutter pt-85">
    <div class="container">
        <div class="section-title-area ltn__section-title-2 text-center">
            <h1 class="section-title">Our Products</h1>
        </div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach ($productCats as $productCat)
<li class="nav-item">
        <a class="nav-link {{ $loop->first?'active':'' }}" id="home-tab" data-toggle="tab" href="#tab_{{ $productCat->id }}" role="tab" aria-controls="tab_{{ $productCat->id }}" aria-selected="true">{{ $productCat->name }}</a>
        </li>
    @endforeach
  </ul>
  <div class="tab-content" id="myTabContent">
    @foreach ($productCats as $productCat)
    <div class="tab-pane fade show {{ $loop->first?'active':'' }}" id="tab_{{ $productCat->id }}" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
            @foreach ($productCat->products as $product)
            <div class="col-md-3 ">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img productImage">
                        <a href="{{ route('productDetails', $product->id) }}"><img src="{{ imagePath('product', $product->image) }}" alt="#" height="160px"></a>
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
                        <p class=""><a href="{{ route('productDetails', $product->id) }}">{{ $product->generic }}</a></p>
                        <div class="product-price">
                            {{-- <span>{{ $product->productPack->mrp }}</span> --}}
                            {{-- <del>$46.00</del> --}}
                        </div>
                    </div>

                </div>

                {{-- <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/7.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Poltry Farm Meat</a></h2>
                        <div class="product-price">
                            <span>$78.00</span>
                            <del>$85.00</del>
                        </div>
                    </div>
                </div> --}}
            </div>
            @endforeach
        </div>

    </div>
    @endforeach
  </div>
  </div>


<!-- COUNTDOWN AREA START -->
{{-- <div class="ltn__call-to-action-area ltn__call-to-action-4 section-bg-1 pt-110 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <img src="img/banner/11.png" alt="#">
            </div>
            <div class="col-lg-7">
                <div class="call-to-action-inner call-to-action-inner-4 text-color-white--- text-center---">
                    <div class="section-title-area ltn__section-title-2 text-center---">
                        <h6 class="ltn__secondary-color">Todays Hot Deals</h6>
                        <h1 class="section-title">Original Stock Honey <br>  Combo Package</h1>
                    </div>
                    <div class="ltn__countdown ltn__countdown-3 bg-white--" data-countdown="2021/12/28"></div>
                    <div class="btn-wrapper animated">
                        <a href="shop.html" class="theme-btn-1 btn btn-effect-1 text-uppercase">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- COUNTDOWN AREA END -->

<!-- PRODUCT AREA START (product-item-3) -->
{{-- <div class="ltn__product-area ltn__product-gutter pt-115 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h1 class="section-title">Featured Products</h1>
                </div>
            </div>
        </div>
        <div class="row ltn__tab-product-slider-one-active--- slick-arrow-1">
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-left">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/1.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Carrots Group Scal</a></h2>
                        <div class="product-price">
                            <span>$32.00</span>
                            <del>$46.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-left">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/2.png" alt="#"></a>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Red Hot Tomato</a></h2>
                        <div class="product-price">
                            <span>$25.00</span>
                            <del>$35.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/3.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Orange Fresh Juice</a></h2>
                        <div class="product-price">
                            <span>$75.00</span>
                            <del>$92.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/4.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Poltry Farm Meat</a></h2>
                        <div class="product-price">
                            <span>$78.00</span>
                            <del>$85.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/5.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Fresh Butter Cake</a></h2>
                        <div class="product-price">
                            <span>$150.00</span>
                            <del>$180.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/6.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Orange Sliced Mix</a></h2>
                        <div class="product-price">
                            <span>$150.00</span>
                            <del>$180.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/7.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Orange Fresh Juice</a></h2>
                        <div class="product-price">
                            <span>$75.00</span>
                            <del>$92.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ltn__product-item -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <div class="ltn__product-item ltn__product-item-3 text-center">
                    <div class="product-img">
                        <a href="product-details.html"><img src="img/product/8.png" alt="#"></a>
                        <div class="product-badge">
                            <ul>
                                <li class="sale-badge">New</li>
                            </ul>
                        </div>
                        <div class="product-hover-action">
                            <ul>
                                <li>
                                    <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Add to Cart" data-toggle="modal" data-target="#add_to_cart_modal">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                        <i class="far fa-heart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-ratting">
                            <ul>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star"></i></a></li>
                                <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                <li><a href="#"><i class="far fa-star"></i></a></li>
                            </ul>
                        </div>
                        <h2 class="product-title"><a href="product-details.html">Poltry Farm Meat</a></h2>
                        <div class="product-price">
                            <span>$78.00</span>
                            <del>$85.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
</div> --}}
<!-- PRODUCT AREA END -->

<!-- IMAGE SLIDER AREA START (img-slider-2) -->
{{-- <div class="ltn__img-slider-area ltn__img-slider-2 section-bg-1 pt-115 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title-area ltn__section-title-2 text-center">
                    <h6 class="section-subtitle ltn__secondary-color">//  Portfolio</h6>
                    <h1 class="section-title">We Have Done<span>.</span></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row ltn__image-slider-2-active slick-arrow-1 slick-arrow-1-inner">
            <div class="col-lg-12">
                <div class="ltn__img-slide-item-2">
                    <a href="img/img-slide/1.jpg" data-rel="lightcase:myCollection">
                        <img src="img/img-slide/1.jpg" alt="Image">
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__img-slide-item-2">
                    <a href="img/img-slide/2.jpg" data-rel="lightcase:myCollection">
                        <img src="img/img-slide/2.jpg" alt="Image">
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__img-slide-item-2">
                    <a href="img/img-slide/3.jpg" data-rel="lightcase:myCollection">
                        <img src="img/img-slide/3.jpg" alt="Image">
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__img-slide-item-2">
                    <a href="img/img-slide/4.jpg" data-rel="lightcase:myCollection">
                        <img src="img/img-slide/4.jpg" alt="Image">
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__img-slide-item-2">
                    <a href="img/img-slide/1.jpg" data-rel="lightcase:myCollection">
                        <img src="img/img-slide/1.jpg" alt="Image">
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ltn__img-slide-item-2">
                    <a href="img/img-slide/2.jpg" data-rel="lightcase:myCollection">
                        <img src="img/img-slide/2.jpg" alt="Image">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- IMAGE SLIDER AREA END -->

<!-- FEATURE AREA START ( Feature - 3) -->
{{-- <div class="ltn__feature-area before-bg-bottom-2 mb--30--- plr--5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="ltn__feature-item-box-wrap ltn__border-between-column white-bg">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="img/icons/icon-img/11.png" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Curated Products</h4>
                                    <p>Provide Curated Products for
                                        all product over $100</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="img/icons/icon-img/12.png" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Handmade</h4>
                                    <p>We ensure the product quality
                                        that is our main goal</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="img/icons/icon-img/13.png" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Natural Food</h4>
                                    <p>Return product within 3 days
                                        for any product you buy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="ltn__feature-item ltn__feature-item-8">
                                <div class="ltn__feature-icon">
                                    <img src="img/icons/icon-img/14.png" alt="#">
                                </div>
                                <div class="ltn__feature-info">
                                    <h4>Free home delivery</h4>
                                    <p>We ensure the product quality
                                        that you can trust easily</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- FEATURE AREA END -->


{{-- Counter Up Start --}}
<div class="ltn__counterup-area bg-image bg-overlay-theme-black-80 pt-115 pb-70" data-bg="img/bg/5.jpg" style="background-image: url(&quot;img/bg/5.jpg&quot;);">
    <div class="container">
        <div class="row justify-content-center">
            @if (setting('enable_client_count') == 1)
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="{{ asset('frontend/img/icons/icon-img/2.png') }}" alt="#"> </div>
                    <h1><span class="counter animated fadeInDownBig">{{ $users }}</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Active Clients</h6>
                </div>
            </div>
            @endif

            @if (setting('enable_product_count') == 1)
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="{{ asset('frontend/img/icons/icon-img/3.png') }}" alt="#"> </div>
                    <h1><span class="counter animated fadeInDownBig">{{ $products }}</span><span class="counterUp-letter"></span><span class="counterUp-icon">+</span> </h1>
                    <h6>Products</h6>
                </div>
            </div>
            @endif

            @if (setting('enable_district_count') == 1)
            <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="{{ asset('frontend/img/icons/icon-img/4.png') }}" alt="#"> </div>
                    <h1><span class="counter animated fadeInDownBig">64</span><span class="counterUp-icon"></span> </h1>
                    <h6>Districts</h6>
                </div>
            </div>
            @endif
            {{-- <div class="col-md-3 col-sm-6 align-self-center">
                <div class="ltn__counterup-item-3 text-color-white text-center">
                    <div class="counter-icon"> <img src="{{ asset('frontend/img/icons/icon-img/5.png') }}" alt="#"> </div>
                    <h1><span class="counter animated fadeInDownBig">21</span><span class="counterUp-icon">+</span> </h1>
                    <h6>Country Cover</h6>
                </div>
            </div> --}}
        </div>
    </div>
</div>
{{-- Counter Up End --}}
@endsection
