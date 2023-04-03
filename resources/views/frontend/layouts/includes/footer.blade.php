<!-- FOOTER AREA START -->
<footer class="ltn__footer-area  ">
    <div class="footer-top-area  section-bg-1 plr--5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="footer-widget footer-about-widget">
                        <div class="footer-logo">
                            <div class="site-logo">
                                <img src="{{ asset(setting('app_favicon')) }}" alt="Company Logo" style="margin: auto">
                            </div>
                        </div>
                        <p style="text-align: center; ">{{ setting('front_footer') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Company</h4>
                        <div class="footer-menu">
                            <ul>
                                <li><a href="{{ route('about') }}">About</a></li>
                                <li><a href="{{ route('allProducts') }}">All Products</a></li>
                                <li><a href="{{ route('contact') }}">Contact us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Address</h4>
                        <div class="footer-address">
                            <ul>
                                <li>
                                    <div class="footer-address-icon">
                                        <i class="icon-placeholder"></i>
                                    </div>
                                    <div class="footer-address-info">
                                        {!! setting('front_address') !!}
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-address-icon">
                                        <i class="icon-call"></i>
                                    </div>
                                    <div class="footer-address-info">
                                        <p><a href="tel:{{ setting('phone_1') }}">{{ setting('phone_1') }}</a></p>
                                        <p><a href="tel:{{ setting('phone_2') }}">{{ setting('phone_2') }}</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="footer-address-icon">
                                        <i class="icon-mail"></i>
                                    </div>
                                    <div class="footer-address-info">
                                        <p><a href="mailto:{{ setting('email_1') }}">{{ setting('email_1') }}</a></p>
                                        <p><a href="mailto:{{ setting('email_2') }}">{{ setting('email_2') }}</a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="ltn__social-media mt-20">
                            <ul>
                                <li><a href="{{ URL::to(setting('facebook')) }}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                {{-- <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="#" title="Youtube"><i class="fab fa-youtube"></i></a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ltn__copyright-area ltn__copyright-2 section-bg-2  ltn__border-top-2--- plr--5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="ltn__copyright-design footer">
                        <p class="copy">Copyright &copy; {{date('Y')}} {{ setting('app_name') }} All rights reserved.</p>
                        <p class="developer"><a href="http://softgiantbd.com/" style="text-decoration:none;color:#fff">Developed By Soft Giant BD</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER AREA END -->
