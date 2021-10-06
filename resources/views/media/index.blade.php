@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">medias list</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <div class="row">
                        <div class="col-sm-12">

                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>size</th>
                                    <th>extension</th>
                                    <th>path</th>
                                    <th>is completed?</th>
                                    <th>creation time</th>
                                    <th>#action</th>
                                </tr>
                                @foreach($medias as $media)
                                <tr>
                                    <th>{{$loop->index+1}}</th>
                                    <td>{{ $media->name }}</td>
                                    <td>{{ $media->size }}</td>
                                    <td>
                                        {{ $media->extension }}
                                    </td>
                                    <td>{{ $media->real_name.'.'.$media->extension }}</td>
                                    <td>{{ ($media->completed()?'yes':'no') }}</td>
                                    <td>{{$media->created_at}}</td>
                                    <td>
                                        <form action="{{ route('media.destroy',$media) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <a class="btn btn-default" href="{{ route('media.show',$media) }}">show</a>
                                            <a class="btn btn-default" href="{{ route('media.show',$media) }}">download</a>
                                            <button class="btn btn-danger" type="submit">
                                                remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                        <div class="text-center">
                            {{ $medias->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
