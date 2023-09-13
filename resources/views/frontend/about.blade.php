@extends('frontend.layouts.app')
@section('content')
    <!-- Header -->
    <section class="page_header">
        <div class="container">
            <div class="row product_content_area">
                <div class="col-md-12">
                    <h3>About</h3>
                    <a href="{{ Route('index') }}">Home > </a> <span>About</span>
                </div>
            </div>
        </div>
    </section>
    <br>
    <!-- About Text -->
    <section class="about_p">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $about->title }}</h2>
                    <p>{!! $about->texts !!}</p>
                </div>
            </div>
            <br>
        </div>
    </section>

@endsection
