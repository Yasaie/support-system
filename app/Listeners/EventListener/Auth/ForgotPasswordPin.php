<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\ForgotPasswordPin as ForgotPasswordPinEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPasswordPin
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
     * @param  ForgotPasswordPinEvent  $event
     * @return void
     */
    public function handle(ForgotPasswordPinEvent $event)
    {
    	$event->user->sendPasswordResetPinNotification($event->pin);
    }
}
