@extends('layouts.app')

@section('title','- ایجاد پشتیبان جدید')
@section('description','ایجاد پشتیبان جدید')
@section('keywords','ایجاد پشتیبان جدید')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/persian-datepicker/persian-datepicker.css') }}">
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
                            <div class="card-box">
                                <h5 class="card-header m-b-20 b-0">افزودن پشتیبان</h5>
                                @include('partial.flashMessage')
                                <form method="POST" class="form-horizontal" action="{{ route('staff.store') }}" role="form">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">نام</label>
                                                <input name="name" type="text" id="name" class="form-control" value="{{ old('name') }}" placeholder="مثال: علی" autofocus required/>
                                            </div>
                                            @if ($errors->has('name'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="email">ایمیل</label>
                                                <input name="email" type="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="مثال: example@domain.com"/>
                                            </div>
                                            @if ($errors->has('email'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                                <label for="mobile">شماره همراه</label>
                                                <input name="mobile" type="text" id="mobile" class="form-control" value="{{ old('mobile') }}" placeholder="مثال: 09123456789"/>
                                            </div>
                                            @if ($errors->has('mobile'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('mobile') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group {{ $errors->has('departments') ? ' has-error' : '' }}">
                                                <select name="departments[]" id="departments" class="select2" data-placeholder="انتخاب دپارتمان"></select>
                                            </div>
                                            @if ($errors->has('departments'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('departments') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        @if((Auth::user()->owner() || Auth::user()->admin()))
                                        <div class="col-xs-12 col-sm-6 order-last">
                                            <div class="form-group {{ $errors->has('locked') ? ' has-error' : '' }} py-2">
                                                <p class="d-inline align-top m-l-15 mb-0">وضعیت : </p>
                                                <div class="radio radio-success form-check-inline">
                                                    <input id="inlineRadio1" value="1" name="locked" {{ (is_null(old('locked')) || old('locked')==true) ? ' checked ' : '' }} type="radio">
                                                    <label for="inlineRadio1"> فعال </label>
                                                </div>
                                                <div class="radio radio-danger form-check-inline">
                                                    <input id="inlineRadio2" value="0" name="locked" {{ (!is_null(old('locked')) && old('locked')==false) ? ' checked ' : '' }} type="radio">
                                                    <label for="inlineRadio2"> غیر فعال </label>
                                                </div>
                                                @if ($errors->has('locked'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('locked') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label for="password">کلمه عبور</label>
                                                <input name="password" type="password" id="password" class="form-control" placeholder="کلمه عبور" required>
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">تکرار کلمه عبور</label>
                                                <input name="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="تکرار کلمه عبور" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                                                <label for="country">کشور</label>
                                                <select name="country" id="country" class="select2" data-placeholder="کشور را وارد کنید"></select>
                                            </div>
                                            @if ($errors->has('country'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group {{ $errors->has('province') ? ' has-error' : '' }}">
                                                <label for="province">استان</label>
                                                <select name="province" id="province" class="select2" data-placeholder="استان را وارد کنید"></select>
                                            </div>
                                            @if ($errors->has('province'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('province') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                                                <label for="city">شهر</label>
                                                <select name="city" id="city" class="select2" data-placeholder="شهر را وارد کنید"></select>
                                            </div>
                                            @if ($errors->has('city'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group {{ $errors->has('biography') ? ' has-error' : '' }}">
                                                <label for="biography">درباره</label>
                                                <textarea name="biography" class="form-control" id="biography" maxlength="250" rows="6" placeholder="درباره کاربر بنویسید...">{{ old('biography') }}</textarea>
                                            </div>
                                            @if ($errors->has('biography'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('biography') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                         <div class="form-group {{ $errors->has('email_verification') ? ' has-error' : '' }} row">
                                            <label class="col-sm-2 col-form-label" for="email_verification" data-toggle="tooltip" title="در صورتی که با ایمیل ثبت نام کرده باشید کاربر ابتدا باید آن را تایید هویت کند">ایمیل نیاز به تایید هویت دارد؟</label>
                                            <div class="col-sm-10">
                                                <input value="1" name="email_verification" type="checkbox" id="email_verification" {{ (old('email_verification')) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                @if ($errors->has('email_verification'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('email_verification') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                         <div class="form-group {{ $errors->has('mobile_verification') ? ' has-error' : '' }} row">
                                            <label class="col-sm-2 col-form-label" for="mobile_verification" data-toggle="tooltip" title="در صورتی که با استفاده از شماره تلفن همراه ثبت نام کرده باشید کاربر ابتدا باید آن را تایید هویت کند">شماره تلفن همراه نیاز به تایید هویت دارد؟</label>
                                            <div class="col-sm-10">
                                                <input value="1" name="mobile_verification" type="checkbox" id="mobile_verification" {{ (old('mobile_verification')) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                @if ($errors->has('mobile_verification'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('mobile_verification') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-success btn-custom btn-xs-block w-md pull-left waves-effect waves-light" type="submit">
                                                ایجاد کن
                                            </button>
                                        </div>
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

    <!--userInfoModel Start-->
    @include('layouts.userInfoModal')
    <!--userInfoModel End-->

    <!--staffInfoModal Start-->
    @include('layouts.staffInfoModal')
    <!--staffInfoModal End-->

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
    <!-- KNOB JS -->
    <!--[if IE]>
    <script src="{{ asset('plugins/jquery-knob/excanvas.js')}}"></script>
    <![endif]-->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.js') }}"></script>
    <!-- Circliful -->
    <script src="{{ asset('plugins/jquery-circliful/js/jquery.circliful.min.js') }}"></script>
    <!-- Modal-Effect -->
    <script src="{{ asset('plugins/custombox/dist/custombox.min.js') }}"></script>
    <script src="{{ asset('plugins/custombox/dist/legacy.min.js') }}"></script>
    <!-- Notification js -->
    <script src="{{ asset('plugins/notifyjs/dist/notify.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/notify-metro.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/js/i18n/'.app()->getLocale().'.js') }}" type="text/javascript"></script>
    <!-- Confirm JS -->
    <script src="{{ asset('plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <!-- Persian Datepicker -->
    <script src="{{ asset('plugins/persian-datepicker/persian-date.js') }}"></script>
    <script src="{{ asset('plugins/persian-datepicker/persian-datepicker.js') }}"></script>
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
@endsection

@section('bodyImport.append')

    <script>
        $(function() {

            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            function htmlentities(s){
                var div = document.createElement('div');
                var text = document.createTextNode(s);
                div.appendChild(text);
                return div.innerHTML;
            }

            $('#departments').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('department.index') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        };
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data, params) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (++params.page) < data.last_page
                            }
                        };
                    }
                },
                multiple: true,
                minimumInputLength: 0,
                // let our custom formatter work
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatDepartment,
                templateSelection: formatDepartmentSelection
            });

            function formatDepartment (repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = "<div class='clearfix'>";

                markup += "<span class='m-r-5 m-l-5'></span>";

                markup += "<span>" + htmlentities(repo.name) + "</span>";

                markup += "</div>";
                return markup;
            }

            function formatDepartmentSelection (repo) {
                elemName=repo.element.getAttribute('data-name');
                return htmlentities(repo.name || elemName);
            }

            function formatRepo (repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = "<div class='clearfix'>";

                markup += "<span class='fa fa-map-pin m-r-5 m-l-5'></span>";

                markup += "<span>" + htmlentities(repo.name || repo.short_name) + "</span>";

                markup += "</div>";
                return markup;
            }

            function formatRepoSelection (repo) {
                return htmlentities(repo.name || repo.short_name);
            }

            $('#country').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('country.list') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        };
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data, params) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (++params.page) < data.last_page
                            }
                        };
                    }
                },
                multiple: false,
                minimumInputLength: 0,
                // let our custom formatter work
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            $('#province').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('province.list') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            country: ($('#country').val() ? $('#country').val() : 'notFound' ),
                            page: params.page || 1
                        };
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data, params) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (++params.page) < data.last_page
                            }
                        };
                    }
                },
                multiple: false,
                minimumInputLength: 0,
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            $('#city').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('city.list') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            province: ($('#province').val() ? $('#province').val() : 'notFound' ),
                            page: params.page || 1
                        };
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data, params) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (++params.page) < data.last_page
                            }
                        };
                    }
                },
                multiple: false,
                minimumInputLength: 0,
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            /*
            $('form').submit(function (e) {
                e.preventDefault();
                var btn = $(this).find('button[type=submit]');
                btn.attr('disabled', 'disabled');
                btn.html('<i class="fa fa-spinner fa-spin"></i>');
                setTimeout(function () {
                    $.Notification.autoHideNotify('success', 'top left', 'ایجاد شد', 'کاربر با موفقیت ایجاد شد');
                    btn.attr('onclick', "location.href='users.php'");
                    btn.removeAttr('disabled');
                    btn.html('<i class="ti-angle-right m-l-10"></i>' + '<span>بازگشت به کاربران </span>');
                    btn.toggleClass('btn-success btn-secondary');
                }, 5000);
            });
            */
        });//doc

    </script>

@endsection
