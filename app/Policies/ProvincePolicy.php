<?php

namespace App\Policies;

use App\User;
use App\Province;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincePolicy
{
    use HandlesAuthorization;

	public function index(User $user){
		if($user->hasPermission('province')){
			return true;
		}
    	// The user with Owner or Admin permission
        return ($user->owner() || $user->admin());
	}

    /**
     * Determine whether the user can view the province.
     *
     * @param  \App\User  $user
     * @param  \App\Province  $province
     * @return mixed
     */
    public function view(User $user, Province $province)
    {
		if($user->hasPermission('province')){
			return true;
		}
    	// The user with Owner or Admin permission
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can create provinces.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('province')){
			return true;
		}
    	// The user with Owner or Admin permission
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can update the province.
     *
     * @param  \App\User  $user
     * @param  \App\Province  $province
     * @return mixed
     */
    public function update(User $user, Province $province)
    {
		if($user->hasPermission('province')){
			return true;
		}
    	// The user with Owner or Admin permission
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can delete the province.
     *
     * @param  \App\User  $user
     * @param  \App\Province  $province
     * @return mixed
     */
    public function delete(User $user, Province $province)
    {
		if($user->hasPermission('province')){
			return true;
		}
    	// The user with Owner or Admin permission
        return ($user->owner() || $user->admin());
    }
}
