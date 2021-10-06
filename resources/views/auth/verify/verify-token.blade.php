@extends('layouts.app')

@section('title','- تایید هویت')
@section('description','تایید هویت')
@section('keywords','تایید هویت با توکن,تایید هویت ایمیلی,تایید هویت ایمیل,تایید هویت email')

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

        <form class="form-horizontal" method="POST" action="{{ route('verify') }}">
            {{ csrf_field() }}

            <div class="text-center">
                <img src="{{ asset('images/mail_confirm.png') }}" alt="img" class="thumb-lg m-t-20 center-block">
            </div>

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('token') ? ' has-error' : '' }}">
                <div class="col-12">
                    @if ($errors->has('token'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('token') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <button class="btn btn-primary btn-custom btn-block w-md waves-effect waves-light pull-left" type="submit">
                        تایید هویت ایمیل شما
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
