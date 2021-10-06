@extends('layouts.app')

@section('title','- تایید هویت پست الکترونیک')
@section('description','تایید هویت پست الکترونیک')
@section('keywords','تایید هویت با توکن,تایید هویت ایمیلی,تایید هویت ایمیل,تایید هویت email')

@section('htmlClass',config('app.direction', 'rtl'))
@section('content')

    <div class="wrapper-page card-box">
        <h5 class="text-center m-t-10 text-uppercase font-bold m-b-0">تایید پست الکترونیک</h5>

        <div class="text-center">
            <img src="{{ asset('images/mail_confirm.png') }}" alt="img" class="thumb-lg m-t-20 center-block">
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="m-t-20">
            <p>ایمیل به منظور تایید و فعالسازی حساب کاربری برای شما ارسال شد لطفا پست الکترونیک خود را بررسی کنید</p>
        </div>

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
