@extends('layouts.app')

@section('title',' - ایجاد تیکت جدید')
@section('description','ایجاد تیکت جدید')
@section('keywords','ایجاد تیکت جدید')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/dropzone/dropzone.css') }}"  rel="stylesheet">

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
                    <div class="row m-t-20">
                        <div class="col-12">
                            <div class="card-box">
                                <h5 class="card-header m-b-20 b-0">ارسال تیکت جدید</h5>
                                @include('partial.flashMessage')
                                <form method="POST" action="{{ route('ticket.store') }}" class="form-horizontal" role="form">
                                    {{ csrf_field() }}
                                    <div class="form-group {{ $errors->has('subject') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="subject">عنوان</label>
                                        <div class="col-sm-10">
                                            <input name="subject" value="{{ old('subject') }}" class="form-control" type="text" id="subject" placeholder="موضوع تیکت خود را وارد کنید"/>
                                            <span class="fa fa-spinner fa-spin relatedSearchIcon" style="display: none;"></span>
                                            <div class="showRelatedContent"></div>
                                            @if ($errors->has('subject'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('subject') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @inject('departmentModel','App\Department')
                                    @php
                                        $departments=$departmentModel::orderBy('name')->get();
                                    @endphp

                                    @unless($departments->isEmpty())

                                    <div class="form-group {{ $errors->has('department') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="department">دپارتمان</label>
                                        <div class="col-sm-10">
                                            <select name="department" id="department" class="form-control" data-placeholder="دپارتمان تیکت را انتخاب کنید">
                                                @unless($departments->isEmpty())
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}" {{ old('department')==$department->id ?' selected ':'' }}>{{ $department->name }}</option>
                                                    @endforeach
                                                @endunless
                                            </select>
                                            @if ($errors->has('department'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('department') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @endUnless

                                    @inject('priorityClass','App\Http\Controllers\Ticket\TicketPriority')
                                    @php
                                        $priorities=$priorityClass::getList();
                                    @endphp

                                    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }} row">
                                        <label for="priority" class="col-sm-2 col-form-label">اولویت</label>
                                        <div class="col-sm-10">
                                            <select id="priority" class="form-control" name="priority">
                                                @foreach($priorities as $priorityId=>$priorityName)
                                                    <option value="{{ $priorityId }}" {{ old('priority')==$priorityId ?' selected ':'' }}>{{ $priorityName }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('priority'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('priority') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('user') ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="user">انتخاب کاربر</label>
                                        <div class="col-sm-10">
                                            <div class="jumbotron bg-light py-3 m-b-10">
                                                @inject('userModel','App\User')
                                                @php
                                                    $user=$userModel::find(request()->input('user'));
                                                @endphp
                                                <select id="user" class="form-control select2" name="user" data-placeholder="کاربر">
                                                    @if($user)
                                                        <option data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-mobile="{{ $user->mobile }}" value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                                    @endif
                                                </select>
                                                @if ($errors->has('user'))
                                                    <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('user') }}</strong>
                                                </span>
                                                @else
                                                    <span class="help-block text-muted">
                                                    <strong>در صورت عدم انتخاب کاربر , تیکت برای خودتان ایجاد میشود</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group {{ ($errors->has('content') || $errors->has('medias')) ? ' has-error' : '' }} row">
                                        <label class="col-sm-2 col-form-label" for="content">محتوا</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control use-rich-editor" name="content" placeholder="محتوا تیکت" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
                                            @if ($errors->has('content'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('content') }}</strong>
                                                </span>
                                            @endif
                                            @if ($errors->has('medias'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('content') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="attachments"></div>
                                    <div class="form-group row clearfix">
                                        <div class="col-12">
                                            <button class="btn btn-success btn-xs-block w-md pull-left m-r-5 m-t-5" type="submit">ارسال تیکت</button>
                                            <button class="btn btn-primary w-md btn-xs-block pull-left m-t-5" type="button" data-toggle="modal" data-target="#uploadModal">افزودن فایل به تیکت</button>
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

    <!--userInfoModel Start-->
    @include('layouts.userInfoModal')
    <!--userInfoModel End-->

    <!--staffInfoModal Start-->
    @include('layouts.staffInfoModal')
    <!--staffInfoModal End-->

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
    <!-- DropZone -->
    <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
    </script>

@endsection

@section('bodyImport.append')

    <script>
        jQuery(document).ready(function ($) {

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

            $('#user').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('user.list') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    allowClear: true,
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
                multiple: false,
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
                var name,mobile,email;
                name=mobile=email='';
                if(repo.element){
                    name=repo.element.getAttribute('data-name');
                    mobile=repo.element.getAttribute('data-mobile');
                    email=repo.element.getAttribute('data-email');
                }
                return htmlentities(repo.name || repo.mobile || repo.email || name || mobile || email);
            }

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
