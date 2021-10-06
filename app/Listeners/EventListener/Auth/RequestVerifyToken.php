<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\RequestVerifyToken as RequestVerifyTokenEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestVerifyToken
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
     * @param  RequestVerifyTokenEvent  $event
     * @return void
     */
    public function handle(RequestVerifyTokenEvent $event)
    {
		$event->user->sendTokenNotification();
    }
}
