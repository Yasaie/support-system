<?php

namespace App\Listeners\EventListener\Auth;

use Illuminate\Auth\Events\Authenticated as AuthenticatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Authenticated
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
     * @param  AuthenticatedEvent  $event
     * @return void
     */
    public function handle(AuthenticatedEvent $event)
    {
        //
    }
}
