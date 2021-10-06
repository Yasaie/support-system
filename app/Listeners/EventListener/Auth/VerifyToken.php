<?php

namespace App\Listeners\EventListener\Auth;

use App\Events\Auth\VerifyToken as VerifyTokenEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyToken
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
     * @param  VerifyTokenEvent  $event
     * @return void
     */
    public function handle(VerifyTokenEvent $event)
    {
        //
    }
}
