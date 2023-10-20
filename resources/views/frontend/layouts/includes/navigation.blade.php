<div
                class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white sticky-active-into-mobile plr--9---">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="site-logo-wrap">
                                <div class="site-logo">
                                    @if (setting('app_name') == 'Mondol Traders')
                                        <a href="{{ route('index') }}"><img src="{{ asset(setting('app_logo_png')) }}"
                                                alt="Logo" width="150px"></a>
                                    @else
                                        <a href="{{ route('index') }}"><img src="{{ asset(setting('app_logo_png')) }}"
                                                alt="Logo" width="80px"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col header-menu-column menu-color-white---">
                            <div class="header-menu d-none d-xl-block">
                                <nav>
                                    <div class="ltn__main-menu">
                                        <ul>
                                            <li><a href="{{ route('index') }}">Home</a></li>
                                            <li class="menu-icon"><a href="#">Products</a>
                                                <ul>
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
                                </nav>
                            </div>
                        </div>
                        <div class="ltn__header-options ltn__header-options-2">
                            <div class="site-logo mobile_logo">
                                @if (setting('app_name') == 'Mondol Traders')
                                    <a href="{{ route('index') }}">
                                        <img style="padding-left:5px" src="{{ asset(setting('app_logo_png')) }}"
                                            alt="Logo" width="60px">
                                    </a>
                                @else
                                    <a href="{{ route('index') }}">
                                        <img style="padding-left:5px" src="{{ asset(setting('app_logo_png')) }}"
                                            alt="Logo" width="50px">
                                    </a>
                                @endif
                            </div>

                            <!-- header-search-1 -->
                            <div class="header-search-wrap">
                                <div class="header-search-1">
                                    <div class="search-icon">
                                        <i class="icon-search for-search-show"></i>
                                        <i class="icon-cancel  for-search-close"></i>
                                    </div>
                                </div>
                                <div class="header-search-1-form">
                                    <form id="#" method="get" action="#">
                                        <input type="text" name="search" value=""
                                            placeholder="Search here..." />
                                        <button type="submit">
                                            <span><i class="icon-search"></i></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!-- user-menu -->
                            <div class="ltn__drop-menu user-menu">
                                <ul>
                                    <li>
                                        <a href="#"><i class="icon-user"></i></a>
                                        <ul>
                                            <li><a href="{{ route('login') }}">Login</a></li>
                                            {{-- <li><a href="register.html">Register</a></li>
                                    <li><a href="account.html">My Account</a></li>
                                    <li><a href="wishlist.html">Wishlist</a></li> --}}
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <!-- mini-cart -->
                            {{-- <div class="mini-cart-icon">
                        <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                            <i class="icon-shopping-cart"></i>
                            <sup>2</sup>
                        </a>
                    </div> --}}
                            <!-- mini-cart -->
                            <!-- Mobile Menu Button -->
                            <div class="mobile-menu-toggle d-xl-none">
                                <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                                    <svg viewBox="0 0 800 600">
                                        <path
                                            d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200"
                                            id="top"></path>
                                        <path d="M300,320 L540,320" id="middle"></path>
                                        <path
                                            d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190"
                                            id="bottom"
                                            transform="translate(480, 320) scale(1, -1) translate(-480, -318) ">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
