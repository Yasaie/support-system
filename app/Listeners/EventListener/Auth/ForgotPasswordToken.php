<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\ForgotPasswordToken as ForgotPasswordTokenEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPasswordToken
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
     * @param  ForgotPasswordTokenEvent  $event
     * @return void
     */
    public function handle(ForgotPasswordTokenEvent $event)
    {
    	$event->user->sendPasswordResetTokenNotification($event->token);
    }
}
