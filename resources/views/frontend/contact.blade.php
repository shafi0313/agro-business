@extends('frontend.layout.master')
@section('title', 'Contact')
@section('content')
@php $p='contact' @endphp
	<!-- Header -->
  <section class="page_header">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3>Contact Us</h3>
          <a href="{{ Route('index') }}">Home</a><span> > Contact Us</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Address -->
  <section class="contact_p_address">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-2 contact_i"><i class="fas fa-map-marker-alt"></i></div>
            <div class="col-md-10">
              <p><strong>Address:</strong><br>Keraniganj-Dhaka.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row">
            <div class="col-md-2 contact_i"><i class="fas fa-phone-alt"></i></div>
            <div class="col-md-10">
              <p><strong>Phone:</strong><br> +880 177 1341888 <br> +880 191 9522230</p>
            </div>
          </div>
        </div>
      </div>
      <div class="divider"></div>
    </div>
  </section>

  <section class="contact_p_form">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
        <form action="{{ url('send/mail') }}">
          @csrf
            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-user"></i></div>
              </div>
              <input type="text" name="subject" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Name" required>
            </div>

            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
              </div>
              <input type="email" name="email" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Email" required>
            </div>

            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-comment"></i></div>
              </div>
              <textarea name="message" rows="4" cols="50" class="form-control" id="" placeholder="Message.."></textarea>
            </div>
            <button class="btn btn-info btn-block" type="submit"> Send <i class="fas fa-chevron-circle-right"></i></button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-md 12"></div>
      </div>
    </div>
  </section>

@endsection
