@extends('layouts.app')

@section('title',' - زباله دانی تیکت ها')
@section('description','زباله دانی تیکت ها')
@section('keywords','زباله دانی تیکت ها')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/persian-datepicker/persian-datepicker.css') }}">

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

                    @include('partial.flashMessage')

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <form action="{{ route('ticket.garbage') }}" method="GET" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-9">
                                        <div class="pull-left">
                                            {{ $tickets->links() }}
                                        </div>
                                    </div>
                                </div>
                                <!-- End row-->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover custom-tbl">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>عنوان</th>
                                            <th>دپارتمان</th>
                                            <th>وضعیت</th>
                                            <th>کاربر</th>
                                            <th>نوع</th>
                                            <th>تاریخ ایجاد</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @inject('ticketPriority','App\Http\Controllers\Ticket\TicketPriority')
                                            @foreach($tickets as $ticket)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>
                                                        {{ $ticket->garbageRoot()->subject }}
                                                        @if($ticket->garbageRoot()->priority==$ticketPriority::PRIORITY_LOW)
                                                            <span class="text-inverse">(کم اهمیت)</span>
                                                        @elseif($ticket->garbageRoot()->priority==$ticketPriority::PRIORITY_MEDIUM)
                                                            <span class="text-info hidden">(عادی)</span>
                                                        @elseif($ticket->garbageRoot()->priority==$ticketPriority::PRIORITY_HIGH)
                                                            <span class="text-warning">(مهم)</span>
                                                        @elseif($ticket->garbageRoot()->priority==$ticketPriority::PRIORITY_EMERGENCY)
                                                            <span class="text-danger">(ضروری)</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="badge badge-inverse">{{ $ticket->garbageRoot()->department->name }}</span></td>
                                                    <td>
                                                        <span class="badge badge-info"></span>

                                                        @if($ticket->garbageRoot()->closed())
                                                            <span class="badge badge-danger">بسته شده</span>
                                                        @elseif($ticket->garbageRoot()->referral())
                                                            <span class="badge badge-dark">ارجاع داده شده</span>
                                                        @elseif($ticket->garbageRoot()->resolved())
                                                            <span class="badge badge-success">برطرف شده</span>
                                                        @elseif($ticket->garbageRoot()->replied())
                                                            <span class="badge badge-primary">پاسخ داده شده</span>
                                                        @elseif($ticket->garbageRoot()->unreaded())
                                                            <span class="badge badge-warning">خوانده نشده</span>
                                                        @elseif($ticket->garbageRoot()->readed())
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
                                                    <td>
                                                        @if($ticket->isRoot())
                                                            <span class="badge badge-primary">تیکت اصلی</span>
                                                        @else
                                                        <span class="badge badge-primary">تیکت پاسخ</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ Date::make($ticket->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                    <td>
                                                        @can('permanentDelete',$ticket)
                                                        <form action="{{ route('ticket.permanentDestroy',$ticket) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        @endcan
                                                        @can('recycle',$ticket)
                                                            <a class="btn btn-sm btn-primary" href="{{ route('ticket.recycle',$ticket) }}">
                                                                بازیابی
                                                            </a>
                                                        @endcan
                                                        @can('permanentDelete',$ticket)
                                                            <button class="btn btn-sm btn-danger" type="submit">
                                                                حذف کامل
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="pull-left">
                                            {{ $tickets->links() }}
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
@endsection

@section('bodyImport.append')

    <script>
        $(function () {

            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $(".knob").knob();

            $('.circliful-chart').circliful();


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

            function htmlentities(s){
                var div = document.createElement('div');
                var text = document.createTextNode(s);
                div.appendChild(text);
                return div.innerHTML;
            }

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

            $('#users').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('user.list') }}',
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
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo (repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = "<div class='clearfix'>";

                markup += "<span class='fa fa-user m-r-5 m-l-5'></span>";

                markup += "<span>" + htmlentities(repo.name || repo.mobile || repo.email) + "</span>";

                markup += "</div>";
                return markup;
            }

            function formatRepoSelection (repo) {
                elemName=repo.element.getAttribute('data-name');
                elemMobile=repo.element.getAttribute('data-mobile');
                elemEmail=repo.element.getAttribute('data-email');
                return htmlentities(repo.name || repo.mobile || repo.email || elemName || elemMobile || elemEmail);
            }


            $('[data-toggle="tooltip"]').tooltip();

        });
    </script>

@endsection
