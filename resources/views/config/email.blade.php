@extends('layouts.app')

@section('title','- تنظیمات ایمیل')
@section('description','تنظیمات ایمیل')
@section('keywords','تنظیمات ایمیل')

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
                                <h5 class="card-header m-b-20 b-0">تنظیمات ایمیل</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('config.email.update') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-group {{ $errors->has('site_main_email') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_main_email">ایمیل سایت</label>
                                        <div class="col-sm-10">
                                            <input name="site_main_email" class="form-control" id="site_main_email" value="{{ config('mail.from.address') }}" type="text" placeholder="به عنوان مثال : info@site.com">
                                            @if ($errors->has('site_main_email'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_main_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_activities_email') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_activities_email">ایمیل فعالیت</label>
                                        <div class="col-sm-10">
                                            <input name="site_activities_email" class="form-control m-b-5" id="site_activities_email" value="{{ config('mail.from.activitiesAddress') }}" type="text" placeholder="به عنوان مثال : no-reply@site.com">
                                            @if ($errors->has('site_activities_email'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_activities_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_smtp_server') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_smtp_server">SMTP Server</label>
                                        <div class="col-sm-10">
                                            <input name="site_smtp_server" class="form-control" id="site_smtp_server" value="{{ config('mail.host') }}" type="text" placeholder="SMTP server config, example: localhost">
                                            @if ($errors->has('site_smtp_server'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_smtp_server') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_smtp_port') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_smtp_port">SMTP Port</label>
                                        <div class="col-sm-10">
                                            <input name="site_smtp_port" class="form-control" id="site_smtp_port" value="{{ config('mail.port') }}" type="text" placeholder="SMTP port , example: 487">
                                            @if ($errors->has('site_smtp_port'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_smtp_port') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_smtp_username') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_smtp_username">SMTP Username</label>
                                        <div class="col-sm-10">
                                            <input name="site_smtp_username" class="form-control" id="site_smtp_username" value="{{ config('mail.username') }}" type="text" placeholder="SMTP username">
                                            @if ($errors->has('site_smtp_username'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_smtp_username') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_smtp_password') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_smtp_password">SMTP Password</label>
                                        <div class="col-sm-10">
                                            <input name="site_smtp_password" class="form-control" id="site_smtp_password" value="{{ config('mail.password') }}" type="password" placeholder="SMTP password">
                                            @if ($errors->has('site_smtp_password'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_smtp_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group clearfix m-0">
                                        <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block m-r-5" type="submit">ذخیره تنظیمات</button>
                                    </div>
                                </form>
                                <pre id="SMTPTestResult"></pre>
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
