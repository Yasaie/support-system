<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\ResetPasswordPin as ResetPasswordPinEvent;
use App\Notifications\System;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordPin
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
     * @param  ResetPasswordPinEvent  $event
     * @return void
     */
    public function handle(ResetPasswordPinEvent $event)
    {
    	$event->user->notify(new System(trans('passwords.recovery'),trans('passwords.change')));
    }
}
