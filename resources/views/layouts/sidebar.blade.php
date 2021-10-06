<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">منو</li>
                <li>
                    <a href="{{ route('panel') }}" class="waves-effect waves-primary">
                        <i class="ti-home"></i>
                        <span> پیشخوان </span>
                    </a>
                </li>
                @can('index', App\Ticket::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-ticket"></i>
                        <span> تیکت ها </span>
                        @inject('ticketStatisticsController','App\Http\Controllers\Ticket\StatisticsController')
                        @if($ticketStatisticsController::countAll())
                        <span class="badge badge-primary pull-left">
                            {{ number_format($ticketStatisticsController::countAll()) }}
                        </span>
                        @endif
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('ticket.index') }}">لیست تیکت ها</a></li>
                        @can('garbage',App\Ticket::class)
                        <li><a href="{{ route('ticket.garbage') }}">زباله دانی</a></li>
                        @endcan
                        @can('create',App\Ticket::class)
                        <li><a href="{{ route('ticket.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @inject('departmentStatistics','App\Http\Controllers\Department\StatisticsController)
                @can('index',App\Department::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-desktop"></i>
                        <span>دپارتمان ها</span>
                        @if($departmentStatistics::countAll())
                            <span class="badge badge-primary pull-left">
                                {{ number_format($departmentStatistics::countAll()) }}
                            </span>
                        @endif
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('department.index') }}">لیست دپارتمان ها</a></li>
                        @can('create',App\Department::class)
                        <li><a href="{{ route('department.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\User::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-user"></i>
                        <span>کاربران</span>
                        @if(App\User::whereDoesntHave('departments')->where('id','<>',Auth::id())->count())
                        <span class="badge badge-primary pull-left">
                            {{ number_format(App\User::whereDoesntHave('departments')->where('id','<>',Auth::id())->count()) }}
                        </span>
                        @endif
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('user.index') }}">لیست کاربران</a></li>
                        @can('garbage',App\User::class)
                        <li><a href="{{ route('user.garbage') }}">زباله دانی</a></li>
                        @endcan
                        @can('create',App\User::class)
                        <li><a href="{{ route('user.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('staffIndex',App\User::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-headphone-alt"></i>
                        <span> پشتیبانان</span>
                        @if($departmentStatistics::staffCount())
                            <span class="badge badge-primary pull-left">
                                {{ number_format($departmentStatistics::staffCount()) }}
                            </span>
                        @endif
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('staff.index') }}">لیست پشتیبانان</a></li>
                        @can('staffCreate',App\User::class)
                        <li><a href="{{ route('staff.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\News::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-announcement"></i>
                        <span>اخبار و اطلاعیه ها</span>
                        @inject('newsStatisticesController','App\Http\Controllers\News\statisticesController')
                        @if($newsStatisticesController::count())
                            <span class="badge badge-primary pull-left">
                                {{ number_format($newsStatisticesController::count()) }}
                            </span>
                        @endif
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('news.index') }}">لیست اخبار و اطلاعیه ها</a></li>
                        @can('create',App\News::class)
                        <li><a href="{{ route('news.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('inbox',App\Notification::class)

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-signal"></i>
                        <span>اعلانات</span>

                        @inject('notificationDataController','App\Http\Controllers\Notification\DataController')

                        @if($notificationDataController::newNotificationsCount())
                        <span class="badge badge-primary pull-left">{{ $notificationDataController::newNotificationsCount() }}</span>
                        @endif

                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('notification.inbox') }}">دریافتی</a></li>
                        @can('index',App\Notification::class)
                        <li><a href="{{ route('notification.index') }}">ارسال شده</a></li>
                        @endcan
                        @can('garbage',App\Notification::class)
                        <li><a href="{{ route('notification.garbage') }}">زباله دانی</a></li>
                        @endcan
                        @can('create',App\Notification::class)
                        <li><a href="{{ route('notification.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\SmsLog::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-layout-media-right-alt"></i>
                        <span>گزارش ها</span>
                    </a>
                    <ul class="list-unstyled">
                        @can('index',App\View::class)
                        <li><a href="{{ route('log.view.index') }}">بازدیدها</a></li>
                        @endcan
                        @can('index',App\SmsLog::class)
                        <li><a href="{{ route('log.sms.index') }}">لیست sms ها</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\Faq::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-themify-favicon"></i>
                        <span>سوالات متداول</span>
                        @if(App\Faq::count())
                        <span class="badge badge-primary pull-left">{{ App\Faq::count() }}</span>
                        @endif
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('faq.index') }}">لیست سوالات</a></li>
                        @can('create',App\Faq::class)
                        <li><a href="{{ route('faq.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\Role::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-medall"></i>
                        <span>انواع کاربری</span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('role.index') }}">لیست انواع کاربری</a></li>
                        @can('create',App\Role::class)
                        <li><a href="{{ route('role.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\Country::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-map-alt"></i>
                        <span>کشورها</span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('country.index') }}">لیست کشورها</a></li>
                        @can('create',App\Country::class)
                        <li><a href="{{ route('country.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\Province::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-direction-alt"></i>
                        <span>استان ها</span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('province.index') }}">لیست استان ها</a></li>
                        @can('create',App\Province::class)
                        <li><a href="{{ route('province.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('index',App\City::class)
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect waves-primary">
                        <i class="ti-direction"></i>
                        <span>شهرها</span>
                    </a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('city.index') }}">لیست شهرها</a></li>
                        @can('create',App\City::class)
                        <li><a href="{{ route('city.create') }}">افزودن</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('general',App\Config::class)
                <li class="menu-title">تنظیمات</li>
                <li>
                    <a href="{{ route('config.general') }}" class="waves-effect waves-primary">
                        <i class="ti-panel"></i>
                        <span> تنظیمات عمومی </span>
                    </a>
                </li>
                @endcan
                @can('email',App\Config::class)
                <li>
                    <a href="{{ route('config.email') }}" class="waves-effect waves-primary">
                        <i class="ti-email"></i>
                        <span> تنظیمات ایمیل </span>
                    </a>
                </li>
                @endcan
                @can('ticket',App\Config::class)
                <li>
                    <a href="{{ route('config.ticket') }}" class="waves-effect waves-primary">
                        <i class="ti-settings"></i>
                        <span> تنظیمات تیکت ها </span>
                    </a>
                </li>
                @endcan
                @can('sms',App\Config::class)
                <li>
                    <a href="{{ route('config.sms') }}" class="waves-effect waves-primary">
                        <i class="ti-comment-alt"></i>
                        <span> تنظیمات پیامک </span>
                    </a>
                </li>
                @endcan
                @can('template',App\Config::class)
                <li>
                    <a href="{{ route('config.template') }}" class="waves-effect waves-primary">
                        <i class="ti-paint-roller"></i>
                        <span> طراحی و قالب </span>
                    </a>
                </li>
                @endcan
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>