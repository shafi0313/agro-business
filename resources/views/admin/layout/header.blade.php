<nav class="navbar navbar-header navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse" id="search-nav">
            <form class="navbar-left navbar-form nav-search mr-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pr-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Search ..." class="form-control">
                </div>
            </form>
        </div>

        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item toggle-nav-search hidden-caret">
                <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                    <i class="fa fa-search"></i>
                </a>
            </li>

            @if (config('app.locale')=='en')
            <li title="If you change the language click this button"><a class="btn btn-primary" style="color: white !important" href="/locale/bn">বাংলা <i
                        class="fas fa-language" style="color: white"></i></a></li>
            @else
            <li title="If you change the language click this button"><a class="btn btn-primary" style="color: white !important" href="/locale/en">English <i
                        class="fas fa-language" style="color: white"></i></a></li>
            @endif
            {{-- <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                    <li>
                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                            Messages
                            <a href="#" class="small">Mark all as read</a>
                        </div>
                    </li>
                    <li>
                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="{{asset('backend/assets/img/jm_denis.jpg')}}" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Jimmy Denis</span>
                                        <span class="block">
                                            How are you ?
                                        </span>
                                        <span class="time">5 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="{{asset('backend/assets/img/chadengle.jpg')}}" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Chad</span>
                                        <span class="block">
                                            Ok, Thanks !
                                        </span>
                                        <span class="time">12 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="{{asset('backend/assets/img/mlane.jpg')}}" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Jhon Doe</span>
                                        <span class="block">
                                            Ready for the meeting today...
                                        </span>
                                        <span class="time">12 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="{{asset('backend/assets/img/talha.jpg')}}" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="subject">Talha</span>
                                        <span class="block">
                                            Hi, Apa Kabar ?
                                        </span>
                                        <span class="time">17 minutes ago</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="nav-item dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">You have 4 new notification</div>
                    </li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            New user registered
                                        </span>
                                        <span class="time">5 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Rahmad commented on Admin
                                        </span>
                                        <span class="time">12 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="{{asset('backend/assets/img/profile2.jpg')}}" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Reza send messages to you
                                        </span>
                                        <span class="time">12 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Farrah liked Admin
                                        </span>
                                        <span class="time">17 minutes ago</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </li> --}}

        @php
            $licenseNotify = App\Models\ProductLicense::where('renewal_date','<=', date('ymd')-1)->count();
            $licenseExs = App\Models\ProductLicense::where('renewal_date','<=', date('ymd')-1)->get();
        @endphp
        <style>
        .notif-icon{
            font-size: 12px !important;
            width: 25px !important;
            height: 25px !important;
        }
        </style>
            <li class="nav-item dropdown hidden-caret mr-5">
                <a class="nav-link dropdown-toggle" href="{{route('product-license.index')}}" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    License <i class="fa fa-bell"></i>
                    <span class="notification">{{$licenseNotify}}</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">You have {{$licenseNotify}} new notification</div>
                    </li>
                    @foreach ($licenseExs as $licenseEx)
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="{{route('product-license.show', $licenseEx->license_cat_id)}}">
                                    <div class="notif-icon notif-danger"> <i class="fas fa-skull-crossbones"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            {{$licenseEx->product->name}} ({{ \Carbon\Carbon::parse($licenseEx->expired_date)->format('d/m/Y') }})
                                        </span>
                                        {{-- <span class="time">5 minutes ago</span> --}}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach



                    {{-- <li>
                        <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
                    </li> --}}
                </ul>
            </li>

            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ imagePath('user', user()->profile_photo_path) }}" class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <li>
                        <div class="user-box">
                            <div class="avatar-lg">
                                <img src="{{ imagePath('user', user()->profile_photo_path) }}" class="avatar-img rounded">
                            </div>
                            <div class="u-text">
                                <h4>{{ Auth::user()->name }}</h4>{{ user()->profile_photo_path }}
                                <p class="text-muted">{{ Auth::user()->email }}</p><a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.myProfile.resetPassdord.create') }}">Change Password</a>
                        {{-- <a class="dropdown-item" href="#">My Balance</a>
                        <a class="dropdown-item" href="#">Inbox</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Account Setting</a> --}}
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
