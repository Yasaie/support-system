@extends('layouts.app')

@section('title','- لاگ sms')
@section('description','لاگ sms')
@section('keywords','لاگ sms')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet" type="text/css">

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
                                @include('partial.flashMessage')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <form action="{{ route('log.sms.index') }}" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" id="search" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="pull-left">
                                            {{ $logs->links() }}
                                        </div>
                                    </div>
                                </div>
                                <!-- End row-->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover custom-tbl">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>محتوا</th>
                                                <th>گیرنده</th>
                                                <th>تاریخ ایجاد</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($logs as $log)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ Str::limit($log->content) }}</td>
                                                    <td>{{ $log->to }}</td>
                                                    <td>{{ Date::make($log->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex">
                                    {{ $logs->links() }}
                                    <div class="clearfix"></div>
                                </div>
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
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
@endsection

@section('bodyImport.append')

    <script>
        $(function(){
            $('#cities').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $('[data-toggle=tooltip]').tooltip();

        });//doc
    </script>

@endsection
