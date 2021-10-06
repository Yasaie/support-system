<?php

namespace App\Listeners\EventListener\Auth;

use Illuminate\Auth\Events\Attempting as AttemptingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Attempting
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
     * @param  AttemptingEvent  $event
     * @return void
     */
    public function handle(AttemptingEvent $event)
    {
        //
    }
}
