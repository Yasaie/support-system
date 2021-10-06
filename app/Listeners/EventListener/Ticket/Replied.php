<?php

namespace App\Listeners\EventListener\Ticket;

use App\Events\Ticket\Replied as RepliedEvent;
use App\Notifications\Ticket\ManagersReplyEmail;
use App\Notifications\Ticket\ManagersReplySms;
use App\Notifications\Ticket\ReplyEmail;
use App\Notifications\Ticket\ReplySms;
use App\Ticket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Replied
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
			$ticket->notify(new ManagersReplySms());
		}
		if(config('email.notification.status')){ //mail
			$ticket->notify(new ManagersReplyEmail());
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
			$ticket->notify(new ReplySms());
		}
		if(config('email.notification.status')){ //mail
			$ticket->notify(new ReplyEmail());
		}
		return $this;
    }

    /**
     * Handle the event.
     *
     * @param  RepliedEvent  $event
     * @return void
     */
    public function handle(RepliedEvent $event)
    {
    	$ticket=$event->ticket;
    	$user=$ticket->user;
    	$parentTicket=$ticket->parent;
		//set ticket as replied
		if($user->owner() || $user->admin() || $user->leader() || $user->staff()){
			if($ticket->unreplied()){
				$this->notifyUser($parentTicket);
			}
		}else{
			$this->notifyDepartment($parentTicket);
		}
    }
}
