@extends('layouts.app')
@section('htmlClass',config('app.direction', 'rtl'))

@section('title','- بازیابی کلمه عبور')
@section('description','بازیابی کلمه عبور')
@section('keywords','بازیابی کلمه عبور,بازیابی پسوورد,ریست پسوورد,کلمه عبور را فراموش کرده ام')

@section('content')

    <div class="wrapper-page card-box clearfix">
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

        <p class="text-muted mt-2">اطلاعات خواسته شده را تکمیل نمایید.ما برای شما کلمه عبور جدیدتان را ارسال می کنیم</p>

        <form method="post" action="{{ route('password.request.token') }}" role="form" class="text-center m-t-20">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} m-b-0">
                <div class="input-group">
                    <input name="email" value="{{ old('email') }}" type="email" class="form-control" placeholder="ایمیل" required>
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-primary waves-effect waves-light resetBTN">بازیابی</button>
                    </span>
                </div>
                @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }}">
                <div class="input-group">
                    <input name="captcha" class="form-control" type="text" placeholder="تصویر امنیتی">
                </div>
                @if ($errors->has('captcha'))
                    <div class="col-12">
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                    </div>
                @endif
            </div>
        </form>

        <!-- Show if admin has allowed "reset password by SMS" -->
        <p class="text-center text-primary">یا</p>

        <form method="post" action="{{ route('password.request.pin') }}" role="form" class="text-center m-t-20">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }} m-t-5">
                <div class="input-group">
                    <input name="mobile" value="{{ old('mobile') }}" type="text" class="form-control" placeholder="شماره همراه" required>
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-primary waves-effect waves-light resetBTN">بازیابی</button>
                    </span>
                </div>
                @if ($errors->has('mobile'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }}">
                <div class="input-group">
                    <input name="captcha" class="form-control" type="text" placeholder="تصویر امنیتی" required>
                </div>
                @if ($errors->has('captcha'))
                    <div class="col-md-12">
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                    </div>
                @endif
            </div>
        </form>

        <div class="form-group row">
            <div class="col-12">
                <div class="text-center position-relative">
                    <img id="captcha" class="mw-100" src="{{ route('captcha') }}" alt="captcha-image">
                    <button class="btn btn-green btn-sm align-middle" type="button" onclick="document.getElementById('captcha').src='{{ route('captcha') }}'+'?rnd='+Math.random();">
                        <span class="fa fa-refresh"></span>
                    </button>
                </div>
            </div>
        </div>

        <a href="{{ route('login') }}" class="btn btn-sm btn-secondary pull-left mt2">بازگشت به ورود</a>
    </div>

    @section('bodyImport.plugin.append')
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    @endsection

@endsection
