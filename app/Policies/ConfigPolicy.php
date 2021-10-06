<?php

namespace App\Policies;

use App\User;
use App\Config;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigPolicy
{
    use HandlesAuthorization;

	/**
	 * Determine where users can handle general configs
	 *
	 * @param User $user
	 * @return bool
	 */
	public function general(User $user){
		if($user->hasPermission('config.general')){
			return true;
		}
    	// The user with Owner permission can create new configs
        return ($user->owner());
	}

	/**
	 * Determine where users can handle email configs
	 *
	 * @param User $user
	 * @return bool
	 */
	public function email(User $user){
		if($user->hasPermission('config.email')){
			return true;
		}
    	// The user with Owner permission can create new configs
        return ($user->owner());
	}

	/**
	 * Determine where users can handle ticket configs
	 *
	 * @param User $user
	 * @return bool
	 */
	public function ticket(User $user){
		if($user->hasPermission('config.ticket')){
			return true;
		}
    	// The user with Owner permission can create new configs
        return ($user->owner());
	}

	/**
	 * Determine where users can handle sms configs
	 *
	 * @param User $user
	 * @return bool
	 */
	public function sms(User $user){
		if($user->hasPermission('config.sms')){
			return true;
		}
    	// The user with Owner permission can create new configs
        return ($user->owner());
	}

	/**
	 * Determine where users can handle template configs
	 *
	 * @param User $user
	 * @return bool
	 */
	public function template(User $user){
		if($user->hasPermission('config.template')){
			return true;
		}
    	// The user with Owner permission can create new configs
        return ($user->owner());
	}
}
