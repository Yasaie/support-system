@extends('layouts.app')
@section('htmlClass',config('app.direction', 'rtl'))

@section('title','- ورود')
@section('description','ورود به صفحه کاربری')
@section('keywords','لاگین,ورود,ساین اپ,ورود به صفحه کاربری')

@section('content')

    <div class="wrapper-page card-box">
        <div class="text-center">
            <a href="{{ config('app.url') }}" title="{{ config('app.name') }}" class="logo-lg">
                <span>{{ config('app.logo.alt') }}</span>
            </a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group row">
                <div class="col-12">
                    <div class="input-group">
                        <input name="username" class="form-control" value="{{ old('username') }}" type="text"
                               placeholder="ایمیل یا شماره همراه" required autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} row">
                <div class="col-12">
                    <div class="input-group">
                        <input name="password" class="form-control" type="password" placeholder="پسورد" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-account-key"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }} row">
                <div class="col-12">
                    <div class="input-group">
                        <input name="captcha" class="form-control" type="text" placeholder="تصویر امنیتی" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-image"></i></span>
                        </div>
                    </div>
                    <div class="text-center position-relative">
                        <img id="captcha" class="mw-100" src="{{ route('captcha') }}" alt="captcha-image">
                        <button class="btn btn-green btn-sm align-middle" type="button"
                                onclick="document.getElementById('captcha').src='{{ route('captcha') }}'+'?rnd='+Math.random();">
                            <span class="fa fa-refresh"></span>
                        </button>
                    </div>
                </div>
            </div>

            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="from-group m-b-5 m-t-5">
                        <div class="col-sm-12">
                            <div class="help-block text-danger">
                                <strong>{{ $error }}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="form-group row">
                <div class="col-12">
                    <div class="checkbox checkbox-primary float-right">
                        <input name="remember" id="checkbox-signup"
                               type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <label for="checkbox-signup">
                            مرا به خاطر بسپار
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <button class="btn btn-primary btn-custom btn-block w-md waves-effect waves-light pull-left"
                            type="submit">
                        ورود
                    </button>
                </div>
            </div>
        </form>
        <div class="form-group row m-t-30">
            <div class="col-sm-6">
                <a href="{{ route('password.request') }}" class="text-muted"><i class="fa fa-lock m-l-5"></i>فراموشی
                    کلمه عبور</a>
            </div>
            @if(getConfig::site_registration_status())
                <div class="col-sm-6">
                    <a href="{{ route('register') }}" class="text-muted"><i class="fa fa-user m-l-5"></i>عضویت</a>
                </div>
            @endif
        </div>
        @if(getConfig::mobile_verification_status())
            <div class="form-group row m-t-30">
                <div class="col-sm-6">
                    <a href="{{ route('verify.pin') }}" class="text-muted"><i class="mdi mdi-account-check"></i>تایید
                        شماره همراه</a>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('verify.request.pin') }}" class="text-muted"><i
                                class="mdi mdi-cellphone-settings"></i>ارسال مجدد کد تایید</a>
                </div>
            </div>
        @endif
    </div>

@section('bodyImport.plugin.append')
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
@endsection

@endsection
