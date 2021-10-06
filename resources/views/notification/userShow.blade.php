@extends('layouts.user.app')

@section('title',$notification->subject.' - خواندن ')
@section('description',$notification->subject)
@section('keywords',$notification->subject)

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

            <div class="row m-t-20">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="card-header m-b-20 b-0">
                                            <span>({{ $notification->subject }})</span>
                                        </h5>
                                    </div>

                                    <div class="panel-body">
                                        @include('partial.flashMessage')
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>عنوان</th>
                                                        <th>تاریخ ایجاد شدن</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @if($notification->subject)
                                                            <td>{{ $notification->subject }}</td>
                                                        @else
                                                            <td class="text-center text-danger">
                                                                <span class="fa fa-close"></span>
                                                            </td>
                                                        @endif
                                                        <td>{{ Date::make($notification->created_at)->toJalali()->format('Y/m/d') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="col-xs-12 col-sm-12">
                                                <div class="border-left border-right alert alert-light">
                                                    {!! $notification->message !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                useGradient: false
            });

            $(".my-rating-disabled").starRating({
                totalStars: 5,
                starShape: 'rounded',
                strokeColor: '#894A00',
                activeColor: 'gold',
                emptyColor: '#d9d9d9',
                strokeWidth: 10,
                starSize: 20,
                useGradient: false,
                readOnly: true
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
    </script>

@endsection
