@extends('layouts.app')

@section('title','- تنظیمات عمومی')
@section('description','تنظیمات عمومی')
@section('keywords','تنظیمات عمومی')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css">
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
                                <span class="float-save-btn">
                                    <i class="fa fa-save fa-fw"></i>
                                </span>
                                <h5 class="card-header m-b-20 b-0">تنظیمات عمومی</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('config.general.update') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-group {{ $errors->has('site_name') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_name">عنوان سایت</label>
                                        <div class="col-sm-10">
                                            <input name="site_name" class="form-control" id="site_name" value="{{ config('app.name') }}" placeholder="عنوان یا نام سایت" type="text">
                                            @if ($errors->has('site_name'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ ($errors->has('site_logo_src') || $errors->has('site_logo_alt')) ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_logo_src">لوگوی سایت</label>
                                        <div class="col-sm-10">
                                            <input name="site_logo_alt" class="form-control m-b-5" id="site_logo_alt" value="{{ config('app.logo.alt') }}" placeholder="لوگو نوشتاری" type="text">
                                            @if ($errors->has('site_logo_alt'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_logo_alt') }}</strong>
                                                </span>
                                            @endif
                                            <input name="site_logo_src" class="form-control m-b-5" id="site_logo_src" value="{{ config('app.logo.src') }}" placeholder="آدرس تصویر لوگو" type="text">
                                            @if ($errors->has('site_logo_src'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_logo_src') }}</strong>
                                                </span>
                                            @endif
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <img src="{{ empty(config('app.logo.src')) ? asset('images/your-logo.jpg') : config('app.logo.src') }}" alt="logo" class="site-logo-demo"/>
                                                </div>
                                                <!--DropZone Uploader Start-->
                                                <div class="col-sm-9">
                                                    @include('layouts.dropzonePreviewTemplate')
                                                    <div class="dropzone" id="dropzone" method="POST" action="{{ route('media.storeChunk') }}" enctype="multipart/form-data">
                                                        <div class="fallback">
                                                            <input name="media" type="file"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--DropZone Uploader End-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('main_address') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="main_address">آدرس سایت اصلی</label>
                                        <div class="col-sm-10">
                                            <input name="main_address" class="form-control" id="main_address" value="{{ config('main.url') }}" type="text">
                                            @if ($errors->has('main_address'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('main_address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_address') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_address">آدرس سیستم تیکت</label>
                                        <div class="col-sm-10">
                                            <input name="site_address" class="form-control" id="site_address" value="{{ config('app.url') }}" type="text" disabled="disabled">
                                            @if ($errors->has('site_address'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('core_version') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="core_version">نسخه سیستم</label>
                                        <div class="col-sm-10">
                                            <input name="core_version" class="form-control" id="core_version" value="{{ config('app.core.version') }}" type="text" disabled="disabled">
                                            @if ($errors->has('core_version'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('core_version') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_description') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_description">توضیحات</label>
                                        <div class="col-sm-10">
                                            <input name="site_description" class="form-control" id="site_description" value="{{ config('app.description') }}" placeholder="توضیحات(تگ description)" type="text">
                                            @if ($errors->has('site_description'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_keywords') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_keywords">کلمات کلیدی</label>
                                        <div class="col-sm-10">
                                            <input name="site_keywords" class="form-control" id="site_keywords" value="{{ config('app.keywords') }}" placeholder="کلمات کلیدی(تگ keywords)" type="text">
                                            @if ($errors->has('site_keywords'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_keywords') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_rules') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_rules">قوانین و مقررات</label>
                                        <div class="col-sm-10">
                                            <textarea name="site_rules" class="form-control" id="site_rules" placeholder="قوانین و مقررات سایت" cols="30" rows="10">{{ config('app.rules') }}</textarea>
                                            @if ($errors->has('site_rules'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_rules') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_landing_page_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_landing_page_status" data-toggle="tooltip" title="نمایش/عدم نمایش صفحه فرود">صفحه فرود</label>
                                        <div class="col-sm-10">
                                            <input value="1" name="site_landing_page_status" type="checkbox" id="site_landing_page_status" {{ (config('app.landingPage.status')==true) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('site_landing_page_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_landing_page_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_guest_ticket_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_guest_ticket_status" data-toggle="tooltip" title="کاربران میتوانند بدون عضویت تیکت ارسال کنند(ارسال تیکت مهمان تنها در صفحه فرود امکان پذیر است)">تیکت مهمان</label>
                                        <div class="col-sm-10">
                                            <input value="1" name="site_guest_ticket_status" type="checkbox" id="site_guest_ticket_status" {{ ((config('app.guestTicket.status'))==true) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('site_guest_ticket_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_guest_ticket_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('site_registration_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="site_registration_status" data-toggle="tooltip" title="باز/بسته بودن بخش ثبت نام">ثبت نام</label>
                                        <div class="col-sm-10">
                                            <input value="1" name="site_registration_status" type="checkbox" id="site_registration_status" {{ (config('app.registration.status')==true) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('site_registration_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('site_registration_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('email_verification_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="email_verification_status" data-toggle="tooltip" title="با فعال بودن این گزینه بخش ایمیل در صفحه ثبت نام اجباری خواهد شد و حساب کاربران تا زمان تایید ایمیلشان فعال نخواهد شد">
                                            تایید ایمیل
                                            <span class="form-text text-muted">* نیازمند تنظیمات ایمیل</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input value="1" name="email_verification_status" type="checkbox" id="email_verification_status" {{ (config('email.verification.status')==true) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('email_verification_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('email_verification_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('mobile_verification_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="mobile_verification_status" data-toggle="tooltip" title="با فعال بودن این گزینه بخش شماره همراه در صفحه ثبت نام اجباری خواهد شد و حساب کاربران تا زمان تایید شماره همراهشان فعال نخواهد شد">
                                            تایید شماره همراه
                                            <span class="form-text text-muted">* نیازمند فعال بودن سامانه پیامکی</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input value="1" name="mobile_verification_status" type="checkbox" id="mobile_verification_status" data-plugin="switchery" {{ (config('mobile.verification.status')==true) ? ' checked ' : '' }} data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('mobile_verification_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('mobile_verification_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('sms_notification_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="sms_notification_status" data-toggle="tooltip" title="با فعال بودن این گزینه اطلاع رسانی های سایت با استفاده از پیامک صورت خواهد گرفت">
                                            اطلاع رسانی با استفاده از پیامک
                                            <span class="form-text text-muted">* نیازمند فعال بودن سامانه پیامکی</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input value="1" name="sms_notification_status" type="checkbox" id="sms_notification_status" {{ (config('sms.notification.status')==true) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('sms_notification_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('sms_notification_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('email_notification_status') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="email_notification_status" data-toggle="tooltip" title="با فعال بودن این گزینه اطلاع رسانی های سایت با استفاده از ایمیل صورت خواهد گرفت">
                                            اطلاع رسانی با استفاده از ایمیل
                                            <span class="form-text text-muted">* نیازمند تنظیمات ایمیل</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input name="email_notification_status" value="1" type="checkbox" id="email_notification_status" {{ (config('email.notification.status')==true) ? ' checked ' : '' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                            @if ($errors->has('email_notification_status'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('email_notification_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block" type="submit">ذخیره تنظیمات</button>
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
    <!-- DropZone -->
    <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
    </script>
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

            $('.float-save-btn').click(function () {
                $('button[type=submit]').click();
            });
            /*
            $('form').submit(function (e) {
                e.preventDefault();
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
    <script type="text/javascript">
        var $ = window.$; // use the global jQuery instance
        var token=$('input[name=_token]').val(); //csrf token
        if ($("#dropzone").length > 0) {

            // A quick way setup
            var myDropzone = new Dropzone("#dropzone", {

                chunking: true,
                forceChunking: true,
                method: "POST",
                chunkSize: 100*1024,//100KB
                retryChunks: true,
                retryChunksLimit: 30,
                addRemoveLinks: true,
                previewTemplate: $('#dropzonePreview').html(),
                maxFilesize: {{ config('ticket.attachment.file.size') }},
                maxFiles: 1,
                acceptedFiles:'image/*',
                paramName:'media',

                accept: function(file, done)
                {
                    $.ajax({
                        url: myDropzone.options.url,
                        data: {
                            action: 'add',
                            name: file.name,
                            size: file.size,
                            _token: token
                        },
                        dataType: "json",
                        type: myDropzone.options.method,
                        success: function(response)
                        {
                            //if has error:
                            if(response.hasError){
                                return done(response.error);
                            }
                            //has no error:
                            file.id = response.id;

                            return done();
                        },
                        error: function(response)
                        {
                            //if has error:
                            if(response.hasError){
                                return done(response.error);
                            }else{
                                return done('Error on preparing the file upload.');
                            }
                        }
                    });
                },

                //show progress percent
                uploadprogress: function(file, progress, bytesSent){

                    //use returned percent from server:
                    try {
                       var response = JSON.parse(file.xhr.responseText);
                       progress=response.progressPercent;
                    } catch (error) {
                        response = "Invalid JSON response from server.";
                    }

                    if (file.previewElement) {
                        for (var _iterator8 = file.previewElement.querySelectorAll("[data-dz-uploadprogress]"), _isArray8 = true, _i8 = 0, _iterator8 = _isArray8 ? _iterator8 : _iterator8[Symbol.iterator]();;) {
                            var _ref7;
                            if (_isArray8) {
                                if (_i8 >= _iterator8.length) break;
                                _ref7 = _iterator8[_i8++];
                            } else {
                                _i8 = _iterator8.next();
                                if (_i8.done) break;
                                _ref7 = _i8.value;
                            }
                            var node = _ref7;
                            node.nodeName === 'PROGRESS' ? node.value = progress : node.style.width = progress + "%";
                        }
                    }
                },

                params: function params(files, xhr, chunk) {
                    if (chunk) {
                        return {
                            action:'upload',
                            _token: token,
                            id: chunk.file.id,
                            name: chunk.file.name,
                            size: chunk.file.size,
                            start: chunk.index * this.options.chunkSize,
                            end: (Math.min(((chunk.index * this.options.chunkSize) + this.options.chunkSize), chunk.file.size)),
                            chunksize: this.options.chunkSize,
                        };
                    }
                },

                // When the complete upload is finished and successful
                // Receives `file`
                success: function success(file) {
                  if (file.previewElement) {
                    //change site_logo_src value
                    $('#site_logo_src').val("{{url('media/show/')}}/"+file.id);
                    //add hidden input for media's id
                    var hiddenId = Dropzone.createElement("<input name=medias[] type=\"hidden\" value=\""+file.id+"\" >");
                    file.previewElement.appendChild(hiddenId);
                    return file.previewElement.classList.add("dz-success");
                  }
                },

                // Called whenever a file is removed.
                removedfile: function removedfile(file) {
                    if (file.previewElement != null && file.previewElement.parentNode != null) {
                        file.previewElement.parentNode.removeChild(file.previewElement);
                    }
                    return this._updateMaxFilesReachedClass();
                }

            });
        }
    </script>

@endsection
