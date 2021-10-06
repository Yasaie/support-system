@extends('layouts.app')

@section('title','- ویرایش کشور جدید')
@section('description','ویرایش کشور جدید')
@section('keywords','ویرایش کشور جدید')

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
                                <h5 class="card-header m-b-20 b-0">افزودن کشور</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('country.update',$country) }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">نام</label>
                                                <input id="name" type="text" class="form-control" name="name" value="{{ $country->name }}" autofocus>
                                            </div>
                                            @if ($errors->has('name'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="form-group {{ $errors->has('short_name') ? ' has-error' : '' }}">
                                                <label for="short_name">نام کوتاه</label>
                                                <input id="short_name" type="text" class="form-control" name="short_name" value="{{ $country->short_name }}" autofocus>
                                            </div>
                                            @if ($errors->has('short_name'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('short_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group clearfix m-0">
                                        <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block m-r-5" type="submit">ذخیره تغییرات</button>
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

@endsection
