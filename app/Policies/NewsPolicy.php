<?php

namespace App\Policies;

use App\User;
use App\News;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('news')){
			return true;
		}
        return ($user->owner() || $user->admin() || $user->leader());
	}

    /**
     * Determine whether the user can create news.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('news')){
			return true;
		}
        return ($user->owner() || $user->admin() || $user->leader());
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param  \App\User  $user
     * @param  \App\News  $news
     * @return mixed
     */
    public function update(User $user, News $news)
    {
		if($user->hasPermission('news')){
			return true;
		}
    	if($user->owner() || $user->admin()){
    		return true;
    	}elseif($user->leader() && ($user->id===$news->user->id)){
    		//leader of a department can only update his/her news
    		return true;
    	}
    	return false;
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param  \App\User  $user
     * @param  \App\News  $news
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
		if($user->hasPermission('news')){
			return true;
		}
    	if($user->owner() || $user->admin()){
    		return true;
    	}elseif($user->leader() && ($user->id===$news->user->id)){
    		//leader of a department can only delete his/her news
    		return true;
    	}
    	return false;
    }
}
