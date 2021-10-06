<?php

namespace App\Policies;

use App\User;
use App\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('notification')){
			return true;
		}
        if($user->owner() || $user->admin() || $user->leader()){
			return true;
        }
        return false;
	}

	/**
	 * garbage list
	 *
	 * @param User $user
	 * @return bool
	 */
    public function garbage(User $user){
		if($user->owner() || $user->admin()){
			return true;
		}
    }

	/**
	 * remove ticket permanently
	 *
	 * @param User $user
	 * @param Notification $notification
	 * @return bool
	 */
	public function permanentDelete(User $user, Notification $notification){
		if($user->owner() || $user->admin()){
			return true;
		}
	}

	/**
	 * recycle removed users
	 *
	 * @param User $user
	 * @param Notification $notification
	 * @return bool
	 */
	public function recycle(User $user, Notification $notification){
		if($user->owner() || $user->admin()){
			return true;
		}
	}

    /**
     * Determine whether the user can view the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function view(User $user, Notification $notification)
    {
		if($user->hasPermission('notification')){
			return true;
		}
    	if($user->owner() || $user->admin()){
    		//owner and admin can see all notifications
    		return true;
    	}elseif( !empty($notification->creator) && ($user->id===$notification->creator->id) ){
    		//creator of a notification see it.
    		return true;
    	}

    	//notification's recipient can see it:
    	$recipients=$notification->recipients()->pluck('recipient_id')->toArray();
		if(in_array($user->id,$recipients)){
			return true;
		}

    	return false;
    }

    /**
     * Determine whether the user can create notifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('notification')){
			return true;
		}
        if($user->owner() || $user->admin() || $user->leader()){
			return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function update(User $user, Notification $notification)
    {
		if($user->hasPermission('notification')){
			return true;
		}
    	if($user->owner() || $user->admin()){
    		//owner and admin can see all notifications
    		return true;
    	}elseif( !empty($notification->creator) && ($user->id===$notification->creator->id) ){
    		//creator of a notification see it.
    		return true;
    	}
    	return false;
    }

    /**
     * Determine whether the user can delete the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function delete(User $user, Notification $notification)
    {
		if($user->hasPermission('notification')){
			return true;
		}
    	if($user->owner() || $user->admin()){
    		//owner and admin can see all notifications
    		return true;
    	}elseif( !empty($notification->creator) && ($user->id===$notification->creator->id) ){
    		//creator of a notification see it.
    		return true;
    	}
    	return false;
    }

	/**
	 * user's received notifications
	 *
	 * @param User $user
	 * @return bool
	 */
    public function inbox(User $user){
		return true;
    }
}
