@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">show department</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <div class="row">
                        <div class="col-sm-12">

                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>creation time</th>
                                    <th>last update</th>
                                </tr>
                                <tr>
                                    <th>1</th>
                                    <td>{{$department->name}}</td>
                                    <td>{{$department->created_at}}</td>
                                    <td>{{$department->updated_at}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @unless($department->users->isEmpty())
                <div class="panel-heading">managers</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>mobile</th>
                                    <th>email</th>
                                    <th>is leader?</th>
                                </tr>
                                @foreach($department->users as $manager)
                                <tr>
                                    <th>{{ $loop->index+1 }}</th>
                                    <td>{{ $manager->mobile or '&#10008;' }}</td>
                                    <td>{{ $manager->email or '&#10008;' }}</td>
                                    <td>{{ $manager->pivot->is_leader ? '&#10004;' : '&#10008;' }}</td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                    </div>
                </div>
                @endunless

            </div>
        </div>
    </div>
</div>
@endsection
