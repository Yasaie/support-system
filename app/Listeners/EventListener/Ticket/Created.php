<?php

namespace App\Listeners\EventListener\Ticket;

use App\Events\Ticket\Created as CreatedEvent;
use App\Notifications\Ticket\CreateEmail;
use App\Notifications\Ticket\CreateSms;
use App\Notifications\Ticket\ManagersCreateEmail;
use App\Notifications\Ticket\ManagersCreateSms;
use App\Ticket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Created
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
	 * notify ticket department's users
	 *
	 * @param Ticket $ticket
	 * @return $this
	 */
    private function notifyDepartment(Ticket $ticket){
		if(config('sms.notification.status')){ //sms
			$ticket->notify(new ManagersCreateSms());
		}
		if(config('email.notification.status')){ //mail
			$ticket->notify(new ManagersCreateEmail());
		}
		return $this;
    }

	/**
	 * notify ticket's user
	 *
	 * @param Ticket $ticket
	 * @return $this
	 */
    private function notifyUser(Ticket $ticket){
		if(config('sms.notification.status')){ //sms
			$ticket->notify(new CreateSms());
		}
		if(config('email.notification.status')){ //mail
			$ticket->notify(new CreateEmail());
		}
		return $this;
    }

    /**
     * Handle the event.
     *
     * @param  CreatedEvent  $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    {
		$ticket=$event->ticket;
		$this->notifyUser($ticket)
			 ->notifyDepartment($ticket);
    }
}
