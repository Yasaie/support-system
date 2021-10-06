<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsLogPolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
    	// The user with Owner or Admin permission can see faq's archive page
        return ($user->owner() || $user->admin());
	}

}
