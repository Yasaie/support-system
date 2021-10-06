@extends('layouts.app')

@section('title',' - لیست استان ها')
@section('description','لیست استان ها')
@section('keywords','لیست استان ها')

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
                                        <form action="{{ route('province.index') }}" role="form">
                                            <div class="form-group">
                                                <input type="text" name="search" id="search" placeholder="جستجو..." class="custom-search-field">
                                                <i class="fa fa-search" onclick="this.parentNode.parentNode.submit()"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <a class="btn btn-sm btn-primary btn-xs-block m-b-10" href="{{ route('province.create') }}">افزودن</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="pull-left">
                                            {{ $provinces->links() }}
                                        </div>
                                    </div>
                                </div>
                                <!-- End row-->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover custom-tbl">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام</th>
                                                <th>تعداد شهرها</th>
                                                <th>تاریخ ایجاد</th>
                                                <th>گزینه ها</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($provinces as $province)
                                                <tr>
                                                    <td>{{ $loop->index+1 }}</td>
                                                    <td>{{ $province->name }}</td>
                                                    <td class="text-center">{{ $province->cities()->count() }}</td>
                                                    <td>{{ Date::make($province->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                    <td>
                                                        <form action="{{ route('province.destroy',$province) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <a class="btn btn-sm btn-primary" href="{{ route('province.edit',$province) }}">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger deleteUser" type="submit">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex">
                                    {{ $provinces->links() }}
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
            $('#provinces').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $('[data-toggle=tooltip]').tooltip();

        });//doc
    </script>

@endsection
