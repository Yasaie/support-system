@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">country</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <div class="row">
                        <div class="col-sm-12">

                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>name</th>
                                    <th>short name</th>
                                    <th>creation time</th>
                                </tr>
                                <tr>
                                    <td>{{$country->name or ' not found '}}</td>
                                    <td>{{$country->short_name or ' not found '}}</td>
                                    <td>{{$country->created_at}}</td>
                                </tr>
                            </table>

                            @unless($country->provinces->isEmpty())
                            <p>Provinces:</p>
                            <table class="table table-responsive table-bordered">
                                <tr>
                                    <th>name</th>
                                    <th>creation time</th>
                                </tr>
                                @foreach($country->provinces as $province)
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
