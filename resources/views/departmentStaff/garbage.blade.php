@extends('layouts.app')

@section('title','- لیست پشتیبانان')
@section('description','لیست پشتیبانان')
@section('keywords','لیست پشتیبانان')

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
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3">
                                        <form action="{{ route('staff.index') }}" method="GET" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <a class="btn btn-sm btn-primary btn-xs-block m-b-10" href="{{ route('staff.create') }}">افزودن</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        {{ $staffs->links() }}
                                    </div>
                                </div>
                                @include('partial.flashMessage')
                                <!-- End row-->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover custom-tbl">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام</th>
                                                <th>دپارتمان</th>
                                                <th>ایمیل</th>
                                                <th>شماره همراه</th>
                                                <th>تاریخ عضویت</th>
                                                <th>وضعیت</th>
                                                <th>گزینه ها</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staffs as $staff)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>
                                                        @can('staffView',$staff)
                                                            <a href="{{ route('staff.show',$staff) }}">
                                                                {{ $staff->name }}
                                                            </a>
                                                        @elsecan
                                                            {{ $staff->name }}
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        @if($staff->departments->isNotEmpty())
                                                            @foreach($staff->departments as $department)
                                                                @if($department->pivot->is_leader)
                                                                    <a href="#" data-toggle="tooltip" title="سرپرست" data-original-title="سرپرست" class="badge badge-purple">
                                                                        {{ $department->name }}
                                                                    </a>
                                                                @else
                                                                    <a href="#" data-toggle="tooltip" title="پشتیبان" data-original-title="پشتیبان" class="badge badge-inverse">
                                                                        {{ $department->name }}
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $staff->email }}</td>
                                                    <td>{{ $staff->mobile }}</td>
                                                    <td>{{ Date::make($staff->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                    <td>
                                                        @if($staff->unlocked())
                                                            <span class="badge badge-success cursor-pointer type-badge">فعال</span>
                                                        @else
                                                            <span class="badge badge-warning cursor-pointer type-badge">غیرفعال</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                    @can('staffPermanentDelete',$staff)
                                                        <form action="{{ route('staff.permanentDestroy',$staff) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                    @endcan
                                                    @can('staffRecycle',$staff)
                                                        <a class="btn btn-sm btn-primary" href="{{ route('staff.recycle',$staff) }}">
                                                            بازیابی
                                                        </a>
                                                    @endcan
                                                    @can('staffPermanentDelete',$staff)
                                                            <button class="btn btn-sm btn-danger" type="submit">
                                                                حذف کامل
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $('[data-toggle=tooltip]').tooltip();

            $('body').on('click', '.deleteDepartment', function () {
                var deleteBTN = $(this);
                $.confirm({
                    theme: 'material',
                    type: 'red',
                    title: 'آیا تمایل به حذف پشتیبان دارید؟',
                    content: 'پشتیبان مورد نظر برای همیشه حذف خواهد شد',
                    autoClose: 'cancelAction|8000',
                    buttons: {
                        deleteUser: {
                            text: 'حذف کن',
                            action: function () {
                                $.Notification.autoHideNotify('success', 'top left', 'انجام شد', 'پشتیبان با موفقیت حذف شد');
                                $(deleteBTN).parents('tr').addClass('table-danger');
                                $(deleteBTN).parents('tr').fadeOut('slow');
                            }
                        },
                        cancelAction: {
                            text: 'انصراف',
                            action: function () {
                            }
                        }
                    }
                });
            });

            $('.table').on('click','.type-badge',function(){
                $(this).toggleClass('badge-success badge-warning');
                $(this).text(function(i, text){
                    return text === "فعال" ? "غیرفعال" : "فعال";
                });
            })
        });//doc
    </script>

@endsection
