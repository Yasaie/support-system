<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                @if(config('app.landingPage.status'))
                <a href="{{ route('main') }}" class="logo">
                    <span class="logo-small"><i class="mdi mdi-looks"></i></span>
                    <span class="logo-large"><i class="mdi mdi-looks"></i> {{ config('app.logo.alt') }} </span>
                </a>
                @else
                <a href="{{ route('panel') }}" class="logo">
                    <span class="logo-small"><i class="mdi mdi-looks"></i></span>
                    <span class="logo-large"><i class="mdi mdi-looks"></i> {{ config('app.logo.alt') }} </span>
                </a>
                @endif
            </div>
            <!-- End Logo container-->


            <div class="menu-extras topbar-custom">
                <ul class="list-inline float-left mb-0">

                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    @inject('notificationDataController','App\Http\Controllers\Notification\DataController')
                    @php
                        $newNotifications=$notificationDataController::newNotifications();
                    @endphp
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="mdi mdi-bell noti-icon"></i>
                            <span class="badge badge-pink noti-icon-badge">
                                {{ $newNotifications->count() }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg" aria-labelledby="Preview">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="font-16">
                                    <span class="badge badge-danger float-left">{{ $newNotifications->count() }}</span>
                                    <span>اطلاعیه ها</span>
                                </h5>
                            </div>
                            @if($newNotifications->isNotEmpty())
                                @foreach($newNotifications as $notification)
                                <!-- item-->
                                <a href="{{ route('notification.show',$notification) }}" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-success"><i class="mdi mdi-comment-account"></i></div>
                                    <div class="notify-details">
                                        @if($notification->user)
                                        {{ $notification->user->name.' - '.$notification->subject }}
                                        @else
                                        {{ ' سیستم '.' - '.$notification->subject }}
                                        @endif
                                        <small class="text-muted">{{ Date::make($notification->created_at)->toJalali()->format('Y/m/d') }}</small>
                                    </div>
                                </a>
                                @endforeach
                            @else
                            <div class=" dropdown-item notify-item">
                                <p class="alert alert-info">
                                شما هیچ اطلاعیه و پیامی ندارید
                                </p>
                            </div>
                            @endif
                            <!-- All-->
                            <a href="{{ route('notification.inbox') }}" class="dropdown-item notify-item notify-all">
                                نمایش همه
                            </a>

                        </div>
                    </li>


                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="@user('avatar_url')" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="text-overflow"><small>@user('name')</small> </h5>
                            </div>

                            <!-- item-->
                            <a href="{{ route('user.show',Auth::id()) }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-account"></i> <span>پروفایل</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout"></i> <span>خروج</span>
                            </a>

                        </div>
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="has-submenu {{ (Request::is('panel') ? 'active' : '') }}">
                        <a href="{{ route('panel') }}"><i class="ti-dashboard"></i>پیشخوان</a>
                    </li>
                    <li class="has-submenu {{ (Request::is('panel/ticket') || Request::is('panel/ticket/*') ? 'active' : '') }}">
                        <a href="{{ route('ticket.create') }}"><i class="ti-pencil-alt"></i>ایجاد تیکت</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('main') }}"><i class="ti-home"></i>صفحه اصلی</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('faq.landing') }}"><i class="ti-info-alt"></i>سوالات متداول</a>
                    </li>
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
