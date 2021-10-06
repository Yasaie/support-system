<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <span class="float-right m-l-5">پیام سیستم : </span>
            @inject('ticketStatisticsController','App\Http\Controllers\Ticket\StatisticsController')
            @inject('notificationDataController','App\Http\Controllers\Notification\DataController')
            @php
                $newNotifications=$notificationDataController::newNotifications();
                $isSystemMessageExists=false;
            @endphp
            <ol class="breadcrumb float-right" id="news">
                @if($newNotifications->count())
                    <li>
                        <p class="d-inline-block m-0 text-info m-r-5">شما {{ $newNotifications->count() }} اعلان جدید دارید</p>
                    </li>
                    @php
                        $isSystemMessageExists=true;
                    @endphp
                @endif
                @if($ticketStatisticsController::todayCountNotReaded())
                    <li>
                        <p class="d-inline-block m-0 text-info m-r-5">{{ $ticketStatisticsController::todayCountNotReaded() }} تیکت جدید ثبت شد</p>
                    </li>
                    @php
                        $isSystemMessageExists=true;
                    @endphp
                @endif
                @if($ticketStatisticsController::todayCountClosed())
                    <li>
                        <p class="d-inline-block m-0 text-info m-r-5">{{ $ticketStatisticsController::todayCountClosed() }} تیکت بسته شد</p>
                    </li>
                    @php
                        $isSystemMessageExists=true;
                    @endphp
                @endif
                @if($ticketStatisticsController::todayCountReplied())
                    <li>
                        <p class="d-inline-block m-0 text-info m-r-5">{{ $ticketStatisticsController::todayCountReplied() }} تیکت پاسخ داده شد</p>
                    </li>
                    @php
                        $isSystemMessageExists=true;
                    @endphp
                @endif
                @unless($isSystemMessageExists)
                    <li>
                        <p class="d-inline-block m-0 text-info m-r-5">تبریک میگم! امروز تا زمان کنونی اطلاعیه ای ندارید.</p>
                    </li>
                @endunless
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>