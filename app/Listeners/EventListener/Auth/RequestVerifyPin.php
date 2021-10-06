<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\RequestVerifyPin as RequestVerifyPinEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestVerifyPin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RequestVerifyPinEvent  $event
     * @return void
     */
    public function handle(RequestVerifyPinEvent $event)
    {
        $event->user->sendPinNotification();
    }
}
