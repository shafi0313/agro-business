  <!-- Header Start -->
  {{-- @php $p='d' @endphp --}}


  <!-- Navigation Start  -->
  <section class="nav">
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top" id="navbar">
      <div class="container">
        <a class="navbar-brand {{($p=='home')?'active':''}}" href="{{ Route('index') }}"><i style="font-size:30px;color: #00a651;" class="fas fa-home"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          {{-- <span class="navbar-toggler-icon"></span> --}}
          <span><i class="fas fa-align-left"></i></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="{{$p=='product'?'active':''}}">
                <a class="nav-link" href="{{ route('allProducts') }}">Products <i class="fas fa-sort-down dropdown_sort"></i></a>
                <ul>
                    @php
                        $productCats = App\Models\ProductCat::select(['id','name'])->get();
                    @endphp
                    @foreach ($productCats as $productCat)
                    <li><a href="{{ route('allPproductsByCatroducts', $productCat->id )}}">{{$productCat->name}}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="{{$p=='about'?'active':''}}"><a class="nav-link" href="{{ route('about') }}">About</a></li>



            {{-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="badge badge-success "><i class="fas fa-user-graduate"></i></span> Students</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class=" dropdown-item" href="#">Seminar</a>
                <a class=" dropdown-item" href="#">Registration Form</a>
              </div>
            </li> --}}

            {{-- <li class="nav-item"><a class="nav-link" href="{{ Route('seminar') }}">Seminars</a></li> --}}
            <li class="{{$p=='contact'?'active':''}}"> <a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            <li class="{{$p=='contact'?'active':''}}" style="margin:5px 0 0 20px"> <a class="btn btn-primary btn-sm" href="{{ route('login') }}">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </section>
