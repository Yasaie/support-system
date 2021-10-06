@extends('layouts.app')

@section('title','- ثبت نوع کاربری جدید')
@section('description','ثبت نوع کاربری جدید')
@section('keywords','ثبت نوع کاربری جدید')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box clearfix">
                                <h5 class="card-header m-b-20 b-0">افزودن نوع کاربری</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('role.store') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12">
                                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">نام</label>
                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
                                            </div>
                                            @if ($errors->has('name'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group {{ $errors->has('permissions') ? ' has-error' : '' }}">
                                                <select name="permissions[]" id="permissions" class="form-control select2" data-placeholder="انتخاب سطح دسترسی" multiple></select>
                                            </div>
                                            @if ($errors->has('permissions'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('permissions') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group clearfix m-0">
                                        <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block m-r-5" type="submit">ذخیره تغییرات</button>
                                    </div>
                                </form>
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
    <!-- Notification js -->
    <script src="{{ asset('plugins/notifyjs/dist/notify.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/notify-metro.js') }}"></script>
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/js/i18n/'.app()->getLocale().'.js') }}" type="text/javascript"></script>

    <script>
        function htmlentities(s){
            var div = document.createElement('div');
            var text = document.createTextNode(s);
            div.appendChild(text);
            return div.innerHTML;
        }

        $('#permissions').select2({
            dir: 'rtl',
            language: 'fa',
            ajax: {
                url: '{{ route('permission.index') }}',
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
    </script>

@endsection
