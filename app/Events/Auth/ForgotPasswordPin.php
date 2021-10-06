<?php

namespace App\Events\Auth;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ForgotPasswordPin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $user;
	public $pin;
	/**
     * Create a new event instance.
	 *
	 * @param User $user
	 */
    public function __construct(User $user,$pin)
    {
        $this->user=$user;
        $this->pin=$pin;
    }
}
