@extends('layouts.app')

@section('title','- لاگ بازدید')
@section('description','لاگ بازدید')
@section('keywords','لاگ بازدید')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" type="text/css">
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
                        @can('map',App\View::class)
                        <div class="col-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h6>آمار بازدید امروز روی نقشه</h6>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs 12 col-sm-12">
                                        <div id="vmap" style="width: 100%; height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        <div class="col-12">
                            <div class="card-box">
                                @include('partial.flashMessage')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <form action="{{ route('log.view.index') }}" role="form">
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
                                                <th>آیپی</th>
                                                <th>از کجا اومده؟</th>
                                                <th>آدرس مورد بازدید</th>
                                                <th>نوع مرورگر</th>
                                                <th>نوع سیستم عامل</th>
                                                <th>قاره</th>
                                                <th>کشور</th>
                                                <th>شهر تقریبی</th>
                                                <th>طول جغرافیایی</th>
                                                <th>عرض جغرافیایی</th>
                                                <th>تاریخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($logs as $log)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <th>
                                                        @if($log->ip)
                                                        <a class="badge badge-light" target="_blank" href="{{ $log->ip }}">{{ $log->ip }}</a>
                                                        @else
                                                        <span class="badge badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->referrer)
                                                        <a class="badge badge-sm badge-inverse" target="_blank" href="{{ $log->referrer }}">
                                                            {{ Str::limit($log->referrer,15) }}
                                                        </a>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->url)
                                                        <a class="badge badge-sm badge-inverse" target="_blank" href="{{ $log->url }}">
                                                            {{ Str::limit($log->url,15) }}
                                                        </a>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->browser)
                                                        <span class="badge badge-sm badge-primary">{{ $log->browser }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->os)
                                                        <span class="badge badge-sm badge-primary">{{ $log->os }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->continent)
                                                        <span class="badge badge-sm badge-secondary">{{ $log->continent }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->country)
                                                        <span class="badge badge-sm badge-secondary">{{ $log->country }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->city)
                                                        <span class="badge badge-sm badge-secondary">{{ $log->city }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->latitude)
                                                        <span class="badge badge-sm badge-pink">{{ $log->latitude }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        @if($log->longitude)
                                                        <span class="badge badge-sm badge-pink">{{ $log->longitude }}</span>
                                                        @else
                                                        <span class="badge badge-sm badge-danger">
                                                            <span class="fa fa-close"></span>
                                                            <span>نامشخص</span>
                                                        </span>
                                                        @endif
                                                    </th>
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
    <!--JQV map-->
    <script type="text/javascript" src="{{ asset('plugins/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jqvmap/dist/maps/jquery.vmap.world.js') }}" charset="utf-8"></script>

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
    <script src="{{ route('log.view.map') }}"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: '#EEEEFF',
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#666666',
                enableZoom: false,
                showTooltip: true,
                scaleColors: ['#C8EEFF', '#006491'],
                values: simple_data,
                onLabelShow: function (element, label, code) {
                    if (country_pin[code] !== undefined) {
                        label.html(country_pin[code]);
                    }else{
                        label.html(label.html() + ' [0] ');
                    }
                },
                normalizeFunction: 'polynomial'
            });
        });
    </script>
@endsection
