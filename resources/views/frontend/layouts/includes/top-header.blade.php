<div class="ltn__header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="ltn__top-bar-menu">
                    <ul>
                        @if (setting('email_1') || setting('email_2'))
                            @if (setting('email_1'))
                                <li>
                                    <a href="mailto:{{ setting('email_1') }}">
                                        <i class="icon-mail"></i> {{ setting('email_1') }}
                                    </a>
                                </li>
                            @endif
                            @if (setting('email_2'))
                                <li>
                                    <a href="mailto:{{ setting('email_2') }}">{{ setting('email_2') }}</a>
                                </li>
                            @endif

                        @endif
                        @if (setting('phone_1') || setting('phone_2'))
                            @if (setting('phone_1'))
                                <li>
                                    <a href="mailto:{{ setting('phone_1') }}">
                                        <i class="icon-call"></i> {{ setting('phone_1') }}
                                    </a>
                                </li>
                            @endif
                            @if (setting('phone_2'))
                                <li>
                                    <a href="mailto:{{ setting('phone_2') }}">{{ setting('phone_2') }}</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            @if (setting('enable_multi_lang') == 1 || setting('facebook'))
                <div class="col-md-5">
                    <div class="top-bar-right text-right">
                        <div class="ltn__top-bar-menu">
                            <ul>
                                @if (setting('enable_multi_lang') == 1)
                                    <li>
                                        <!-- ltn__language-menu -->
                                        <div class="ltn__drop-menu ltn__currency-menu ltn__language-menu">
                                            <ul>
                                                <li><a href="#" class="dropdown-toggle"><span
                                                            class="active-currency">Language</span></a>
                                                    <ul>
                                                        <li><a href="#">Bengali</a></li>
                                                        <li><a href="#">English</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                <li>
                                    <!-- ltn__social-media -->
                                    <div class="ltn__social-media">
                                        <ul>
                                            @if (!empty(setting('facebook')))
                                                <li>
                                                    <a href="{{ URL::to(setting('facebook')) }}" title="Facebook"
                                                        target="_blank"><i class="fab fa-facebook-f"></i></a>
                                                </li>
                                            @endif
                                            {{-- <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                        </li> --}}

                                            {{-- <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                                        </li>
                                        <li><a href="#" title="Dribbble"><i class="fab fa-dribbble"></i></a>
                                        </li> --}}
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
