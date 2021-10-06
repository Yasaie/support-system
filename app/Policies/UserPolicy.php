<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

	public function getList(User $user){
		if($user->hasPermission('user')){
			return true;
		}
		return ($user->owner() || $user->admin() || $user->leader() || $user->staff());
	}

	public function index(User $user){
		if($user->hasPermission('user')){
			return true;
		}
        return ($user->owner() || $user->admin());
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
	 * @param User $targetUser
	 * @return bool
	 */
	public function permanentDelete(User $user, User $targetUser){
		if($user->owner() || $user->admin()){
			return true;
		}
	}

	/**
	 * recycle removed users
	 *
	 * @param User $user
	 * @param User $targetUser
	 * @return bool
	 */
	public function recycle(User $user,User $targetUser){
		if($user->owner() || $user->admin()){
			return true;
		}
	}

    /**
     * Determine whether the user can view the user.
     *
	 * @param User $user
	 * @param User $targetUser
	 * @return bool
	 */
    public function view(User $user, User $targetUser)
    {
    	return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('user')){
			return true;
		}
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can update the user.
	 *
	 * @param User $user
	 * @param User $targetUser
	 * @return bool
	 */
    public function update(User $user, User $targetUser)
    {
		if($user->hasPermission('user')){
			return true;
		}
    	if($user->owner()){ //owner cant edit another owner
			if($user->id===$targetUser->id || !($targetUser->owner())){
				return true;
			}
    	}elseif($user->admin()){ //admin cant edit another, owner or admin
			if($user->id===$targetUser->id || !($targetUser->owner() || $targetUser->admin())){
				return true;
			}
    	}elseif($user->id===$targetUser->id){
    		return true;
    	}

    	return false;
    }

    /**
     * Determine whether the user can delete the user.
     *
	 * @param User $user
	 * @param User $targetUser
	 * @return bool
	 */
    public function delete(User $user, User $targetUser)
    {
		if($user->hasPermission('user')){
			return true;
		}
    	if($user->owner()){ //owner cant delete another owner
			if($user->id!==$targetUser->id && !($targetUser->owner())){
				return true;
			}
    	}elseif($user->admin()){ //admin cant delete another, owner or admin
			if($user->id!==$targetUser->id && !($targetUser->owner() || $targetUser->admin())){
				return true;
			}
    	}
    	return false;
    }

    /**
	 * Each department has some leaders and staffs.
	 * Department's leader can handle the staffs and their information.
	 */

	/**
	 * show staffs
	 *
	 * @param User $user
	 * @return bool
	 */
	 public function staffIndex(User $user){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
    	/* The user with Owner or Admin permission and department's leader can
    	 * see staffs and leaders archive.
    	 */
        return ($user->owner() || $user->admin() || $user->leader());
	 }

	/**
	 * garbage list
	 *
	 * @param User $user
	 * @return bool
	 */
    public function staffGarbage(User $user){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
    	/* The user with Owner or Admin permission and department's leader can
    	 * see staffs and leaders archive.
    	 */
        return ($user->owner() || $user->admin() || $user->leader());
    }

	/**
	 * remove ticket permanently
	 *
	 * @param User $user
	 * @param User $staff
	 * @return bool
	 */
	public function staffPermanentDelete(User $user, User $staff){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
		//owner and admin can remove department staff: (leaders and managers can be deleted)
		$hasDepartments=$staff->departments()->count();
		if($hasDepartments<=0){
			return false;
		}

    	if($user->owner()){ //owner cant delete another owner
			if($user->id!==$staff->id && !($staff->owner())){
				return true;
			}
    	}elseif($user->admin()){ //admin cant delete another, owner or admin
			if($user->id!==$staff->id && !($staff->owner() || $staff->admin())){
				return true;
			}
    	}
	}

	/**
	 * recycle removed users
	 *
	 * @param User $user
	 * @param User $staff
	 * @return bool
	 */
	public function staffRecycle(User $user, User $staff){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
		//owner and admin can remove department staff: (leaders and managers can be deleted)
		$hasDepartments=$staff->departments()->count();
		if($hasDepartments<=0){
			return false;
		}

    	if($user->owner()){ //owner cant delete another owner
			if($user->id!==$staff->id && !($staff->owner())){
				return true;
			}
    	}elseif($user->admin()){ //admin cant delete another, owner or admin
			if($user->id!==$staff->id && !($staff->owner() || $staff->admin())){
				return true;
			}
    	}
	}

	/**
	 * view a department's staff
	 *
	 * @param User $user
	 * @param User $staff
	 * @return bool
	 */
	 public function staffView(User $user, User $staff){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
	 	//leader's departments:
		$leaderInDepartments=$user->leaderInDepartments()->pluck('department_id')->toArray();
		$staffInDepartments=$staff->staffInDepartments()->pluck('department_id')->toArray();

		$hasIntersect=array_intersect($leaderInDepartments,$staffInDepartments);

    	// The user with Owner or Admin permission can view staffs
        return ($user->owner() || $user->admin() || !empty($hasIntersect));
	 }

	/**
	 * Add new staff to department
	 *
	 * @param User $user
	 * @return bool
	 */
	 public function staffCreate(User $user){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
    	// The user with Owner or Admin permission can view staffs
        return ($user->owner() || $user->admin() || $user->leader());
	 }

	/**
	 * update department staffs
	 *
	 * @param User $user
	 * @param User $staff
	 * @return bool
	 */
	 public function staffUpdate(User $user, User $staff){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
	 	//cant add an owner or admin as department staff
		if($user->owner()){ //owner cant edit another owner
			if(!($staff->owner())){
				return true;
			}
    	}elseif($user->admin()){ //admin cant edit another, owner or admin
			if(!$user->owner() || !$staff->admin()){
				return true;
			}
    	}

	 	//leader's departments:
		$leaderInDepartments=$user->leaderInDepartments()->pluck('department_id')->toArray();
		$staffInDepartments=$staff->staffInDepartments()->pluck('department_id')->toArray();

		$hasIntersect=array_intersect($leaderInDepartments,$staffInDepartments);

    	// The user with Owner or Admin permission can view staffs
        return ($user->owner() || $user->admin() || !empty($hasIntersect));
	 }

	/**
	 * delete department's staff
	 *
	 * @param User $user
	 * @param User $staff
	 * @return bool
	 */
	 public function staffDelete(User $user, User $staff){
		if($user->hasPermission('user') && $user->hasPermission('department')){
			return true;
		}
		//owner and admin can remove department staff: (leaders and managers can be deleted)
		$hasDepartments=$staff->departments()->count();
		if($hasDepartments<=0){
			return false;
		}

    	if($user->owner()){ //owner cant delete another owner
			if($user->id!==$staff->id && !($staff->owner())){
				return true;
			}
    	}elseif($user->admin()){ //admin cant delete another, owner or admin
			if($user->id!==$staff->id && !($staff->owner() || $staff->admin())){
				return true;
			}
    	}

		return false;
	 }
}
