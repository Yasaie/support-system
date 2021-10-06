<?php

namespace App\Listeners\EventListener\Auth;

use Illuminate\Auth\Events\Lockout as LockoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Lockout
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
     * @param  LockoutEvent  $event
     * @return void
     */
    public function handle(LockoutEvent $event)
    {
    	//$event->request
        //$event->request->ip()
    }
}
