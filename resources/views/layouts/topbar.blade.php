<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            @if(config('app.landingPage.status'))
            <a href="{{ route('main') }}" class="logo"><i class="mdi mdi-ticket"></i> <span>{{ config('app.logo.alt') }}</span></a>
            @else
            <a href="{{ route('panel') }}" class="logo"><i class="mdi mdi-ticket"></i> <span>{{ config('app.logo.alt') }}</span></a>
            @endif
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <nav class="navbar-custom">

        <ul class="list-inline float-left mb-0">

            <li class="list-inline-item notification-list hide-phone">
                <a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
                    <i class="mdi mdi-crop-free noti-icon"></i>
                </a>
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
                        <h5 class="text-overflow"><small>@user('name')</small></h5>
                    </div>

                    <!-- item-->
                    <a href="{{ route('user.edit',Auth::id()) }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-account"></i> <span>پروفایل</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout"></i> <span>خروج</span>
                    </a>

                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-right">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
            <li class="hide-phone app-search">
                <form method="get" action="{{ route('ticket.index') }}" role="search">
                    <input type="text" name="search" placeholder="جستجو..." class="form-control">
                    <a href="javascript:void(0)" onclick="this.parentNode.parentNode.submit()"><i class="fa fa-search"></i></a>
                </form>
            </li>
        </ul>

    </nav>

</div>