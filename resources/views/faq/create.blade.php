@extends('layouts.app')
@section('headImport.styles.prepend')

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
                                <h5 class="card-header m-b-20 b-0">ایجاد پرسش و پاسخ</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('faq.store') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="form-group {{ $errors->has('question') ? ' has-error' : '' }}">
                                                <label for="question">پرسش</label>
                                                <textarea name="question" class="use-rich-editor" id="question" maxlength="250" rows="6" data-placeholder="پرسش..." required></textarea>
                                            </div>
                                            @if ($errors->has('question'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('question') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <div class="form-group {{ $errors->has('answer') ? ' has-error' : '' }}">
                                                <label for="answer">پاسخ</label>
                                                <textarea name="answer" class="use-rich-editor" id="answer" maxlength="250" rows="6" data-placeholder="پاسخ..." required></textarea>
                                            </div>
                                            @if ($errors->has('answer'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('answer') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group clearfix m-0">
                                        <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block m-r-5" type="submit">ایجاد پرسش و پاسخ</button>
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
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
    <!--tinyMCE-->
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>

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
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
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
