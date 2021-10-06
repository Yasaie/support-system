@extends('layouts.user.app')

@section('title',' - کاربر')
@section('description','کاربر')
@section('keywords','کاربر')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Navigation Bar-->
    @include('layouts.user.navigationBar')
    <!-- End Navigation Bar-->

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row m-t-20">
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
        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->

    <!-- Footer -->
    @include('layouts.user.footer')
    <!-- End Footer -->
    @include('layouts.lockScreenModal')
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

    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <!-- Counter Up  -->
    <script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
    <!-- CustomBox -->
    <script src="{{ asset('plugins/custombox/dist/custombox.min.js') }}"></script>
    <script src="{{ asset('plugins/custombox/dist/legacy.min.js') }}"></script>
    <!-- idle timer -->
    <script src="{{ asset('plugins/jquery-idle/jquery.idle.min.js') }}"></script>

@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            $('[data-toggle=tooltip]').tooltip();

            $('.navbar-toggle.nav-link').click(function () {
                $(this).toggleClass('open');
                $('#navigation').slideToggle(400);
            });

        });//doc
    </script>

@endsection
