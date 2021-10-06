@extends('layouts.app')

@section('title',' - لیست تیکت ها')
@section('description','لیست تیکت ها')
@section('keywords','لیست تیکت ها')

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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-heading">
                                    <h3 class="portlet-title text-dark">گزارشات</h3>
                                    <div class="portlet-widgets">
                                        <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                        <span class="divider"></span>
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion1" href="#statistics" aria-expanded="false"><i class="ion-minus-round"></i></a>
                                        <span class="divider"></span>
                                        <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                @inject('ticketStatisticsController','App\Http\Controllers\Ticket\StatisticsController')

                                <div id="statistics" class="panel-collapse collapse">
                                    <div class="portlet-body">
                                        <div class="row text-center">
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="circliful-chart m-b-30" data-dimension="180" data-text="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countReplied()/$ticketStatisticsController::countAll())*100) : 0 ) }}%" data-info="پاسخ داده شده" data-width="20" data-fontsize="24" data-percent="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countReplied()/$ticketStatisticsController::countAll())*100) : 0 ) }}" data-fgcolor="#5fbeaa" data-bgcolor="#ebeff2"></div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="circliful-chart m-b-30" data-dimension="180" data-text="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countNotClosed()/$ticketStatisticsController::countAll())*100) : 0 ) }}%" data-info="درحال بررسی" data-width="20" data-fontsize="24" data-percent="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countNotClosed()/$ticketStatisticsController::countAll())*100) : 0 ) }}" data-fgcolor="#039cfd" data-bgcolor="#ebeff2"></div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="circliful-chart m-b-30" data-dimension="180" data-text="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countNotReaded()/$ticketStatisticsController::countAll())*100) : 0 ) }}%" data-info="خوانده نشده" data-width="20" data-fontsize="24" data-percent="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countNotReaded()/$ticketStatisticsController::countAll())*100) : 0 ) }}" data-fgcolor="#f1b53d" data-bgcolor="#ebeff2"></div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="circliful-chart m-b-30" data-dimension="180" data-text="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countClosed()/$ticketStatisticsController::countAll())*100) : 0 ) }}%" data-info="بسته" data-width="20" data-fontsize="24" data-percent="{{ (!empty($ticketStatisticsController::countAll()) ? intval(($ticketStatisticsController::countClosed()/$ticketStatisticsController::countAll())*100) : 0 ) }}" data-fgcolor="#ef5350" data-bgcolor="#ebeff2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End Row -->
                    <div class="row" id="advanceFiltersSection" style="display:none;">
                        <div class="col-md-12">
                            <form action="{{ route('ticket.index') }}" method="GET">
                                <div class="portlet">
                                    <div class="portlet-heading">
                                        <h3 class="portlet-title text-dark">اعمال فیلتر پیشرفته</h3>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="advanceFilters" class="panel-collapse collapse show">
                                        <div class="portlet-body">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="row">
                                                        @inject('priorityClass','App\Http\Controllers\Ticket\TicketPriority')
                                                        @php
                                                            $priorities=$priorityClass::getList();
                                                        @endphp
                                                        <div class="col-md-6">
                                                            <select id="priority" name="priority" class="form-control">
                                                                <option value="" selected disabled>انتخاب اولویت</option>
                                                                @foreach($priorities as $priorityId=>$priorityName)
                                                                    <option value="{{ $priorityId }}" {{ old('priority')==$priorityId ?' selected ':'' }}>{{ $priorityName }}</option>
                                                                @endforeach
                                                            </select>

                                                            @if ($errors->has('priority'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('priority') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <select id="users" name="users[]" class="form-control" multiple data-placeholder="کاربر مورد نظر"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End row-->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <select  id="departments" name="departments[]" class="form-control" multiple data-placeholder="دپارتمان"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End row-->
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="عنوان">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="ion-clipboard"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" name="content" value="{{ old('content') }}" class="form-control" placeholder="محتوا">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="ion-compose"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End row-->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-block btn-success btn-custom waves-effect waves-light">
                                                                نمایش نتایج
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="text" name="fromDate" id="fromDateAlt" class="form-control" placeholder="از تاریخ">
                                                            </div>
                                                            <div class="range-from"></div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="text" name="toDate" id="toDateAlt" class="form-control" placeholder="تا تاریخ">
                                                            </div>
                                                            <div class="range-to"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Row -->

                    @include('partial.flashMessage')

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <form action="{{ route('ticket.index') }}" method="GET" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <button id="addAdvanceFilters" class="btn btn-primary btn-sm w-md btn-custom waves-effect waves-light">اعمال فیلتر پیشرفته</button>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
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
                                            <th>تاریخ ایجاد</th>
                                            <th>آخرین پاسخ</th>
                                            <th>پاسخ ها</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @inject('ticketPriority','App\Http\Controllers\Ticket\TicketPriority')
                                            @foreach($tickets as $ticket)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>
                                                        <a href="{{ route('ticket.show',$ticket) }}">{{ $ticket->subject }}</a>
                                                        @if($ticket->priority==$ticketPriority::PRIORITY_LOW)
                                                            <span class="text-inverse">(کم اهمیت)</span>
                                                        @elseif($ticket->priority==$ticketPriority::PRIORITY_MEDIUM)
                                                            <span class="text-info hidden">(عادی)</span>
                                                        @elseif($ticket->priority==$ticketPriority::PRIORITY_HIGH)
                                                            <span class="text-warning">(مهم)</span>
                                                        @elseif($ticket->priority==$ticketPriority::PRIORITY_EMERGENCY)
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

            $('body').on('click', '#addAdvanceFilters', function () {
                $(this).text('حذف فیلتر ها');
                $(this).addClass('advanceFiltersClose');
                if(!$('[data-toggle=collapse]').hasClass('collapsed')){
                    $('#statistics').collapse("toggle");
                }
                $('#advanceFiltersSection').slideDown(2000,function(){
                    $('body, html').animate({
                        scrollTop: $('#advanceFiltersSection').offset().top + 'px'
                    },{duration: 1000});
                });
            });

            $('body').on('click', '.advanceFiltersClose', function () {
                $(this).text('اعمال فیلتر پیشرفته');
                $(this).removeClass('advanceFiltersClose');
                if(!$('[data-toggle=collapse]').hasClass('collapsed')){
                    $('#statistics').collapse("toggle");
                }
                $('#advanceFiltersSection').slideUp();
                $('body, html').animate({
                    scrollTop: $('.table').offset().top + 'px'
                },{duration: 1000});
            });

            var to, from;

            to = $(".range-to").persianDatepicker({
                inline: true,
                altField: '#toDateAlt',
                altFormat: 'YYYY/MM/DD',
                initialValue: false,
                "navigator": {
                    "enabled": true,
                    "scroll": {
                        "enabled": true
                    },
                    "text": {
                        "btnNextText": ">",
                        "btnPrevText": "<"
                    }
                },
                "toolbox": {
                    "enabled": true,
                    "calendarSwitch": {
                        "enabled": false,
                        "format": "MMMM"
                    }
                },
                onSelect: function (unix) {
                    to.touched = true;
                    if (from && from.options && from.options.maxDate != unix) {
                        var cachedValue = from.getState().selected.unixDate;
                        from.options = {maxDate: unix};
                        if (from.touched) {
                            from.setDate(cachedValue);
                        }
                    }
                }
            });
            from = $(".range-from").persianDatepicker({
                inline: true,
                altField: '#fromDateAlt',
                altFormat: 'YYYY/MM/DD',
                initialValue: false,
                "navigator": {
                    "enabled": true,
                    "scroll": {
                        "enabled": true
                    },
                    "text": {
                        "btnNextText": ">",
                        "btnPrevText": "<"
                    }
                },
                "toolbox": {
                    "enabled": true,
                    "calendarSwitch": {
                        "enabled": false,
                        "format": "MMMM"
                    }
                },
                onSelect: function (unix) {
                    from.touched = true;
                    if (to && to.options && to.options.minDate != unix) {
                        var cachedValue = to.getState().selected.unixDate;
                        to.options = {minDate: unix};
                        if (to.touched) {
                            to.setDate(cachedValue);
                        }
                    }
                }
            });
        });
    </script>

@endsection
