<?php

namespace App\Mail\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Reply extends Mailable
{
    use Queueable, SerializesModels;

	public $url;

    /**
     * Create a new message instance.
     *
	 * @param $ticket
	 */
    public function __construct($ticket)
    {
		$this->url=route('ticket.show',$ticket);
    }

    /**
     * Build the message.
     *
	 * @return Reply
	 */
    public function build()
    {
        return $this->view('notifications.ticket.replyEmail')->with('url',$this->url);
    }
}
