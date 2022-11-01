        <!-- Footer Start -->
        <section class="footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="footer_image wow slideInLeft" data-wow-duration="2s" data-wow-delay="">
                            <img src="{{ asset('images/icons/company_logo.png') }}" alt="">
                        </div>
                        <div class="social">
                            <a href="#" target="_blank"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="#" target="_blank"><i
                                    class="fab fa-youtube"></i></a>
                            <a href="#" target="_blank"><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="footer_title">Contact Us</h4>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 footer_icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="col-lg-10 col-md-10 address">
                                Head office: High Road, Alamdanga, Chuadanga. <br>
                                Dhaka Office: House # 14, Road # 3,
Block # E, Extended Rupnagar (R/A) Sector # 12, Mirpur, Dhaka-1216.

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-2 footer_icon_2">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="col-lg-9 col-md-9 footer_icon_text">
                                <p>+8801318-302500</p>
                                <p>07622-56385</p>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-2 col-md-2 footer_icon_2">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="col-lg-10 col-md-10 footer_icon_text">
                                <p>r.tuhin@icloud.com</p>
                                <p>info@mondolag.com</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2 col-md-2 footer_icon_3">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            <div class="col-lg-10 col-md-10">
                                <p><a href="https://mondolag.com/">www.mondolag.com</a></p>
                            </div>
                        </div>

                    </div>
                    {{-- <div class="col-md-3">
                        <h4 class="footer_title">Our Services</h4>
                        <ul class="footer_link">
                            <li><a href="#">Web Dsign & Development</a></li>
                            <li><a href="#">UI/UX Design</a></li>
                            <li><a href="#">Graphic Design</a></li>
                            <li><a href="#">SEO</a></li>
                            <li><a href="#">WordPress</a></li>
                            <li><a href="#">Content Writing</a></li>
                        </ul>
                    </div> --}}

                    <div class="col-md-2">
                        <h4 class="footer_title">Quick Links</h4>
                        <ul class="footer_link">
                            <li><a href="{{ route('allProducts')}}">Products</a></li>
                            <li><a href="{{ url('about') }}">About Us</a></li>
                            {{-- <li><a href="">All Courses</a></li> --}}
                            {{-- <li><a href="{{ url('gallery') }}">Galary</a></li> --}}
                            {{-- <li><a href="{{ route('allProducts')}}">privacy &amp; policy</a></li> --}}
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer End -->

        <!-- Footer Copyright Start -->
        <section class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="copy">Copyright &copy; {{date('Y')}} Mondol Traders. All rights reserved.</p>
                        <p class="developer"><a href="http://shafi95.com/" style="text-decoration:none;color:#fff">Developed By Shafi</a></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Back to top button -->
        <a id="button"><i class="fas fa-chevron-up"></i></a>

        <script src="{{ asset('frontend/js/popper.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery3.4.1.js') }}"></script>
        <!-- <script src="js/jquery-3.3.1.js"></script> -->
        <script src="{{ asset('frontend/vendor/owlcarousel/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/vendor/wowjs/wow.min.js') }}"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>
        <script src="{{ asset('frontend/js/wow.min.js') }}"></script>

        <script src="{{ asset('frontend/vendor/sweetalert/sweetalert2.all.min.js')}}"></script>

        <script>
            new WOW().init();
        </script>

    </body>
  </html>
