<div class="wrapper">
    <div class="container-fluid">
        <!-- Start Row -->
        <div class="row m-t-20">
            <div class="col-12">
                @include('partial.flashMessage')
                <div class="portlet">
                    <div class="portlet-heading mb-2">
                        <a class="text-white" href="#ticket-{{ $ticket->id }}">
                            <span class="single-ticket-id hidden-sm">{{ $ticket->id }}</span>
                        </a>
                        <h3 class="pull-right m-0">
                            <span class="single-ticket-title text-inverse ">{{ $ticket->subject }}</span>
                            @if($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_LOW)
                                <span class="text-inverse m-t-10 font-sm">(کم اهمیت)</span>
                            @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_MEDIUM)
                                <span class="text-info m-t-10 font-sm hidden">(عادی)</span>
                            @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_HIGH)
                                <span class="text-warning m-t-10 font-sm">(مهم)</span>
                            @elseif($ticket->priority==\App\Http\Controllers\Ticket\TicketPriority::PRIORITY_EMERGENCY)
                                <span class="text-danger m-t-10 font-sm">(ضروری)</span>
                            @endif
                        </h3>

                        @unless($ticket->closed())
                            <div class="pull-left m-t-15">
                                <a href="{{ route('ticket.guest.close',['access_key'=>$ticket->access_key]) }}" class="btn btn-success btn-sm waves-effect waves-light m-r-5 m-b-10 btn-xs-block closeTicket text-white">
                                    <i class="fa fa-check"></i>
                                    <span>پاسخ را دریافت کردم تیکت را ببند</span>
                                </a>
                            </div>
                        @endunless
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body text-muted clearfix">
                        <div class="row">
                            <div class="col-12 mb-2 text-justify" style="line-height: 2rem">
                                <span>ایجاد شده در تاریخ : </span>
                                <span class="text-primary">{{ Date::make($ticket->created_at)->toJalali()->format('H:i - Y/m/d') }}</span>
                                <span>برای دپارتمان : </span>
                                <span class="text-primary">{{ $ticket->department->name }}</span>
                                <span>آخرین وضعیت تیکت : </span>
                                @if($ticket->closed())
                                    <span class="text-danger">بسته شده</span>
                                @elseif($ticket->referral())
                                    <span class="text-dark">ارجاع داده شده</span>
                                @elseif($ticket->resolved())
                                    <span class="text-success">برطرف شده</span>
                                @elseif($ticket->replied())
                                    <span class="text-primary">پاسخ داده شده</span>
                                @elseif($ticket->unreaded())
                                    <span class="text-warning">خوانده نشده</span>
                                @elseif($ticket->readed())
                                    <span class="text-info">در انتظار بررسی</span>
                                @endif
                                <span>کد رهگیری تیکت:</span>
                                <span class="text-danger">{{ $ticket->access_key }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

        <!-- Start Row -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if($ticket->user)
                        <p class="pull-right m-0">
                            <img width="40" class="rounded-circle single-ticket-user-avatar" src="{{ $ticket->user->avatar_url }}" alt="user avatar">
                            <span>{{ $ticket->user->name }}</span>
                        </p>
                        @else
                        <p class="pull-right m-0">
                            <img width="40" class="rounded-circle single-ticket-user-avatar" src="{{ asset('images/male_avatar.png') }}" alt="user avatar">
                            <span>کاربر مهمان</span>
                        </p>
                        @endif
                        @can('delete',$ticket)
                        <div class="pull-left">
                            <form action="{{ route('ticket.destroy',$ticket) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-outline-danger btn-sm deleteTicket">
                                    <i class="fa fa-trash"></i>
                                    <span>حذف</span>
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        {!! $ticket->content !!}
                        @if($ticket->attachments->isNotEmpty())
                            <!-- show this section only if ticket has at least 1 file attached -->
                            <p class="m-0 single-ticket-file">
                                @foreach($ticket->attachments as $attachment)
                                    <a  data-toggle="tooltip" title="" data-original-title="{{ $attachment->name.'.'.$attachment->extension }}" href="{{ route('media.attachment',$attachment) }}">
                                        <i class="ti-zip align-middle"></i>
                                        <span>پیوست شماره</span>
                                        <span>{{ $loop->index+1 }}</span>
                                    </a>
                                @endforeach
                            </p>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        <i class="fa fa-clock-o"></i> {{ Date::make($ticket->created_at)->toJalali()->format('H:i - Y/m/d') }} &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

        @each('ticket.replies', $ticket->children, 'ticket')

        <div class="row">
            <div class="col-12">
                <div class="portlet">
                    <div class="portlet-heading portlet-default mb-2">
                        <h3 class="pull-right portlet-title text-dark">ارسال پاسخ</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body clearfix" id="addReply">
                        <form class="form-horizontal" method="POST" action="{{ route('ticket.guest.reply',['access_key'=>$ticket->access_key]) }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group{{ $errors->has('reply') ? ' has-error' : '' }}">
                                        <textarea class="form-control" name="reply" placeholder="پاسخ خود را وارد کنید..." id="reply" cols="30" rows="10">{{ old('reply') }}</textarea>
                                        @if ($errors->has('reply'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('reply') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="attachments"></div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-success w-lg btn-custom btm-sm waves-effect waves-light btn-xs-block pull-left" type="submit">
                                            <i class="fa fa-check"></i>
                                            <span>ارسال پاسخ</span>
                                        </button>
                                    </div>
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
    </div><!-- end container -->
</div>
