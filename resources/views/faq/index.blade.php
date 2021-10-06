@extends('layouts.app')
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
                                        <form action="{{ route('faq.index') }}" method="GET" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <a class="btn btn-sm btn-primary btn-xs-block m-b-10" href="{{ route('faq.create') }}">افزودن</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        {{ $faqs->links() }}
                                    </div>
                                </div>
                                <!-- End row-->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover custom-tbl">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>پرسش</th>
                                                <th>پاسخ</th>
                                                <th>تاریخ ایجاد</th>
                                                <th>گزینه ها</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($faqs as $faq)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>
                                                        <a href="{{ route('faq.show',$faq) }}">
                                                            {{ Str::limit(strip_tags($faq->question)) }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('faq.show',$faq) }}">
                                                            {{ Str::limit(strip_tags($faq->answer)) }}
                                                        </a>
                                                    </td>
                                                    <td>{{ Date::make($faq->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                    <td>
                                                    @can('delete',$faq)
                                                        <form action="{{ route('faq.destroy',$faq) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                    @endcan
                                                    @can('update',$faq)
                                                            <a class="btn btn-sm btn-primary" href="{{ route('faq.edit',$faq) }}">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                    @endcan
                                                    @can('delete',$faq)
                                                            <button class="btn btn-sm btn-danger deleteUser" type="submit">
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

            $('body').on('click', '.deleteUser', function () {
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
