@extends('frontend.layout.master')
@section('title', 'Blog')
@section('content')
<?php $page = 'blog'; ?>
<!-- Header -->
<section class="page_header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>Blog</h3>
        <a href="{{ route('index') }}">Home</a><span> > Blog</span>
      </div>
    </div>
  </div>
</section>

<section class="blog_area">
  <div class="container">
    @foreach($blog as $row)
    <div class="row blog_content_area">
      <div class="col-md-4">
        <div class="blog_img">
          <a href="{{ route('blog.show',$row->id) }}">
            <img style="height: 230px; width:230px; border-radius: 50%;" src="{{ asset('frontend/images/blog/' .$row->image) }}" alt="">
          </a>
        </div>
      </div>
      <div class="col-md-8">
        <div class="blog_content">
          <h3 class="blog_tilte"><a href="{{ route('blog.show',$row->id) }}">{{ $row->title }}</a></h3>
          <p><span>Post by <strong>{{ $row->author }}</strong> </span>&nbsp;&nbsp;&nbsp;<span><i class="fas fa-calendar-alt"></i> {{ date('d M, Y', strtotime($row->created_at)) }}</span>
            <span>&nbsp;<i class="fas fa-clock"> </i> {{ date('h:i A', strtotime($row->created_at)) }}</span></p>
          <p>@php echo substr($row->post,0,250); @endphp ...</p>
          <a href="{{ route('blog.show',$row->id) }}" class="btn btn-sm btn-outline-primary">read More></a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>




  <div class="row ">
    <div class="col-md-12 d-flex justify-content-center pt-5">
      {{ $blog->links() }}
    </div>
  </div>
@endsection
