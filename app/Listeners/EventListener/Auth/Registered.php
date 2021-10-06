<?php

namespace App\Listeners\EventListener\Auth;

use Illuminate\Auth\Events\Registered as RegisteredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registered
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
     * @param  RegisteredEvent  $event
     * @return void
     */
    public function handle(RegisteredEvent $event)
    {
    	$user=$event->user;
		//send an sms to verify mobile number
		if($user->mobile && $user->mobileUnverified()){
			$user->sendPinNotification();
		}

		//send as Email to verify E-mail address
		if($user->email && $user->emailUnverified()){
			$user->sendTokenNotification();
		}
    }
}
