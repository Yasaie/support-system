@extends('layouts.app')
@section('htmlClass',config('app.direction', 'rtl'))

@section('title','- ثبت نام')
@section('description','ثبت نام و عضویت')
@section('keywords','ثبت نام,عضویت,عضویت در سایت,ثبت نام در سایت')

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
        @if(config('app.registration.status'))
            <form class="form-horizontal m-t-20" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <p class="form-text text-muted">تکمیل بخش هایی که با علامت ستاره(*) مشخص شده اند الزامیست</p>
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} row">
                    <div class="col-12">
                        <div class="input-group">
                            <input name="name" value="{{ old('name') }}" class="form-control" type="text" placeholder="نام و نام خانوادگی*" required autofocus>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }} row">
                    <div class="col-12">
                        <div class="input-group">
                            @if(config('mobile.verification.status'))
                            <input name="mobile" value="{{ old('mobile') }}" class="form-control" type="text" placeholder="شماره همراه*" required>
                            @else
                            <input name="mobile" value="{{ old('mobile') }}" class="form-control" type="text" placeholder="شماره همراه">
                            @endif
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-cellphone-android"></i></span>
                            </div>
                        </div>
                        @if ($errors->has('mobile'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} row">
                    <div class="col-12">
                        <div class="input-group">
                            @if(config('email.verification.status'))
                            <input name="email" value="{{ old('email') }}" class="form-control" type="email" placeholder="ایمیل*" required>
                            @else
                            <input name="email" value="{{ old('email') }}" class="form-control" type="email" placeholder="ایمیل">
                            @endif
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} row">
                    <div class="col-12">
                        <div class="input-group">
                            <input name="password" class="form-control" type="password" placeholder="کلمه عبور" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-account-key"></i></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="input-group">
                            <input name="password_confirmation" class="form-control" type="password" placeholder="تکرار کلمه عبور" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-key-plus"></i></span>
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
                            <button class="btn btn-green btn-sm align-middle" type="button" onclick="document.getElementById('captcha').src='{{ route('captcha') }}'+'?rnd='+Math.random();">
                                <span class="fa fa-refresh"></span>
                            </button>
                        </div>
                    </div>
                    @if ($errors->has('captcha'))
                        <div class="col-12">
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('captcha') }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('rules') ? 'has-error' : '' }} row">
                    <div class="col-12">
                        <div class="checkbox checkbox-primary float-right">
                            <input name="rules" id="checkbox-signup" type="checkbox"{{ (old('rules')?' checked ':'') }}>
                            <label for="checkbox-signup">
                                <a data-toggle="modal" data-target="#rulesModal" href="#rulesModal" >
                                    قوانین و مقررات
                                </a>
                                را پذیرفتم.
                            </label>
                        </div>
                    </div>
                    @if ($errors->has('rules'))
                        <div class="col-12">
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('rules') }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-custom btn-block w-md waves-effect waves-light pull-left" type="submit">
                            ثبت نام
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center alert alert-secondary">
                {{ trans('auth.site_registration_not_active') }}
            </div>
        @endif
        <div class="form-group row m-t-30">
            <div class="col-sm-7">
                <a href="{{ route('login') }}" class="text-muted"><i class="fa fa-backward m-l-5"></i>بازگشت به ورود</a>
            </div>
            <div class="col-sm-5">
                <a href="{{ route('password.request') }}" class="text-muted"><i class="fa fa-lock m-l-5"></i>فراموشی کلمه عبور</a>
            </div>
        </div>

    </div>

    <script>
        var resizefunc = [];
    </script>

    @include('layouts.rulesModal')

    @section('bodyImport.plugin.append')
    <script src="{{ asset('js/detect.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    @endsection

@endsection
