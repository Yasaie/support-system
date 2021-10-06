<?php

namespace App\Events\Log;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Sms
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $subject;
	public $content;
	public $to;
	public $status;

    /**
     * Create a new event instance.
     *
	 * @param $subject
	 * @param $content
	 * @param $to
	 * @param $status
	 */
    public function __construct($subject,$content,$to,$status)
    {
		$this->subject=$subject;
		$this->content=$content;
		$this->to=$to;
		$this->status=$status;
    }
}
