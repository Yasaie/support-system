@extends('layouts.app')

@section('title','- تنظیمات پیامک')
@section('description','تنظیمات پیامک')
@section('keywords','تنظیمات پیامک')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css">

@endsection
@section('bodyClass','fixed-left')

@section('content')

    <!-- Begin wrapper -->

    <div id="wrapper">
        <!-- Top Bar Start -->
        @include('layouts.topbar')
        <!-- Top Bar End -->

        <!-- Left Sidebar Start -->
        @include('layouts.sidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Right Content start -->
        <!-- ============================================================== -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- System Message Start -->
                    @include('layouts.systemMessage')
                    <!-- System message End-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box clearfix">
                                <h5 class="card-header m-b-20 b-0">تنظیمات پیامک</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('config.sms.update') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-group {{ $errors->has('site_sms_username') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_sms_username">نام کاربری</label>
                                        <div class="col-sm-10">
                                            <input name="site_sms_username" class="form-control" id="site_sms_username" value="{{ config('sms.username') }}" type="text" placeholder="username">
                                            @if ($errors->has('site_sms_username'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_sms_username') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_sms_password') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_sms_password">کلمه عبور</label>
                                        <div class="col-sm-10">
                                            <input name="site_sms_password" class="form-control" id="site_sms_password" value="{{ config('sms.password') }}" type="password" placeholder="password">
                                            @if ($errors->has('site_sms_password'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_sms_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_sms_number') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_sms_number">شماره خط</label>
                                        <div class="col-sm-10">
                                            <input name="site_sms_number" class="form-control" id="site_sms_number" value="{{ config('sms.number') }}" type="text" placeholder="number">
                                            @if ($errors->has('site_sms_number'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_sms_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group clearfix m-0">
                                        <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block m-r-5" type="submit">ذخیره تنظیمات</button>
                                        @can('index',App\SmsLog::class)
                                        <a href="{{ route('log.sms.index') }}" target="_blank" class="btn btn-primary w-md waves-effect waves-light float-left btn-xs-block m-r-5">لاگ موارد ارسال شده</a>
                                        @endcan
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end container -->
            </div>
            <!-- end content -->

            <!-- footer Start -->
            @include('layouts.footer')
            <!-- footer End -->

        </div>

        <!-- ============================================================== -->
        <!-- Right content end -->
        <!-- ============================================================== -->

        <!-- Right Sidebar start -->
        @include('layouts.sidebar_right')
        <!-- Right Sidebar end -->

    </div>

    <!-- END wrapper -->
    <script>
        var resizefunc = [];
    </script>

@endsection

@section('bodyImport.plugin.prepend')

    <script src="{{ asset('js/detect.js') }}"></script>
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}"></script>

@endsection

@section('bodyImport.plugin.append')

    <script src="{{ asset('js/detect.js') }}"></script>
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <!-- Notification js -->
    <script src="{{ asset('plugins/notifyjs/dist/notify.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/notify-metro.js') }}"></script>
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script type="text/javascript">
        $(function () {

            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $('[data-toggle=tooltip]').tooltip();

            $('.float-save-btn').click(function () {
                $('button[type=submit]').click();
            });
            /*
            $('form').submit(function (e) {
                e.preventDefault();
                console.log('test');
                var btn = $(this).find('button[type=submit]');
                var floatBTN = $('.float-save-btn');
                btn.attr('disabled', 'disabled');
                btn.toggleClass('btn-success btn-secondary');
                btn.html('<i class="fa fa-spinner fa-spin"></i>');
                floatBTN.html('<i class="fa fa-spinner fa-spin"></i>');
                setTimeout(function () {
                    $.Notification.autoHideNotify('success', 'top left', 'انجام شد', 'تنظیمات با موفقیت ذخیره شد');
                    btn.removeAttr('disabled');
                    btn.html('ذخیره تنظیمات');
                    floatBTN.html('<i class="fa fa-save fa-fw"></i>');
                    btn.toggleClass('btn-success btn-secondary');
                }, 5000);
            });
            */
            $('.testSMTP').click(function () {
                var btn = $(this);
                btn.attr('disabled', 'disabled');
                btn.html('<i class="fa fa-spinner fa-spin"></i>');
                setTimeout(function () {
                    btn.removeAttr('disabled');
                    btn.html('تست مجدد');
                    $('#SMTPTestResult').html('SMTP test results go here');
                }, 3000);
            });
        });//doc
    </script>

@endsection
