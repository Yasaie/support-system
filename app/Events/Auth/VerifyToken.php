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

class VerifyToken
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $user;

	/**
     * Create a new event instance.
	 *
	 * @param User $user
	 */
    public function __construct(User $user)
    {
        $this->user=$user;
    }
}
