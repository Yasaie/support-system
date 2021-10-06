@extends('layouts.app')

@section('title','- لیست دپارتمان ها')
@section('description','لیست دپارتمان ها')
@section('keywords','لیست دپارتمان ها')

@section('headImport.styles.prepend')
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/jquery-confirm/jquery-confirm.min.css') }}">
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
                                        <form action="{{ route('department.index') }}" method="GET" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" value="{{ $search }}" id="searchDepartment" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <a class="btn btn-sm btn-primary btn-xs-block m-b-10" href="{{ route('department.create') }}">افزودن</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        {{ $departments->links() }}
                                    </div>
                                </div>
                                <!-- End row-->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover custom-tbl">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>عنوان</th>
                                            <th>سرپرست</th>
                                            <th>وضعیت</th>
                                            <th>پشتیبان</th>
                                            <th>تیکت ها</th>
                                            <th>گزینه ها</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($departments as $department)
                                                <tr>
                                                    <th>{{ $loop->index+1 }}</th>
                                                    <td>{{ $department->name }}</td>
                                                    <td>{{ $department->leaders()->count() }} تا </td>
                                                    <td>{{ $department->visible() ? 'عمومی' : 'مخفی' }}</td>
                                                    <td>{{ $department->staffs()->count() }} تا </td>
                                                    <td>{{ $department->tickets()->count() }} تا </td>
                                                    <td>
                                                        @can('delete',$department)
                                                        <form action="{{ route('department.destroy',$department) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        @endcan
                                                        @can('update',$department)
                                                            <a class="btn btn-sm btn-primary" href="{{ route('department.edit',$department) }}">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                        @endcan
                                                        @can('delete',$department)
                                                            <button class="btn btn-sm btn-danger deleteDepartment" type="submit">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </td>
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
    @include('layouts.addDepartmentModal')
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
        $(function () {

            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $('[data-toggle=tooltip]').tooltip();
        });//doc

        /*
        $('body').on('click', '.deleteDepartment', function (e) {
            e.preventDefault();
            var deleteBTN = $(this);
            $.confirm({
                theme: 'material',
                type: 'red',
                title: 'آیا تمایل به حذف دپارتمان دارید؟',
                content: 'دپارتمان مورد نظر برای همیشه حذف خواهد شد',
                autoClose: 'cancelAction|8000',
                buttons: {
                    deleteUser: {
                        text: 'حذف کن',
                        action: function () {
                            $.Notification.autoHideNotify('success', 'top left', 'انجام شد', 'دپارتمان با موفقیت حذف شد');
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

        $('#addDepartmentForm').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            var subBTN = form.find('button[type=submit]');
            subBTN.attr('disabled', 'disabled');
            subBTN.html('<i class="fa fa-spinner fa-spin"></i>');
            $.Notification.autoHideNotify('success', 'top left', 'انجام شد', 'دپارتمان با موفقیت ایجاد شد');
            setTimeout(
                function(){
                    location.reload();
                }
                ,5000);
        });
        */
    </script>
@endsection
