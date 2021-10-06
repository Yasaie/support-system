@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">media</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <div class="row">
                        <div class="col-sm-12">

                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>name</th>
                                    <th>size</th>
                                    <th>extension</th>
                                    <th>path</th>
                                    <th>is completed?</th>
                                    <th>creation time</th>
                                    <th>#action</th>
                                </tr>
                                <tr>
                                    <td>{{ $media->name }}</td>
                                    <td>{{ $media->size }}</td>
                                    <td>
                                        {{ $media->extension }}
                                    </td>
                                    <td>{{ $media->real_name.'.'.$media->extension }}</td>
                                    <td>{{ ($media->completed()?'yes':'no') }}</td>
                                    <td>{{$media->created_at}}</td>
                                </tr>
                            </table>
                            @if($media->completed() && File::exists($media->path))
                                <img src="{{ $media->path }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
