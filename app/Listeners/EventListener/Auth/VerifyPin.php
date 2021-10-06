<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\VerifyPin as VerifyPinEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyPin
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
     * @param  VerifyPinEvent  $event
     * @return void
     */
    public function handle(VerifyPinEvent $event)
    {
        //
    }
}
