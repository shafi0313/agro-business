<div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head">
            <div class="site-logo mobile_logo">
                <a href="{{ route('index') }}"><img src="{{ asset(setting('app_logo_png')) }}" alt="Logo"
                        width="60px"></a>
            </div>
            <button class="ltn__utilize-close">×</button>
        </div>
        <div class="ltn__utilize-menu-search-form">
            <form action="#">
                <input type="text" placeholder="Search...">
                <button><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="ltn__utilize-menu">
            <ul>
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="#">Products</a>
                    <ul class="sub-menu">
                        @php
                            $productCats = App\Models\ProductCat::select(['id', 'name'])->get();
                        @endphp
                        @foreach ($productCats as $productCat)
                            <li><a
                                    href="{{ route('allProductByCategory', $productCat->id) }}">{{ $productCat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
            </ul>
        </div>
        <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
            <ul>
                <li>
                    <a href="{{ route('login') }}" title="My Account">
                        <span class="utilize-btn-icon">
                            <i class="far fa-user"></i>
                        </span>
                        Login
                    </a>
                </li>
                {{-- <li>
            <a href="wishlist.html" title="Wishlist">
                <span class="utilize-btn-icon">
                    <i class="far fa-heart"></i>
                    <sup>3</sup>
                </span>
                Wishlist
            </a>
        </li>
        <li>
            <a href="cart.html" title="Shoping Cart">
                <span class="utilize-btn-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <sup>5</sup>
                </span>
                Shoping Cart
            </a>
        </li> --}}
            </ul>
        </div>
        <div class="ltn__social-media-2">
            <ul>
                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</div>
