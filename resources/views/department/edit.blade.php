@extends('layouts.app')

@section('title','- ویرایش دپارتمان')
@section('description','ویرایش دپارتمان')
@section('keywords','ویرایش دپارتمان')

@section('headImport.styles.prepend')
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
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
                                <h5 class="card-header m-b-20 b-0">ویرایش دپارتمان</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('department.update',$department) }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="name">عنوان دپارتمان</label>
                                        <div class="col-sm-10">
                                            <input name="name" class="form-control" id="name" value="{{ $department->name }}" placeholder="عنوان یا نام دپارتمان" type="text" autofocus>
                                            @if ($errors->has('name'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Auth::user()->owner() || Auth::user()->admin())
                                    <div class="form-group {{ $errors->has('leaders') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="leaders">سرپرست</label>
                                        <div class="col-sm-10">
                                            <select id="leaders" class="form-control" name="leaders[]" data-placeholder="سرپرست" multiple="multiple">
                                                @if($department->leaders)
                                                    @foreach($department->leaders as $leader)
                                                        <option data-name="{{ $leader->name }}" data-mobile="{{ $leader->mobile }}" data-email="{{ $leader->email }}" value="{{ $leader->id }}" selected="selected">{{ $leader->name or $leader->mobile or $leader->email }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('leaders'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('leaders') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group {{ $errors->has('managers') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="managers">پشتیبان</label>
                                        <div class="col-sm-10">
                                            <select id="managers" class="form-control" name="managers[]" data-placeholder="پشتیبان" multiple="multiple">
                                                @if($department->staffs)
                                                    @foreach($department->staffs as $staff)
                                                        <option data-name="{{ $staff->name }}" data-mobile="{{ $staff->mobile }}" data-email="{{ $staff->email }}" value="{{ $staff->id }}" selected="selected">{{ $staff->name or $staff->mobile or $staff->email }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('managers'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('managers') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('hidden') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="hidden" data-toggle="tooltip" title="مخفی/عمومی بودن دپارتمان">مخفی باشد؟</label>
                                        <div class="col-sm-10">
                                            <input value="1" name="hidden" type="checkbox" id="hidden" {{ ($department->hidden()) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('hidden'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('hidden') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <button class="btn btn-success w-lg btn-custom btm-sm waves-effect waves-light btn-xs-block pull-left" type="submit">ذخیره تغییرات</button>
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
    <script src="{{ asset('plugins/select2/js/i18n/'.app()->getLocale().'.js') }}" type="text/javascript"></script>
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

        $('#managers,#leaders').select2({
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

        function htmlentities(s){
            var div = document.createElement('div');
            var text = document.createTextNode(s);
            div.appendChild(text);
            return div.innerHTML;
        }

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

        /*
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
