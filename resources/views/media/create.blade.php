@extends('layouts.app')
@section('headImports')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.min.css') }}">
    <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>

    <script>
        Dropzone.autoDiscover = false;
    </script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add new media</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <form class="form-horizontal" method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <fieldset>

                            <div class="form-group{{ $errors->has('media') ? ' has-error' : '' }}">
                                <label for="media" class="col-md-4 control-label">media</label>

                                <div class="col-md-6">
                                    <input id="media" type="file" class="form-control" name="media" autofocus>

                                    @if ($errors->has('media'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('media') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </fieldset>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    create
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- upload using ajax -->
                    <form id="my-awesome-dropzone" class="form-horizontal text-center dropzone" method="POST" action="{{ route('media.storeChunk') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    </form>

                    {{--Dropzone Preview Template--}}
                    <div id="dropzonePreview" style="display: none;">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-image"><img data-dz-thumbnail /></div>
                            <div class="dz-details">
                                <div class="dz-size"><span data-dz-size></span></div>
                                <div class="dz-filename"><span data-dz-name></span></div>
                            </div>
                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                            <div class="dz-success-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                    <title>Check</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="dz-error-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                    <title>error</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                    {{--End of Dropzone Preview Template--}}

                    <script>
                        var $ = window.$; // use the global jQuery instance

                        if ($("#my-awesome-dropzone").length > 0) {

                            // A quick way setup
                            var myDropzone = new Dropzone("#my-awesome-dropzone", {

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
                                            _token: $('input[name=_token]').val()
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


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
