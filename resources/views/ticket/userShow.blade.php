@extends('layouts.user.app')

@section('title',' - نمایش تیکت')
@section('description','نمایش تیکت')
@section('keywords','نمایش تیکت')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/dropzone/dropzone.css') }}"  rel="stylesheet">
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Navigation Bar-->
    @include('layouts.user.navigationBar')
    <!-- End Navigation Bar-->

    <!-- Start wrapper -->

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Start Row -->
            <div class="row m-t-20">
                <div class="col-12">
                    @include('partial.flashMessage')
                    <div class="portlet">
                        <div class="portlet-heading">
                            <a class="text-white" href="#ticket-{{ $ticket->id }}">
                                <span class="single-ticket-id hidden-sm">{{ $ticket->id }}</span>
                            </a>
                            <h3 class="pull-right m-0">
                                <span class="single-ticket-title text-inverse ">{{ $ticket->subject }}</span>
                                @if($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_LOW)
                                    <span class="text-inverse m-t-10 font-sm">(کم اهمیت)</span>
                                @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_MEDIUM)
                                    <span class="text-info m-t-10 font-sm hidden">(عادی)</span>
                                @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_HIGH)
                                    <span class="text-warning m-t-10 font-sm">(مهم)</span>
                                @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_EMERGENCY)
                                    <span class="text-danger m-t-10 font-sm">(ضروری)</span>
                                @endif
                            </h3>
                            @can('close',$ticket)
                                @unless($ticket->closed())
                                    <div class="pull-left m-t-15">
                                        <a href="{{ route('ticket.close',$ticket) }}" class="btn btn-success btn-sm waves-effect waves-light m-r-5 m-b-10 btn-xs-block closeTicket text-white">
                                            <i class="fa fa-check"></i>
                                            <span>پاسخ را دریافت کردم تیکت را ببند</span>
                                        </a>
                                    </div>
                                @endunless
                            @endcan
                            <div class="clearfix"></div>
                        </div>
                        <div class="portlet-body text-muted clearfix">
                            <div class="row">
                                <div class="col-12 mb-2 text-justify" style="line-height: 2rem">
                                    <span>ایجاد شده در تاریخ : </span>
                                    <span class="text-primary">{{ Date::make($ticket->created_at)->toJalali()->format('H:i - Y/m/d') }}</span>
                                    <span>برای دپارتمان : </span>
                                    <span class="text-primary">{{ $ticket->department->name }}</span>
                                    <span>آخرین وضعیت تیکت : </span>
                                    @if($ticket->closed())
                                        <span class="text-danger">بسته شده</span>
                                    @elseif($ticket->referral())
                                        <span class="text-dark">ارجاع داده شده</span>
                                    @elseif($ticket->resolved())
                                        <span class="text-success">برطرف شده</span>
                                    @elseif($ticket->replied())
                                        <span class="text-primary">پاسخ داده شده</span>
                                    @elseif($ticket->unreaded())
                                        <span class="text-warning">خوانده نشده</span>
                                    @elseif($ticket->readed())
                                        <span class="text-info">در انتظار بررسی</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->

            <!-- Start Row -->
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            @if($ticket->user)
                            <p class="pull-right m-0">
                                <img width="40" class="rounded-circle single-ticket-user-avatar" src="{{ $ticket->user->avatar_url }}" alt="user avatar">
                                <span>{{ $ticket->user->name }}</span>
                            </p>
                            @else
                            <p width="40" class="pull-right m-0">
                                <img class="rounded-circle single-ticket-user-avatar" src="{{ asset('images/male_avatar.png') }}" alt="user avatar">
                                <span>کاربر مهمان</span>
                            </p>
                            @endif
                            @can('delete',$ticket)
                            <div class="pull-left">
                                <form action="{{ route('ticket.destroy',$ticket) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-outline-danger btn-sm deleteTicket">
                                        <i class="fa fa-trash"></i>
                                        <span>حذف</span>
                                    </button>
                                </form>
                            </div>
                            @endcan
                        </div>
                        <div class="card-body">
                            {!! $ticket->content !!}
                            @if($ticket->attachments->isNotEmpty())
                                <!-- show this section only if ticket has at least 1 file attached -->
                                <p class="single-ticket-file">
                                    @foreach($ticket->attachments as $attachment)
                                        <a  data-toggle="tooltip" title="" data-original-title="{{ $attachment->name.'.'.$attachment->extension }}" href="{{ route('media.attachment',$attachment) }}">
                                            <i class="ti-zip align-middle"></i>
                                            <span>پیوست شماره</span>
                                            <span>{{ $loop->index+1 }}</span>
                                        </a>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                        <div class="card-footer text-muted">
                            <i class="fa fa-clock-o"></i> {{ Date::make($ticket->created_at)->toJalali()->format('H:i - Y/m/d') }} &nbsp;
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->

            @each('ticket.replies', $ticket->children, 'ticket')

            <div class="row">
                <div class="col-12">
                    <div class="portlet">
                        <div class="portlet-heading portlet-default">
                            <h3 class="pull-right portlet-title text-dark">
                                ارسال پاسخ
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="portlet-body clearfix" id="addReply">
                            <form class="form-horizontal" method="POST" action="{{ route('ticket.reply',$ticket) }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group clearfix">
                                            <button class="btn btn-outline-primary w-lg btm-sm waves-effect waves-light btn-xs-block pull-left m-t-10" type="button" data-toggle="modal" data-target="#uploadModal">
                                                <i class="fa fa-cloud-upload"></i>
                                                <span>افزودن فایل به تیکت</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group{{ $errors->has('reply') ? ' has-error' : '' }}">
                                            <textarea class="form-control use-rich-editor" name="reply" placeholder="پاسخ خود را وارد کنید..." id="reply" cols="30" rows="10">{{ old('reply') }}</textarea>
                                            @if ($errors->has('reply'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('reply') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div id="attachments"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button class="btn btn-success w-lg btn-custom btm-sm waves-effect waves-light btn-xs-block pull-left"
                                                    type="submit">
                                                <i class="fa fa-check"></i>
                                                <span>ارسال پاسخ</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!--DropZone Uploader Start-->
                            @include('layouts.uploadModal')
                            <!--DropZone Uploader End-->
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end container -->
    </div>

    <!-- End wrapper -->

    <!-- Footer -->
    @include('layouts.user.footer')
    <!-- End Footer -->
    @include('layouts.lockScreenModal')
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

    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <!-- Notification js -->
    <script src="{{ asset('plugins/notifyjs/dist/notify.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/notify-metro.js') }}"></script>
    <!-- Counter Up  -->
    <script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
    <!-- CustomBox -->
    <script src="{{ asset('plugins/custombox/dist/custombox.min.js') }}"></script>
    <script src="{{ asset('plugins/custombox/dist/legacy.min.js') }}"></script>
    <!-- idle timer -->
    <script src="{{ asset('plugins/jquery-idle/jquery.idle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/i18n/fa.js') }}"></script>
    <!-- DropZone -->
    <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
    </script>
    <script src="{{ asset('js/star-rating.min.js') }}"></script>


@endsection

@section('bodyImport.append')

    <!-- Custom main Js -->
    <script>
        jQuery(document).ready(function ($) {

            $('[data-toggle=tooltip]').tooltip();

            $('.navbar-toggle.nav-link').click(function () {
                $(this).toggleClass('open');
                $('#navigation').slideToggle(400);
            });

            $('#title').keyup(function(){
               var content = '<ul class="m-0"><li><a href="#">عنوان یکی از اخبار یا سوالات متداول</a></li>' + '<li><a href="#">عنوان یکی از اخبار یا سوالات متداول</a></li>' + '<li><a href="#">عنوان یکی از اخبار یا سوالات متداول</a></li></ul>';
               $('.relatedSearchIcon').fadeIn();
               $('.showRelatedContent').fadeIn();
               setTimeout(function(){
                   $('.showRelatedContent').html(content);
               },3000);
            });

            $('#title').blur(function(){
                $('.relatedSearchIcon').hide();
                $('.showRelatedContent').hide();
                $('.showRelatedContent').html('');
            });

            $(".my-rating").starRating({
                totalStars: 5,
                starShape: 'rounded',
                strokeColor: '#894A00',
                activeColor: 'gold',
                emptyColor: '#d9d9d9',
                strokeWidth: 10,
                starSize: 20,
                useGradient: false,
                disableAfterRate: false,
                useFullStars: true,
                callback: function(currentRating, $el){
                    $.ajax({
                        url: '{{ route('rate.store') }}',
                        data: {
                            id: $el.attr('data-id'),
                            type:$el.attr('data-type') ,
                            rate: currentRating,
                            _token: token
                        },
                        dataType: "json",
                        type: 'POST',
                        success: function () {
                            $.Notification.autoHideNotify('success', 'top left', 'انجام شد', 'امتیاز شما با موفقیت ثبت شد');
                        },
                        error: function () {
                            $.Notification.autoHideNotify('error', 'top left', 'انجام نشد', 'در امتیاز دهی مشکلی به وجود آمده است');
                        }
                    });
                }
            });

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
                    maxFiles: {{ config('ticket.attachment.file.count') }},
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
                                    if(response.responseJSON){
                                        if(response.responseJSON.action && response.responseJSON.action[0]){
                                            return done(response.responseJSON.action[0]);
                                        }else if(response.responseJSON.name && response.responseJSON.name[0]){
                                            return done(response.responseJSON.name[0]);
                                        }else if(response.responseJSON.size && response.responseJSON.size[0]){
                                            return done(response.responseJSON.size[0]);
                                        }else if(response.responseJSON.id && response.responseJSON.id[0]){
                                            return done(response.responseJSON.id[0]);
                                        }else if(response.responseJSON.start && response.responseJSON.start[0]){
                                            return done(response.responseJSON.start[0]);
                                        }else if(response.responseJSON.end && response.responseJSON.end[0]){
                                            return done(response.responseJSON.end[0]);
                                        }else if(response.responseJSON.media && response.responseJSON.media[0]){
                                            return done(response.responseJSON.media[0]);
                                        }
                                    }
                                    return done('{{ trans('general.file_unknown_upload_error') }}');
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
                        console.log(chunk);
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
                        //append to ticket form
                        $('#attachments').append(hiddenId);
                        return file.previewElement.classList.add("dz-success");
                      }
                    },

                    // Called whenever a file is removed.
                    removedfile: function removedfile(file) {
                        if (file.previewElement != null && file.previewElement.parentNode != null) {
                            file.previewElement.parentNode.removeChild(file.previewElement);
                        }
                        //remove from ticket form
                        $('#attachments').find('[value="'+file.id+'"]').remove();
                        return this._updateMaxFilesReachedClass();
                    }

                });
            }
        });
        tinymce.init({
            selector: "textarea.use-rich-editor",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview | forecolor backcolor emoticons",
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
    </script>

@endsection
