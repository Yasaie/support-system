<?php

namespace App\Policies;

use App\User;
use App\Faq;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('faq')){
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
		if($user->hasPermission('faq')){
			return true;
		}
		// The user with Owner or Admin permission can see create new
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can update the faq.
     *
     * @param  \App\User  $user
     * @param  \App\Faq  $faq
     * @return mixed
     */
    public function update(User $user, Faq $faq)
    {
		if($user->hasPermission('faq')){
			return true;
		}
		// The user with Owner or Admin permission can update faq
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can delete the faq.
     *
     * @param  \App\User  $user
     * @param  \App\Faq  $faq
     * @return mixed
     */
    public function delete(User $user, Faq $faq)
    {
		if($user->hasPermission('faq')){
			return true;
		}
		// The user with Owner or Admin permission can delete faq
        return ($user->owner() || $user->admin());
    }
}
