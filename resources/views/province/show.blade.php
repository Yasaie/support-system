@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Province</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <div class="row">
                        <div class="col-sm-12">

                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>name</th>
                                    <th>country's name</th>
                                    <th>creation time</th>
                                </tr>
                                <tr>
                                    <td>{{$province->name or ' not found '}}</td>
                                    <td>{{ $province->country->name }} - {{ $province->country->short_name }}</td>
                                    <td>{{$province->created_at}}</td>
                                </tr>
                            </table>

                            @unless($province->cities->isEmpty())
                            <p>Cities:</p>
                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>name</th>
                                    <th>creation time</th>
                                </tr>
                                @foreach($province->cities as $province)
                                <tr>
                                    <td>{{$province->name or ' not found '}}</td>
                                    <td>{{$province->created_at}}</td>
                                </tr>
                                @endforeach
                            </table>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
