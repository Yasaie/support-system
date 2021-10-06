<?php

namespace App\Listeners\EventListener\Auth;

use Illuminate\Auth\Events\Logout as LogoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Logout
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
     * @param  LogoutEvent  $event
     * @return void
     */
    public function handle(LogoutEvent $event)
    {
        //
    }
}
