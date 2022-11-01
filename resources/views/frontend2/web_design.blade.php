@extends('frontend.layout.master')
@section('title', 'Responsive Web Design')
@section('content')
<?php $page = 'wd'; ?>
  <!-- Header -->
  <section class="page_header">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3>Course Details</h3>
          <a href="{{ Route('index') }}">Home</a><span> > Responsive Web Design</span>
        </div>
      </div>
    </div>
  </section>

  <h3 class="course_title">Responsive Web Design</h3>
  <div class="divider_2"></div>
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 p_image">
          <img src="{{ asset('frontend/images/page/web_design.png') }}" alt="">
        </div>
      </div>
    </div>
  </section>

  <!-- Course -->
  <section class="w_d_p">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5 coures_list">
          <h3>Course Module</h3>
          <div class="divider_1"></div>
          <ul>
            <li>HTML, HTML5</li>
            <li>CSS, CSS3</li>
            <li>Bootstrap 5</li>
            {{-- <li>JavaScript</li> --}}
            <li>jQuery</li>
            <li>PSD to HTML</li>
            <li>Animation Effect</li>
            <li>Real Life Project</li>
            <li>Free web hosting & domain</li>
          </ul>

          {{-- <h3>Marketplace</h3>
          <div class="divider_1"></div>
          <ul>
            <li>Upwork</li>
            <li>Freelancer</li>
            <li>Fiverr etc.</li>
          </ul> --}}
        </div>

        <div class="col-md-5">
          <h3>Software Taught</h3>
          <div class="divider_1"></div>
          <ul>
            <li>Adobe Photoshop</li>
            <li>VS Code</li>
            {{-- <li>Brackets</li> --}}
            <li>Web Browsers</li>
            <li>Web Server</li>
          </ul>

          <h3>Career Opportunity</h3>
          <div class="divider_1"></div>
          <ul>
            <li>Web Designer</li>
            <li>Front End Developer</li>
            <li>Web Animator</li>
            <li>Entrepreneur</li>
            <li>IT Farm</li>
            <li>Software Farm </li>
            <li>Any Company or Organization</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
@endsection
