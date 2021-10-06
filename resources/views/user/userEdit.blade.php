@extends('layouts.user.app')

@section('title',' - ویرایش کاربر')
@section('description','ویرایش کاربر')
@section('keywords','ویرایش کاربر')

@section('headImport.styles.prepend')

    <link href="{{ asset('plugins/jquery-circliful/css/jquery.circliful.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/persian-datepicker/persian-datepicker.css') }}">
    <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/dropzone/dropzone.css') }}"  rel="stylesheet">

@endsection

@section('content')

    <!-- Navigation Bar-->
    @include('layouts.user.navigationBar')
    <!-- End Navigation Bar-->

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row m-t-20">
                <div class="col-12">
                    <div class="card-box">
                        <h5 class="card-header m-b-20 b-0">ویرایش اطلاعات</h5>
                        @include('partial.flashMessage')
                        <form method="POST" class="form-horizontal" action="{{ route('user.update',$user) }}" role="form">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label" for="name">نام و نام خانوادگی</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" id="name" class="form-control" value="{{ $user->name }}" placeholder="مثال: علی" autofocus required/>
                                    @if ($errors->has('name'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label" for="email">ایمیل</label>
                                <div class="col-sm-10">
                                    <input name="email" type="email" id="email" class="form-control" value="{{ $user->email }}" placeholder="مثال: example@domain.com"/>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label" for="mobile">شماره همراه</label>
                                <div class="col-sm-10">
                                    <input name="mobile" type="text" id="mobile" class="form-control" value="{{ $user->mobile }}" placeholder="مثال: 09123456789"/>
                                    @if ($errors->has('mobile'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label" for="phone">شماره تماس</label>
                                <div class="col-sm-10">
                                    <input name="phone" type="text" id="phone" class="form-control" value="{{ $user->phone }}" placeholder="مثال: 02112345678"/>
                                    @if ($errors->has('phone'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} row">
                                <div class="col-xs-12 col-sm-6">
                                    <label for="password">کلمه عبور</label>
                                    <input name="password" type="password" id="password" class="form-control" placeholder="کلمه عبور">
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label for="password_confirmation">تکرار کلمه عبور</label>
                                    <input name="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="تکرار کلمه عبور">
                                </div>
                            </div>

                            <div class="form-group {{ ($errors->has('country') || $errors->has('province') || $errors->has('city')) ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label">موقعیت مکانی</label>
                                <div class="col-sm-4">
                                    <select name="country" id="country" class="select2" data-placeholder="کشور را وارد کنید">
                                        @if($user->country)
                                            <option data-name="{{ $user->country->name }}" selected value="{{ $user->country_id }}">
                                                {{ $user->country->name }}
                                            </option>
                                        @endif
                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-3">
                                    <select name="province" id="province" class="select2" data-placeholder="استان را انتخاب کنید">
                                        @if($user->province)
                                            <option data-name="{{ $user->province->name }}" selected value="{{ $user->province_id }}">
                                                {{ $user->province->name }}
                                            </option>
                                        @endif
                                    </select>
                                    @if ($errors->has('province'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('province') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <select name="city" id="city" class="select2" data-placeholder="شهر را انتخاب کنید">
                                         @if($user->city)
                                            <option data-name="{{ $user->city->name }}" selected value="{{ $user->city_id }}">
                                                {{ $user->city->name }}
                                            </option>
                                        @endif
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label" for="gender-male">جنسیت</label>
                                <div class="col-sm-10">
                                    <div class="radio radio-success form-check-inline">
                                        <input name="gender" id="gender-male" value="male" {{ ($user->gender=='male' ? ' checked ' : null) }} type="radio">
                                        <label for="gender-male"> مرد </label>
                                    </div>
                                    <div class="radio radio-danger form-check-inline">
                                        <input name="gender" id="gender-female" value="female" {{ ($user->gender=='female' ? ' checked ' : null) }} type="radio">
                                        <label for="gender-female"> زن </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="jumbotron py-4 m-b-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p style="margin: 0px 40px 10px 35px;">تصویر پروفایل</p>
                                            <img src="{{ $user->avatar_url }}" alt="user avatar" class="user-profile-avatar-demo"/>
                                            <input name="avatar" value="{{ $user->avatar }}" type="hidden">
                                            <button class="btn btn-secondary btn-sm w-md waves-effect waves-light" type="button" data-toggle="modal" data-target="#uploadModal">
                                                <i class="ti-upload m-l-10"></i>
                                                <span>آپلود تصویر جدید</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('biography') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="bio">درباره</label>
                                        <textarea name="biography" class="form-control" id="biography" rows="6" placeholder="درباره کاربر بنویسید...">{{ $user->biography }}</textarea>
                                        @if ($errors->has('biography'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('biography') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="attachments"></div>
                            <div class="form-group clearfix m-0">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success btn-xs-block w-md pull-left m-r-5 m-t-5" type="submit">
                                            ذخیره پروفایل
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @include('layouts.uploadModal')
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->

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
    <script src="{{ asset('js/detect.js') }}"></script>
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <!-- KNOB JS -->
    <!--[if IE]>
    <script src="{{ asset('plugins/jquery-knob/excanvas.js')}}"></script>
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
    <!-- Confirm JS -->
    <script src="{{ asset('plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <!-- Persian Datepicker -->
    <script src="{{ asset('plugins/persian-datepicker/persian-date.js') }}"></script>
    <script src="{{ asset('plugins/persian-datepicker/persian-datepicker.js') }}"></script>
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
        $(function() {


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
                        var hiddenId = Dropzone.createElement("<input name=\"avatar\" type=\"hidden\" value=\""+file.id+"\" >");
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

            $('#news').innerfade({
                speed: 1000,
                timeout: 5000,
                wait: 1000
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

                markup += "<span class='fa fa-map-pin m-r-5 m-l-5'></span>";

                markup += "<span>" + htmlentities(repo.name || repo.short_name) + "</span>";

                markup += "</div>";
                return markup;
            }

            function formatRepoSelection (repo) {
                var selectedName;
                if(repo.element){
                    selectedName=repo.element.getAttribute('data-name');
                }
                if(repo.name || repo.short_name || selectedName){
                    return htmlentities(repo.name || repo.short_name || selectedName);
                }
            }

            $('#country').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('country.index') }}',
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
                multiple: false,
                minimumInputLength: 0,
                // let our custom formatter work
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            $('#province').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('province.index') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            country: ($('#country').val() ? $('#country').val() : 'notFound' ),
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
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            $('#city').select2({
                dir: 'rtl',
                language: 'fa',
                ajax: {
                    url: '{{ route('city.index') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: false,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            province: ($('#province').val() ? $('#province').val() : 'notFound' ),
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
                escapeMarkup: function (markup) { return markup; },
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            /*
            $('form').submit(function (e) {
                e.preventDefault();
                var btn = $(this).find('button[type=submit]');
                btn.attr('disabled', 'disabled');
                btn.html('<i class="fa fa-spinner fa-spin"></i>');
                setTimeout(function () {
                    $.Notification.autoHideNotify('success', 'top left', 'ایجاد شد', 'کاربر با موفقیت ایجاد شد');
                    btn.attr('onclick', "location.href='users.php'");
                    btn.removeAttr('disabled');
                    btn.html('<i class="ti-angle-right m-l-10"></i>' + '<span>بازگشت به کاربران </span>');
                    btn.toggleClass('btn-success btn-secondary');
                }, 5000);
            });
            */
        });//doc

    </script>

@endsection
