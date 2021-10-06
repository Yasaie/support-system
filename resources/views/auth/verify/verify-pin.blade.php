@extends('layouts.app')

@section('title','- تایید هویت')
@section('description','تایید هویت')
@section('keywords','تایید هویت پیامکی,تایید هویت شماره همراه, تایید هویت با sms')

@section('htmlClass',config('app.direction', 'rtl'))
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

        <form class="form-horizontal m-t-20" method="POST" action="{{ route('verify.pin') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('pin') ? ' has-error' : '' }} row">
                <div class="col-12">
                    <div class="input-group">
                        <input name="pin" class="form-control" type="text" placeholder="کد تایید را وارد کنید" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-key"></i></span>
                        </div>
                    </div>
                    @if ($errors->has('pin'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('pin') }}</strong>
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
                        تایید هویت شماره همراه
                    </button>
                </div>
            </div>
        </form>
        <div class="form-group row m-t-30">
            <div class="col-sm-8">
                <a href="{{ route('password.request.pin') }}" class="text-muted"><i class="fa fa-lock m-l-5"></i>فراموشی کلمه عبور</a>
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
