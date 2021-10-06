<?php

namespace App\Policies;

use App\User;
use App\Media;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		return true;
	}

    /**
     * Determine whether the user can view the media.
     *
     * @param  \App\User  $user
     * @param  \App\Media  $media
     * @return mixed
     */
    public function view(User $user, Media $media)
    {
		if($user->hasPermission('media')){
			return true;
		}
        return ( ($user->id===$media->user->id) || $user->owner() || $user->admin() );
    }

    /**
     * Determine whether the user can create media.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the media.
     *
     * @param  \App\User  $user
     * @param  \App\Media  $media
     * @return mixed
     */
    public function update(User $user, Media $media)
    {
		if($user->hasPermission('media')){
			return true;
		}
        return ( ($user->id===$media->user->id) || $user->owner() || $user->admin() );
    }

    /**
     * Determine whether the user can delete the media.
     *
     * @param  \App\User  $user
     * @param  \App\Media  $media
     * @return mixed
     */
    public function delete(User $user, Media $media)
    {
		if($user->hasPermission('media')){
			return true;
		}
        return ( ($user->id===$media->user->id) || $user->owner() || $user->admin() );
    }
}
