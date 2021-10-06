@extends('layouts.app')

@section('title',' - پنل مدیریت')
@section('description','پنل مدیریت')
@section('keywords','پنل مدیریت')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">

@endsection
@section('headImport.styles.append')

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
                    @inject('ticketStatisticsController','App\Http\Controllers\Ticket\StatisticsController')
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="widget-bg-color-icon card-box">
                                <div class="bg-icon bg-icon-inverse pull-right">
                                    <i class="ti-ticket text-success"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark m-t-10"><b class="counter">{{ number_format($ticketStatisticsController::countAll()) }}</b></h3>
                                    <p class="text-muted mb-0">کل تیکت ها</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="widget-bg-color-icon card-box fadeInDown animated">
                                <div class="bg-icon bg-icon-success pull-right">
                                    <i class="ti-check text-info"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark m-t-10"><b class="counter">{{ number_format($ticketStatisticsController::countReplied()) }}</b></h3>
                                    <p class="text-muted mb-0">پاسخ داده شده</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="widget-bg-color-icon card-box">
                                <div class="bg-icon bg-icon-primary pull-right">
                                    <i class="ti-time text-pink"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark m-t-10"><b class="counter">{{ number_format($ticketStatisticsController::countNotClosed()) }}</b></h3>
                                    <p class="text-muted mb-0">در حال بررسی</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="widget-bg-color-icon card-box">
                                <div class="bg-icon bg-icon-danger pull-right">
                                    <i class="ti-alert text-purple"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark m-t-10"><b class="counter">{{ number_format($ticketStatisticsController::countClosed()) }}</b></h3>
                                    <p class="text-muted mb-0">بسته</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="portlet">
                                <!-- /primary heading -->
                                <div class="portlet-heading">
                                    <h3 class="portlet-title text-dark">گزارشات</h3>
                                    @php
                                        $analysis=$ticketStatisticsController::weeklyAnalysis();
                                    @endphp
                                    <div class="portlet-widgets">
                                        <a href="javascript:void(0);" data-toggle="reload"><i class="ion-refresh"></i></a>
                                        <span class="divider"></span>
                                        <a data-toggle="collapse" data-parent="#accordion1" href="#bg-default"><i class="ion-minus-round"></i></a>
                                        <span class="divider"></span>
                                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="bg-default" class="panel-collapse collapse show">
                                    <div class="portlet-body">
                                        <div class="text-center">
                                            <ul class="list-inline chart-detail-list">
                                                <li class="list-inline-item">
                                                    <h5><i class="fa fa-circle m-l-5" style="color: #039cfd;"></i>در حال بررسی</h5>
                                                </li>
                                                <li class="list-inline-item">
                                                    <h5><i class="fa fa-circle m-l-5" style="color: #52bb56;"></i>پاسخ داده شده</h5>
                                                </li>
                                                <li class="list-inline-item">
                                                    <h5><i class="fa fa-circle m-l-5" style="color: #ebeff2;"></i>کل</h5>
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="morris-bar-example" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Portlet -->
                        </div>
                    </div>
                    <!-- End row-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title m-t-0 m-b-30">دسترسی سریع</h4>
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="lastTickets">
                                        <div class="table-responsive">
                                            @inject('ticketDataController','App\Http\Controllers\Ticket\DataController')
                                            @php
                                                $tickets=$ticketDataController::tickets();
                                            @endphp

                                            <table class="table mb-0 table-hover custom-tbl">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>عنوان</th>
                                                    <th>دپارتمان</th>
                                                    <th>وضعیت</th>
                                                    <th>کاربر</th>
                                                    <th>تاریخ ایجاد</th>
                                                    <th>آخرین پاسخ</th>
                                                    <th>پاسخ ها</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($tickets->isNotEmpty())
                                                    @foreach($tickets as $ticket)
                                                        <tr>
                                                            <td>{{ $loop->index+1 }}</td>
                                                            <td>
                                                                <a href="{{ route('ticket.show',$ticket) }}">{{ $ticket->subject }}</a>
                                                                @if($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_LOW)
                                                                    <span class="text-inverse">(کم اهمیت)</span>
                                                                @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_MEDIUM)
                                                                    <span class="text-info hidden">(عادی)</span>
                                                                @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_HIGH)
                                                                    <span class="text-warning">(مهم)</span>
                                                                @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_EMERGENCY)
                                                                    <span class="text-danger">(ضروری)</span>
                                                                @endif
                                                            </td>
                                                            <td><span class="badge badge-inverse">{{ $ticket->department->name }}</span></td>
                                                            <td>
                                                                <span class="badge badge-info"></span>

                                                                @if($ticket->closed())
                                                                    <span class="badge badge-danger">بسته شده</span>
                                                                @elseif($ticket->referral())
                                                                    <span class="badge badge-dark">ارجاع داده شده</span>
                                                                @elseif($ticket->resolved())
                                                                    <span class="badge badge-success">برطرف شده</span>
                                                                @elseif($ticket->replied())
                                                                    <span class="badge badge-primary">پاسخ داده شده</span>
                                                                @elseif($ticket->unreaded())
                                                                    <span class="badge badge-warning">خوانده نشده</span>
                                                                @elseif($ticket->readed())
                                                                    <span class="badge badge-info">در انتظار بررسی</span>
                                                                @endif


                                                            </td>
                                                            <td class="text-center">
                                                                @if($ticket->user)
                                                                <a href="{{ route('user.show',$ticket->user) }}">{{ $ticket->user->name }}</a>
                                                                @else
                                                                <span class="badge badge-inverse">مهمان</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ Date::make($ticket->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                            <td>
                                                            @if($ticket->user)
                                                                @if($ticket->children()->where('user_id','<>',$ticket->user->id)->count())
                                                                <span>
                                                                    {{
                                                                        Date::make(
                                                                            $ticket->children()
                                                                                  ->where('user_id','<>',$ticket->user->id)
                                                                                  ->orderByDesc('id')
                                                                                  ->first()
                                                                                  ->created_at
                                                                        )->toJalali()->format('Y/m/d')
                                                                    }}
                                                                </span>
                                                                <span> - </span>
                                                                <a href="{{ route('user.show',$ticket->children()->where('user_id','<>',$ticket->user->id)->orderByDesc('id')->first()->user) }}">
                                                                    {{ $ticket->children()->where('user_id','<>',$ticket->user->id)->orderByDesc('id')->first()->user->name }}
                                                                </a>
                                                                @else
                                                                <span class="badge badge-danger">بدون پاسخ</span>
                                                                @endif
                                                            @else
                                                                @if($ticket->children()->whereNotNull('user_id')->count())
                                                                <span>
                                                                    {{
                                                                       Date::make(
                                                                           $ticket->children()
                                                                                  ->whereNotNull('user_id')
                                                                                  ->orderByDesc('id')
                                                                                  ->first()
                                                                                  ->created_at
                                                                       )->toJalali()->format('Y/m/d')
                                                                    }}
                                                                </span>
                                                                <span> - </span>
                                                                <a href="{{ route('user.show',$ticket->children()->whereNotNull('user_id')->orderByDesc('id')->first()->user) }}">
                                                                    {{ $ticket->children()->whereNotNull('user_id')->orderByDesc('id')->first()->user->name }}
                                                                </a>
                                                                @else
                                                                <span class="badge badge-danger">بدون پاسخ</span>
                                                                @endif
                                                            @endif
                                                            </td>
                                                            <td>
                                                            @if($ticket->user)
                                                                {{ $ticket->children()->where('user_id','<>',$ticket->user->id)->count() }} تا
                                                            @else
                                                                {{ $ticket->children()->whereNotNull('user_id')->count() }} تا
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end content -->
            @include('layouts.footer')
        </div>

        <!-- ============================================================== -->
        <!-- Right content end -->
        <!-- ============================================================== -->

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

    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('js/star-rating.min.js') }}"></script>
    <!-- Counter Up  -->
    <script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
    <!--Morris Chart-->
    <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
    <!-- Modal-Effect -->
    <script src="{{ asset('plugins/custombox/dist/custombox.min.js') }}"></script>
    <script src="{{ asset('plugins/custombox/dist/legacy.min.js') }}"></script>
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 100,
                time: 1200
            });
        });
    </script>
    <script>
        !function($) {
            "use strict";

            var MorrisCharts = function() {};

            //creates line chart
            MorrisCharts.prototype.createLineChart = function(element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
                Morris.Line({
                    element: element,
                    data: data,
                    xkey: xkey,
                    ykeys: ykeys,
                    labels: labels,
                    fillOpacity: opacity,
                    pointFillColors: Pfillcolor,
                    pointStrokeColors: Pstockcolor,
                    behaveLikeLine: true,
                    gridLineColor: '#eef0f2',
                    hideHover: 'auto',
                    resize: true, //defaulted to true
                    lineColors: lineColors
                });
            },
                //creates area chart
                MorrisCharts.prototype.createAreaChart = function(element, pointSize, lineWidth, data, xkey, ykeys, labels, lineColors) {
                    Morris.Area({
                        element: element,
                        pointSize: 0,
                        lineWidth: 0,
                        data: data,
                        xkey: xkey,
                        ykeys: ykeys,
                        labels: labels,
                        hideHover: 'auto',
                        resize: true,
                        gridLineColor: '#eef0f2',
                        lineColors: lineColors
                    });
                },
                //creates area chart with dotted
                MorrisCharts.prototype.createAreaChartDotted = function(element, pointSize, lineWidth, data, xkey, ykeys, labels, Pfillcolor, Pstockcolor, lineColors) {
                    Morris.Area({
                        element: element,
                        pointSize: 3,
                        lineWidth: 1,
                        data: data,
                        xkey: xkey,
                        ykeys: ykeys,
                        labels: labels,
                        hideHover: 'auto',
                        pointFillColors: Pfillcolor,
                        pointStrokeColors: Pstockcolor,
                        resize: true,
                        gridLineColor: '#eef0f2',
                        lineColors: lineColors
                    });
                },
                //creates Bar chart
                MorrisCharts.prototype.createBarChart  = function(element, data, xkey, ykeys, labels, lineColors) {
                    Morris.Bar({
                        element: element,
                        data: data,
                        xkey: xkey,
                        ykeys: ykeys,
                        labels: labels,
                        hideHover: 'auto',
                        resize: true, //defaulted to true
                        gridLineColor: '#eeeeee',
                        barColors: lineColors
                    });
                },
                //creates Stacked chart
                MorrisCharts.prototype.createStackedChart  = function(element, data, xkey, ykeys, labels, lineColors) {
                    Morris.Bar({
                        element: element,
                        data: data,
                        xkey: xkey,
                        ykeys: ykeys,
                        stacked: true,
                        labels: labels,
                        hideHover: 'auto',
                        resize: true, //defaulted to true
                        gridLineColor: '#eeeeee',
                        barColors: lineColors
                    });
                },
                //creates Donut chart
                MorrisCharts.prototype.createDonutChart = function(element, data, colors) {
                    Morris.Donut({
                        element: element,
                        data: data,
                        resize: true, //defaulted to true
                        colors: colors
                    });
                },
                MorrisCharts.prototype.init = function() {
                    //creating bar chart
                    var $barData  = {!! json_encode($analysis,JSON_UNESCAPED_UNICODE) !!};
                    this.createBarChart('morris-bar-example', $barData, 'y', ['a', 'b', 'c'], ['کل', 'پاسخ داده شده', 'در حال بررسی'], ['#ebeff2', '#52bb56', '#039cfd']);
                },
                //init
                $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
        }(window.jQuery),

        //initializing
        function($) {
            "use strict";
            $.MorrisCharts.init();
        }(window.jQuery);
    </script>
    <script>

        $('#news').innerfade({
            speed: 1000,
            timeout: 5000,
            wait: 1000
        });

        $('.nav-tabs > li').click(function () {
            var tab = $(this);
            $('body, html').animate({
                scrollTop: tab.offset().top + 'px'
            },{
                duration: 1000
            });
        });
    </script>

@endsection
