@extends('layouts.app')

@section('title','- ویرایش خبر')
@section('description','ویرایش خبر')
@section('keywords','ویرایش خبر')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/persian-datepicker/persian-datepicker.css') }}" rel="stylesheet" type="text/css">
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
                            <div class="card-box">
                                <h5 class="card-header m-b-20 b-0">ویرایش اطلاعیه و اخبار</h5>
                                @include('partial.flashMessage')
                                <form method="POST" class="form-horizontal" action="{{ route('news.update',$news) }}" role="form">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                                <label for="title">عنوان</label>
                                                <input name="title" type="text" id="title" value="{{ $news->title }}" class="form-control" placeholder="مثال: ارائه راهکار" required>
                                            </div>
                                            @if ($errors->has('title'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group {{ $errors->has('departments') ? ' has-error' : '' }}">
                                                <label for="departments">دپارتمان</label>
                                                <select name="departments[]" id="departments" class="select2 select2-multiple" multiple data-placeholder="دپارتمان">
                                                    @if($news->departments->isNotEmpty())
                                                        @foreach($news->departments as $department)
                                                            <option data-name="{{ $department->name }}" selected value="{{ $department->id }}">
                                                                {{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('departments'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('departments') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group {{ $errors->has('published') ? ' has-error' : '' }}">
                                                <p class="align-top">وضعیت : </p>
                                                <div class="radio radio-success form-check-inline">
                                                    <input name="published" id="published" value="1" {{ ( $news->published() ? 'checked' : null ) }} type="radio">
                                                    <label for="published"> نمایش </label>
                                                </div>
                                                <div class="radio radio-danger form-check-inline">
                                                    <input name="published" id="notPublished" value="0" {{ ( $news->unpublished() ? 'checked' : '' ) }} type="radio">
                                                    <label for="notPublished"> مخفی </label>
                                                </div>
                                                @if ($errors->has('published'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('published') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                                                <label for="content">محتوا</label>
                                                <textarea name="content" class="use-rich-editor" id="content" maxlength="250" rows="6" data-placeholder="محتوای خبر را وارد کنید...">{{ $news->content }}</textarea>
                                            </div>
                                            @if ($errors->has('content'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('content') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-success btn-custom btn-xs-block w-md pull-left waves-effect waves-light"type="submit">
                                                ذخیره تغییرات
                                            </button>
                                        </div>
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
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <!-- KNOB JS -->
    <!--[if IE]>
    <script src="{{ asset('plugins/jquery-knob/excanvas.js') }}"></script>
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
    <script src="{{ asset('plugins/select2/js/i18n/'.app()->getLocale().'.js') }}" type="text/javascript"></script>
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

    <!-- Custom main Js -->
    <script type="text/javascript">
        $(function () {

            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
            });

            $('[data-toggle=tooltip]').tooltip();

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

            tinymce.init({
                selector: "textarea.use-rich-editor",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [
                    {title: 'Bold text', inline: 'b'},
                    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                    {title: 'Example 1', inline: 'span', classes: 'example1'},
                    {title: 'Example 2', inline: 'span', classes: 'example2'},
                    {title: 'Table styles'},
                    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                ],
                directionality: 'rtl',
                content_css: "{{ asset('css/font.css') }},{{ asset('css/tinymce-reset.css') }}",
                language: 'fa',
                init_instance_callback: function (editor) {
                    editor.on('change', function (e) {
                        editor.triggerSave()
                    });
                }
            });

            /*
            $('form').submit(function (e) {
                e.preventDefault();
                console.log('test');
                var btn = $(this).find('button[type=submit]');
                var floatBTN = $('.float-save-btn');
                btn.attr('disabled', 'disabled');
                btn.toggleClass('btn-success btn-secondary');
                btn.html('<i class="fa fa-spinner fa-spin"></i>');
                floatBTN.html('<i class="fa fa-spinner fa-spin"></i>');
                setTimeout(function () {
                    $.Notification.autoHideNotify('success', 'top left', 'انجام شد', 'تنظیمات با موفقیت ذخیره شد');
                    btn.removeAttr('disabled');
                    btn.html('ذخیره تنظیمات');
                    floatBTN.html('<i class="fa fa-save fa-fw"></i>');
                    btn.toggleClass('btn-success btn-secondary');
                }, 5000);
            });
            */
        });//doc
    </script>

@endsection
