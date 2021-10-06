<?php

namespace App\Mail\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ManagersCreate extends Mailable
{
    use Queueable, SerializesModels;

	public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
		$this->url=route('ticket.show',$ticket);
    }

    /**
     * Build the message.
     *
	 * @return ManagersCreate
	 */
    public function build()
    {
        return $this->view('notifications.ticket.managersCreateEmail')->with('url',$this->url);
    }
}
