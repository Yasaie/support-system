<?php

namespace App\Policies;

use App\User;
use App\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

	/**
	 * Determine where users can view cities archive
	 *
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('city')){
			return true;
		}
    	// The user with Owner or Admin permission can create new cities
        return ($user->owner() || $user->admin());
	}

    /**
     * Determine whether the user can view the city.
     *
     * @param  \App\User  $user
     * @param  \App\City  $city
     * @return mixed
     */
    public function view(User $user, City $city)
    {
		if($user->hasPermission('city')){
			return true;
		}
    	// The user with Owner or Admin permission can create new cities
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can create cities.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('city')){
			return true;
		}
    	// The user with Owner or Admin permission can create new cities
        return ($user->owner() || $user->admin());
	}

    /**
     * Determine whether the user can update the city.
     *
     * @param  \App\User  $user
     * @param  \App\City  $city
     * @return mixed
     */
    public function update(User $user, City $city)
    {
		if($user->hasPermission('city')){
			return true;
		}
    	// The user with Owner or Admin permission can create new cities
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can delete the city.
     *
     * @param  \App\User  $user
     * @param  \App\City  $city
     * @return mixed
     */
    public function delete(User $user, City $city)
    {
		if($user->hasPermission('city')){
			return true;
		}
    	// The user with Owner or Admin permission can create new cities
        return ($user->owner() || $user->admin());
    }
}
