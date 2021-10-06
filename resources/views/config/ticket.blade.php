@extends('layouts.app')

@section('title','- تنظیمات تیکت')
@section('description','تنظیمات تیکت')
@section('keywords','تنظیمات تیکت')

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
                                <h5 class="card-header m-b-20 b-0">تنظیمات تیکت ها</h5>
                                @include('partial.flashMessage')
                                <form action="{{ route('config.ticket.update') }}" method="POST" role="form" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('ticket_remove_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="ticket_remove_status">حذف پاسخ ها</label>
                                                <div class="col-sm-8">
                                                    <input name="ticket_remove_status" value="1" type="checkbox" id="ticket_remove_status" {{ empty(config('ticket.remove.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('ticket_remove_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('ticket_remove_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('ticket_attachment_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="ticket_attachment_status">ارسال فایل</label>
                                                <div class="col-sm-8">
                                                    <input name="ticket_attachment_status" value="1" type="checkbox" id="ticket_attachment_status" {{ empty(config('ticket.attachment.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('ticket_attachment_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('ticket_attachment_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('user_close_ticket_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="user_close_ticket_status">بستن تیکت - کاربر</label>
                                                <div class="col-sm-8">
                                                    <input name="user_close_ticket_status" value="1" type="checkbox" id="user_close_ticket_status" {{ empty(config('user.closeTicket.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('user_close_ticket_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('user_close_ticket_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('staff_close_ticket_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="staff_close_ticket_status">بستن تیکت - پشتیبان</label>
                                                <div class="col-sm-8">
                                                    <input name="staff_close_ticket_status" value="1" type="checkbox" id="staff_close_ticket_status" {{ empty(config('staff.closeTicket.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('staff_close_ticket_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('staff_close_ticket_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('user_remove_ticket_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="user_remove_ticket_status">حذف تیکت - کاربر</label>
                                                <div class="col-sm-8">
                                                    <input name="user_remove_ticket_status" value="1" type="checkbox" id="user_remove_ticket_status" {{ empty(config('user.removeTicket.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('user_remove_ticket_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('user_remove_ticket_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('staff_remove_ticket_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="staff_remove_ticket_status">حذف تیکت - پشتیبان</label>
                                                <div class="col-sm-8">
                                                    <input name="staff_remove_ticket_status" value="1" type="checkbox" id="staff_remove_ticket_status" {{ empty(config('staff.removeTicket.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('staff_remove_ticket_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('staff_remove_ticket_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('ticket_department_substitution_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="ticket_department_substitution_status">تعویض دپارتمان</label>
                                                <div class="col-sm-8">
                                                    <input name="ticket_department_substitution_status" value="1" type="checkbox" id="ticket_department_substitution_status" {{ empty(config('ticket.department.substitution.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('ticket_department_substitution_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('ticket_department_substitution_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('ticket_rating_status') ? ' has-error' : '' }} row">
                                                <label class="col-sm-4 col-form-label" for="ticket_rating_status">امتیازدهی</label>
                                                <div class="col-sm-8">
                                                    <input name="ticket_rating_status" value="1" type="checkbox" id="ticket_rating_status" {{ empty(config('ticket.rating.status')) ? '' : ' checked ' }} data-plugin="switchery" data-color="#1AB394" data-size="small" data-secondary-color="#ED5565"/>
                                                    @if ($errors->has('ticket_rating_status'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('ticket_rating_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group {{ $errors->has('ticket_attachment_file_formats') ? ' has-error' : '' }}">
                                                <label class=form-label">فرمت های مجاز</label>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="JPG" value="jpg" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('jpg')) ? '' : ' checked ' }}>
                                                            <label for="JPG"> JPG </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="JPEG" value="jpeg" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('jpeg')) ? '' : ' checked ' }}>
                                                            <label for="JPEG"> JPEG </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="PNG" value="png" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('png')) ? '' : ' checked ' }}>
                                                            <label for="PNG"> PNG </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="TXT" value="txt" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('txt')) ? '' : ' checked ' }}>
                                                            <label for="TXT"> TXT </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="HTML" value="html" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('html')) ? '' : ' checked ' }}>
                                                            <label for="HTML"> HTML </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="CSS" value="css" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('css')) ? '' : ' checked ' }}>
                                                            <label for="CSS"> CSS </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="JS" value="js" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('js')) ? '' : ' checked ' }}>
                                                            <label for="JS"> JS </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="JSON" value="json" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('json')) ? '' : ' checked ' }}>
                                                            <label for="JSON"> JSON </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="XML" value="xml" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('xml')) ? '' : ' checked ' }}>
                                                            <label for="XML"> XML </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="PDF" value="pdf" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('pdf')) ? '' : ' checked ' }}>
                                                            <label for="PDF"> PDF </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="PSD" value="psd" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('psd')) ? '' : ' checked ' }}>
                                                            <label for="PSD"> PSD </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="AI" value="ai" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('ai')) ? '' : ' checked ' }}>
                                                            <label for="AI"> AI </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="DOC" value="doc" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('doc')) ? '' : ' checked ' }}>
                                                            <label for="DOC"> DOC </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="RTF" value="rtf" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('rtf')) ? '' : ' checked ' }}>
                                                            <label for="RTF"> RTF </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="PPT" value="ppt" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('ppt')) ? '' : ' checked ' }}>
                                                            <label for="PPT"> PPT </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="RAR" value="rar" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('rar')) ? '' : ' checked ' }}>
                                                            <label for="RAR"> RAR </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="ZIP" value="zip" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('zip')) ? '' : ' checked ' }}>
                                                            <label for="ZIP"> ZIP </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="GIF" value="gif" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('gif')) ? '' : ' checked ' }}>
                                                            <label for="GIF"> GIF </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="TIF" value="tif" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('tif')) ? '' : ' checked ' }}>
                                                            <label for="TIF"> TIF </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="checkbox checkbox-success form-check-inline">
                                                            <input name="ticket_attachment_file_formats[]" id="WebP" value="webp" type="checkbox" {{ empty(getConfig::has_ticket_attachment_file_format('webp')) ? '' : ' checked ' }}>
                                                            <label for="WebP"> WebP </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('ticket_attachment_file_formats'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('ticket_attachment_file_formats') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ ($errors->has('ticket_attachment_file_count') || $errors->has('ticket_attachment_file_size')) ? ' has-error' : '' }} row">
                                                <div class="col-sm-6">
                                                    <label class="control-label" for="ticket_attachment_file_count">حداکثر تعداد فایل</label>
                                                    <input id="ticket_attachment_file_count" value="{{ config('ticket.attachment.file.count') }}" name="ticket_attachment_file_count" class="form-control" style="border-radius: 0;" type="text" placeholder="حداکثر تعداد فایل"/>
                                                    @if ($errors->has('ticket_attachment_file_count'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('ticket_attachment_file_count') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label" for="ticket_attachment_file_size">حداکثر حجم فایل(MB)</label>
                                                    <input id="ticket_attachment_file_size" value="{{ config('ticket.attachment.file.size') }}" name="ticket_attachment_file_size" class="form-control" style="border-radius: 0;" type="text" placeholder="سایز فایل بر حسب MB"/>
                                                    @if ($errors->has('ticket_attachment_file_size'))
                                                        <span class="help-block text-danger">
                                                            <strong>{{ $errors->first('ticket_attachment_file_size') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix m-0">
                                        <button class="btn btn-success w-md waves-effect waves-light float-left btn-xs-block m-r-5" type="submit">ذخیره تنظیمات</button>
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
    <!-- TouchSpin -->
    <script src="{{ asset('plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Notification js -->
    <script src="{{ asset('plugins/notifyjs/dist/notify.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/notify-metro.js') }}"></script>
    <!-- InnerFade -->
    <script src="{{ asset('js/innerfade.js') }}"></script>
    <!--Switchery-->
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script type="text/javascript">
        $(function(){

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
            $("#ticket_attachment_file_count").TouchSpin({
                min: 0,
                max: 10,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary",
                postfix: 'تا'
            });

            $("#ticket_attachment_file_size").TouchSpin({
                min: 0,
                max: 100000,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary",
                maxboostedstep: 10000000,
                postfix: 'MB'
            });
        });
    </script>

@endsection
