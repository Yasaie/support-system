@extends('layouts.app')

@section('title','- تنظیمات عمومی')
@section('description','تنظیمات عمومی')
@section('keywords','تنظیمات عمومی')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css">
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
                                <h5 class="card-header m-b-20 b-0">طراحی و قالب</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('config.template.update') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <fieldset>
                                        <legend>
                                            ساعات کار
                                        </legend>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group {{ ($errors->has('widget1_title') || $errors->has('widget1_content')) ? ' has-error' : '' }}">
                                                    <input type="text" class="form-control mb-1" name="widget1_title" id="widget1_title" placeholder="عنوان" value="{{ config('widget1.title') }}"/>
                                                    @if ($errors->has('widget1_title'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('widget1_title') }}</strong>
                                                        </span>
                                                    @endif

                                                    <textarea name="widget1_content" id="widget1_content" cols="30" rows="5" class="form-control" placeholder="محتوا">{{ config('widget1.content') }}</textarea>
                                                    @if ($errors->has('widget1_content'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('widget1_content') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group {{ ($errors->has('widget2_title') || $errors->has('widget2_content')) ? ' has-error' : '' }}">
                                                    <input type="text" class="form-control mb-1" name="widget2_title" id="widget2_title" placeholder="عنوان" value="{{ config('widget2.title') }}"/>
                                                    @if ($errors->has('widget2_title'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('widget2_title') }}</strong>
                                                        </span>
                                                    @endif

                                                    <textarea name="widget2_content" id="widget2_content" cols="30" rows="5" class="form-control" placeholder="محتوا">{{ config('widget2.content') }}</textarea>
                                                    @if ($errors->has('widget2_content'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('widget2_content') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group {{ ($errors->has('widget3_title') || $errors->has('widget3_content')) ? ' has-error' : '' }}">
                                                    <input type="text" class="form-control mb-1" name="widget3_title" id="widget3_title" placeholder="عنوان" value="{{ config('widget3.title') }}"/>
                                                    @if ($errors->has('widget3_title'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('widget3_title') }}</strong>
                                                        </span>
                                                    @endif

                                                    <textarea name="widget3_content" id="widget3_content" cols="30" rows="5" class="form-control" placeholder="محتوا">{{ config('widget3.content') }}</textarea>
                                                    @if ($errors->has('widget3_content'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('widget3_content') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block" type="submit">ذخیره تنظیمات</button>
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
    <script>
        Dropzone.autoDiscover = false;
    </script>
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
        });//doc
    </script>
@endsection
