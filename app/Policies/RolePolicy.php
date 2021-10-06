<?php

namespace App\Policies;

use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('role')){
			return true;
		}
    	// The user with Owner or Admin permission can see faq's archive page
        return ($user->owner() || $user->admin());
	}

    /**
     * Determine whether the user can create faqs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('role')){
			return true;
		}
		// The user with Owner or Admin permission can see create new
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can update the faq.
     *
	 * @param User $user
	 * @param Role $role
	 * @return bool
	 */
    public function update(User $user, Role $role)
    {
		if($user->hasPermission('role')){
			return true;
		}
		// The user with Owner or Admin permission can update faq
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can delete the faq.
     *
	 * @param User $user
	 * @param Role $role
	 * @return bool
	 */
    public function delete(User $user, Role $role)
    {
		if($user->hasPermission('role')){
			return true;
		}
		// The user with Owner or Admin permission can delete faq
        return ($user->owner() || $user->admin());
    }
}
