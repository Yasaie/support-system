<?php

namespace App\Policies;

use App\User;
use App\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

	/**
	 * Determine where users can view countries archive
	 *
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('country')){
			return true;
		}
    	// The user with Owner or Admin permission can see countries
        return ($user->owner() || $user->admin());
	}

    /**
     * Determine whether the user can view the country.
     *
     * @param  \App\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function view(User $user, Country $country)
    {
		if($user->hasPermission('country')){
			return true;
		}
    	// The user with Owner or Admin permission can view country
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can create countries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('country')){
			return true;
		}
    	// The user with Owner or Admin permission can create new country
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can update the country.
     *
     * @param  \App\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function update(User $user, Country $country)
    {
		if($user->hasPermission('country')){
			return true;
		}
    	// The user with Owner or Admin permission can update country
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can delete the country.
     *
     * @param  \App\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function delete(User $user, Country $country)
    {
		if($user->hasPermission('country')){
			return true;
		}
    	// The user with Owner or Admin permission can remove country
        return ($user->owner() || $user->admin());
    }
}
