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

class ResetPasswordToken
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $user;
	public $password;
	/**
     * Create a new event instance.
	 *
	 * @param User $user
	 */
    public function __construct(User $user,$password)
    {
        $this->user=$user;
        $this->password=$password;
    }
}
