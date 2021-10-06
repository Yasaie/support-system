@extends('layouts.app')

@section('title',' - ویرایش تیکت')
@section('description','ویرایش تیکت')
@section('keywords','ویرایش تیکت')

@section('headImports')
    <link rel="stylesheet" href="{{ asset('plugins/select2-4.0.6-rc.1/dist/css/select2.min.css') }}">
    <script src="{{ asset('plugins/select2-4.0.6-rc.1/dist/js/select2.full.min.js') }}"></script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">ویرایش تیکت</div>

                <div class="panel-body">
                    @include('partial.flashMessage')
                    <form class="form-horizontal" method="POST" action="{{ route('ticket.update',$ticket) }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        @if($ticket->isRoot())
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">subject</label>

                                <div class="col-md-6">
                                    <input id="subject" placeholder="subject" type="text" class="form-control" name="subject" value="{{ $ticket->subject or old('subject') }}">

                                    @if ($errors->has('subject'))
                                        <span class="help-block">
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

                            <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                                <label for="department" class="col-md-4 control-label">department</label>

                                <div class="col-md-6">
                                    <select id="department" class="form-control" name="department">
                                        <option value="">unknown</option>
                                        @unless($departments->isEmpty())
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $ticket->department_id==$department->id ?' selected ':'' }}>{{ $department->name }}</option>
                                            @endforeach
                                        @endunless
                                    </select>

                                    @if ($errors->has('department'))
                                        <span class="help-block">
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
                            <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                                <label for="priority" class="col-md-4 control-label">priorities</label>

                                <div class="col-md-6">
                                    <select id="priority" class="form-control" name="priority">
                                        @foreach($priorities as $priorityId=>$priorityName)
                                            <option value="{{ $priorityId }}" {{ $ticket->priority==$priorityId ?' selected ':'' }}>{{ $priorityName }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('priority'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('priority') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                <label for="content" class="col-md-4 control-label">ticket</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="content" placeholder="ticket" id="content" cols="30" rows="10">{!! $ticket->content or old('content') !!}</textarea>

                                    @if ($errors->has('content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="form-group{{ $errors->has('reply') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">reply</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="reply" placeholder="ticket" id="reply" cols="30" rows="10">{!! $ticket->content or old('content') !!}</textarea>

                                    @if ($errors->has('reply'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('reply') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
