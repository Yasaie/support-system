@extends('layouts.app')
@section('htmlClass',config('app.direction', 'rtl'))

@section('title','- بازیابی کلمه عبور')
@section('description','بازیابی کلمه عبور')
@section('keywords','بازیابی کلمه عبور,بازیابی پسوورد,ریست پسوورد,کلمه عبور را فراموش کرده ام')

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

        <form class="form-horizontal m-t-20" method="POST" action="{{ route('password.request.token') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} row">
                <div class="col-12">
                    <div class="input-group">
                        <input name="email" value="{{ old('email') }}" class="form-control" type="email" placeholder="ایمیل" required autofocus>
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
            <div class="form-group row">
                <div class="col-12">
                    <button class="btn btn-primary btn-custom btn-block w-md waves-effect waves-light pull-left" type="submit">
                        دریافت ایمیل بازیابی
                    </button>
                </div>
            </div>
        </form>
        <div class="form-group row m-t-30">
            <div class="col-sm-8">
                <a href="{{ route('login') }}" class="text-muted"><i class="fa fa-backward m-l-5"></i>بازگشت به ورود</a>
            </div>
            <div class="col-sm-4">
                <a href="{{ route('register') }}" class="text-muted"><i class="fa fa-user m-l-5"></i>عضویت</a>
            </div>
        </div>
    </div>

    @section('bodyImport.plugin.append')
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    @endsection

@endsection
