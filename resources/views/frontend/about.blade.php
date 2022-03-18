@extends('frontend.layout.master')
@section('title', 'About')
@section('content')
@php $p='about' @endphp
	  <!-- Header -->
  <section class="page_header">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3>About Us</h3>
          <a href="{{ Route('index') }}">Home</a><span> > About Us</span>
        </div>
      </div>
    </div>
  </section>

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
