<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\ResetPasswordToken as ResetPasswordTokenEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordToken
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
	 * @param ResetPasswordTokenEvent $event
	 */
    public function handle(ResetPasswordTokenEvent $event)
    {
        //
    }
}
