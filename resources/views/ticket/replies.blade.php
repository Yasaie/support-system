<!-- Start Row -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            @if( ( ($ticket->user) && ($ticket->root()->user) && ($ticket->user->id!==$ticket->root()->user->id) ) )
            <div class="card-header bg-secondary text-white">
            @elseif( ($ticket->user) && !($ticket->root()->user) )
            <div class="card-header bg-secondary text-white">
            @else
            <div class="card-header">
            @endif
                @if($ticket->user)
                <p class="pull-right m-0">
                    <img width="40" class="rounded-circle single-ticket-user-avatar" src="{{ $ticket->user->avatar_url }}" alt="user avatar">
                    <span>{{ $ticket->user->name }}</span>
                    @if($ticket->user->owner())
                    <span class="text-warning">&nbsp;(مالک)</span>
                    @elseif($ticket->user->admin())
                    <span class="text-warning">&nbsp;(ادمین)</span>
                    @elseif($ticket->user->leader())
                    <span class="text-warning">&nbsp;(سرپرست)</span>
                    @elseif($ticket->user->staff())
                    <span class="text-warning">&nbsp;(پشتیبان)</span>
                    @endif
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
                        @if( ( ($ticket->user) && ($ticket->root()->user) && ($ticket->user->id!==$ticket->root()->user->id) ) )
                        <button type="submit" class="btn btn-danger btn-sm deleteTicket">
                            <i class="fa fa-trash"></i>
                            <span>حذف</span>
                        </button>
                        @elseif( ($ticket->user) && !($ticket->root()->user) )
                        <button type="submit" class="btn btn-danger btn-sm deleteTicket">
                            <i class="fa fa-trash"></i>
                            <span>حذف</span>
                        </button>
                        @else
                        <button type="submit" class="btn btn-outline-danger btn-sm deleteTicket">
                            <i class="fa fa-trash"></i>
                            <span>حذف</span>
                        </button>
                        @endif
                    </form>
                </div>
                @endcan

            </div>
            <div class="card-body">
                {!! $ticket->content !!}
                @if($ticket->attachments->isNotEmpty())
                    <!-- show this section only if ticket has at least 1 file attached -->
                    <p class="single-ticket-file">
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
                @can('rateStore',$ticket)
                    <span dir="ltr" data-id="{{ $ticket->id }}" data-type="tickets" data-rating="{{ $ticket->ratesAverage() }}" style="height: 20px;" class="my-rating float-left"></span>
                @endcan
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

@each('ticket.replies', $ticket->children, 'ticket')