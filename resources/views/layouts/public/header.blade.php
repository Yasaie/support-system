<header @if(!Request::is('/'))  class="mb-4" @endif>
    <!-- Start Desktop Nav -->
    <div class="d-none d-sm-block" id="noneMobileHeader">
        <div class="header-top container clearfix">
            @if(config('app.logo.src'))
                <div class="logo-container">
                    <a title="صفحه اصلی" href="{{ route('main') }}">
                        <img src="{{ config('app.logo.src') }}" class="logo" alt="{{ config('app.logo.alt') }}">
                    </a>
                </div>
            @endif
            @if(Auth::check())
                <div class="pull-left pt-4">
                    <!-- Example split danger button -->
                    <div class="btn-group">
                        <a href="{{ route('panel') }}" class="btn btn-light">@user('name')</a>
                        <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">لیست را باز کن</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('panel') }}">پیشخوان</a>
                            <a class="dropdown-item" href="{{ route('user.edit',Auth::id()) }}">ویرایش پروفایل</a>
                            <a class="dropdown-item" href="{{ route('config.general') }}">تنظیمات</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}">خروج</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="pull-left pt-4">
                    <a href="{{ route('login') }}" class="btn btn-sm w-md btn-secondary">ورود</a>
                    <a href="{{ route('register') }}" class="btn btn-sm w-md btn-outline-secondary">ثبت نام</a>
                </div>
            @endif
        </div>
        <div class="header-nav">
            <div class="nav-container container">
                <nav>
                    <ul>
                        @if(config('app.landingPage.status'))
                            <li>
                                <a href="{{ route('main') }}" class="{{ (Request::is('/') ? 'active' : '') }}">صفحه
                                    اصلی</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('news.landing') }}"
                               class="{{ (Request::is('news') || Request::is('news/*') ? 'active' : '') }}">اخبار</a>
                        </li>
                        <li>
                            <a href="{{ route('faq.landing') }}"
                               class="{{ (Request::is('faq') || Request::is('faq/*') ? 'active' : '') }}">سوالات
                                متداول</a>
                        </li>
                    </ul>
                </nav>
                @if(config('main.url'))
                    @unless(Request::is(config('main.url')))
                    <a class="btn btn-link pull-left pt-4 pr-0" title="صفحه اصلی" href="{{ config('main.url') }}">بازگشت به وبسایت اصلی<span class="ti-arrow-left align-middle pl-2"></span></a>
                    @endunless
                @endif
            </div>
        </div>
    </div>
    <!-- End Desktop Nav -->
    <!-- Start Mobile Nav -->
    <div class="clearfix d-xs-block d-sm-none fixed-top" id="MobileHeader">
        <nav class="mobile-nav">
            <button class="mobile-nav-toggle"><span class="ti-menu"></span></button>
            @if(Auth::check())
                <a href="{{ route('panel') }}" class="mobile-account-icon"><span class="ti-user"></span>حساب کاربری</a>
            @else
                <a href="{{ route('login') }}" class="mobile-account-icon"><span class="ti-key"></span>ورود</a>
                <a href="{{ route('register') }}" class="mobile-account-icon"><span class="ti-user"></span>ثبت نام</a>
            @endif
            <ul style="display: none;">
                @if(config('app.landingPage.status'))
                    <li>
                        <a href="{{ route('main') }}" class="{{ (Request::is('/') ? 'active' : '') }}">صفحه اصلی</a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('news.landing') }}"
                       class="{{ (Request::is('news') || Request::is('news/*') ? 'active' : '') }}">اخبار</a>
                </li>
                <li>
                    <a href="{{ route('faq.landing') }}"
                       class="{{ (Request::is('faq') || Request::is('faq/*') ? 'active' : '') }}">سوالات متداول</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End Mobile Nav -->
    <!-- Start Banner -->
    <div class="main-banner">
        <div class="banner-content">
            <div class="container">
                <h1 class="site-logo">{{ config('app.logo.alt') }}</h1>
                <h3>به بخش پشتیبانی خوش آمدید</h3>
                <div class="search-section">
                    <form action="{{ route('news.landing') }}" method="get" role="form">
                        <input type="search" value="{{ old('search') }}"
                               placeholder="به دنبال چه چیزی می گردید؟جست و جو کنید..." class="search-field"/>
                        <i class="ti-search search-field-icon" onclick="this.parentNode.submit()"></i>
                    </form>
                </div>
                @if(Route::is('main'))
                <div class="work-hours row">
                    <div class="col-sm-4">
                        <span class="ti-calendar"></span>
                        <span>{{ config('widget1.title') }}</span>
                        <p>{{ config('widget1.content') }}</p>
                    </div>
                    <div class="col-sm-4">
                        <span class="ti-time"></span>
                        <span>{{ config('widget2.title') }}</span>
                        <p>{{ config('widget2.content') }}</p>
                    </div>
                    <div class="col-sm-4">
                        <span class="ti-headphone-alt"></span>
                        <span>{{ config('widget3.title') }}</span>
                        <p>{{ config('widget3.content') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End banner -->
</header>
