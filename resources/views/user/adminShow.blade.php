@extends('layouts.app')
@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/persian-datepicker/persian-datepicker.css') }}">
    <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/dropzone/dropzone.css') }}"  rel="stylesheet">

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
                                <h5 class="card-header m-b-20 b-0">پروفایل کاربری</h5>
                                @include('partial.flashMessage')
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <img src="{{ $user->avatar_url }}" class="rounded-circle img-thumbnail" alt="user avatar">
                                    </div>
                                    <div class="col-sm-12 text-center m-t-10 m-b-10">
                                        <h4>{{ $user->name }}</h4>
                                        @if($user->country || $user->porivnce || $user->city)
                                            <p class="text-muted">
                                                @if($user->country)
                                                    {{ $user->country->name }}
                                                @endif
                                                @if($user->province)
                                                    {{ '/'.$user->province->name }}
                                                @endif
                                                @if($user->city)
                                                    {{ '/'.$user->city->name }}
                                                @endif
                                            </p>
                                        @endif
                                        @if($user->staff() || $user->leader())
                                            @foreach($user->departments as $department)
                                                <span class="badge badge-inverse">
                                                    {{ $department->name }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                @if($user->email)
                                <div class="row">
                                    <div class="col-sm-3">ایمیل</div>
                                    <div class="col-sm-9">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                @endif
                                @if($user->mobile)
                                <div class="row">
                                    <div class="col-sm-3">شماره همراه</div>
                                    <div class="col-sm-9">
                                        {{ $user->mobile }}
                                    </div>
                                </div>
                                @endif
                                @if($user->phone)
                                <div class="row">
                                    <div class="col-sm-3">تلفن تماس</div>
                                    <div class="col-sm-9">
                                        {{ $user->phone }}
                                    </div>
                                </div>
                                @endif
                                @if($user->gender)
                                <div class="row">
                                    <div class="col-sm-3">جنسیت</div>
                                    <div class="col-sm-9">
                                        @lang('general.'.$user->gender)
                                    </div>
                                </div>
                                @endif
                                @if($user->biography)
                                <div class="row">
                                    <div class="col-sm-12">
                                        <hr>
                                        <p>{{ $user->biography }}</p>
                                    </div>
                                </div>
                                @endif
                                @can('update',$user)
                                <div class="form-group clearfix m-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('user.edit',$user->id) }}" class="btn btn-success btn-xs-block w-md pull-left m-r-5 m-t-5">ویرایش اطلاعات</a>
                                        </div>
                                    </div>
                                </div>
                                @endcan
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
    <!-- Confirm JS -->
    <script src="{{ asset('plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <!-- Persian Datepicker -->
    <script src="{{ asset('plugins/persian-datepicker/persian-date.js') }}"></script>
    <script src="{{ asset('plugins/persian-datepicker/persian-datepicker.js') }}"></script>
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
    <!-- DropZone -->
    <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
    </script>
@endsection
