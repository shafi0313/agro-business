@extends('frontend.layout.master')
<title>Mondol Traders</title>
@section('content')
@php $p='home'; @endphp
<!-- Slider Start -->
<section>
    <div class="owl-carousel owl-theme" id="owl_1">
        @foreach($sliders as $slider)
        <div class="main_slider"
            style="background: url('{{ asset("images/slider/" .$slider->image) }}'); no-repeat; background-size: cover;min-height: 450px; width: 100%;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 ">
                        <div class="slider_title">
                            <h2 style="color:;">{{$slider->title}}</h2>
                            <h3>{{$slider->sub_title}}</h3>
                            @if($slider->link!='')
                            <a href="{{$slider->link}}">{{$slider->link_name}}</a>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- About -->
<section class="about" style="">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="about_title">Welcome to <span>{{ $about->title}}</span></h1>
                <p class="about_text">{!! \Illuminate\Support\Str::limit($about->texts, 310, ' ...') !!}</p>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Welcome to <strong>{{$about->title}}</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-justify">{!! $about->texts !!}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row wow fadeIn" data-wow-duration="2s" data-wow-delay="1s">
            <div class="col-md-3 offset-5">
                <a href="#">
                    <button class="glow-on-hover" type="button" data-toggle="modal"
                        data-target="#exampleModalLong">More..</button>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Products --}}
<section id="courses">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="common_heading pb_80">
                    <h3 class="section_title">Our Products</h3>
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-deck text-center">
                            <div class="owl-carousel owl-theme owl_course" id="owl_2">
                                @foreach($products as $product)
                                <div class="item">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card_img"> <img
                                                    src="{{ asset('images/product/' .$product->image) }}"
                                                    class="card-img-top" alt="..."> </div>
                                            <a href="{{ route('productDetails', $product->id) }}">
                                                <div class="overlay"> <span>READ MORE</span> </div>
                                            </a>
                                            <div class="card-body">
                                                <a href="{{ route('productDetails', $product->id) }}">
                                                    <p class="card-text">{{ $product->name }}</p>
                                                </a>
                                                <p style="font-size:14px">{{ $product->generic }}</p>

                                                <div class="small_logo">
                                                    <img src="{{ asset('images/icons/company_logo_c.jpg') }}" class="img-fluid"
                                                        alt="{{ $product->name }}">
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
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button"> <a href="{{ route('allProducts')}}">ALL Products</a> </div>
            </div>
        </div>
    </div>
</section>



<!-- Our Facilities -->
{{-- <section class="facilities">
    <div class="container">
        <h3 class="section_title">Our Facilities</h3>
        <div class="row">
            <div class="col-md-4 wow fadeIn" data-wow-duration="3s" data-wow-delay=".5s">
                <div class="f_card">
                    <img src="{{ asset('frontend/images/facilities/support.png') }}" alt="">
                    <h3 class="f_title">Lifetime Support</h3>
                    <p class="f_text"></p>
                </div>
            </div>
            <div class="col-md-4 wow fadeIn" data-wow-duration="3s" data-wow-delay=".6s">
                <div class="f_card">
                    <img src="{{ asset('frontend/images/facilities/class-review.png') }}" alt="">
                    <h3 class="f_title">Review Class</h3>
                    <p class="f_text"></p>
                </div>
            </div>
            <div class="col-md-4 wow fadeIn" data-wow-duration="3s" data-wow-delay=".7s">
                <div class="f_card">
                    <img src="{{ asset('frontend/images/facilities/lab.png') }}" alt="">
                    <h3 class="f_title">Practise Lab Support</h3>
                    <p class="f_text"></p>
                </div>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-md-4 wow fadeIn" data-wow-duration="3s" data-wow-delay=".8s">
                <div class="f_card">
                    <img src="{{ asset('frontend/images/facilities/24.png') }}" alt="">
                    <h3 class="f_title">24/7 Online Support</h3>
                    <p class="f_text"></p>
                </div>
            </div>
            <div class="col-md-4 wow fadeIn" data-wow-duration="3s" data-wow-delay=".9s">
                <div class="f_card">
                    <img src="{{ asset('frontend/images/facilities/video-class.png') }}" alt="">
                    <h3 class="f_title">Class Video</h3>
                    <p class="f_text"></p>
                </div>
            </div>
           <div class="col-md-4">
            <div class="f_card">
              <img src="images/cards/14045.jpg" alt="">
              <h3 class="f_title">Practise Lab Support</h3>
              <p class="f_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eveniet laboriosam provident at optio reiciendis culpa, reprehenderit quam eius harum voluptates </p>
            </div>
          </div>
        </div>
    </div>
</section> --}}

<section class="counter_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="counter">
                    <div class="counter-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Dealer</h3>
                    <span class="counter-value">{{ $users }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="counter blue">
                    <div class="counter-icon">
                        <i class="fas fa-capsules"></i>
                    </div>
                    <h3>Product</h3>
                    <span class="counter-value">{{$products->count()}}</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
