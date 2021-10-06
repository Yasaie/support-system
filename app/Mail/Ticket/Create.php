<?php

namespace App\Mail\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Create extends Mailable
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
	 * @return Create
	 */
    public function build()
    {
        return $this->view('notifications.ticket.createEmail')->with('url',$this->url);
    }
}
