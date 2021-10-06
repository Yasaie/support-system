<?php

namespace App\Policies;

use App\User;
use App\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

	/**
	 * Determine where users can view Departments archive
	 *
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		if($user->hasPermission('department')){
			return true;
		}
		// The user with Owner or Admin permission , and department's leaders
    	// and staffs can see list of departments.
        return ($user->owner() || $user->admin() || $user->leader());
	}

    /**
     * Determine whether the user can view the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function view(User $user, Department $department)
    {
		if($user->hasPermission('department')){
			return true;
		}
		$isLeaderOfThisDepartment=$user->leaderInDepartments()->where('department_id','=',$department->id)->first();
    	// The user with Owner or Admin permission or if user is its leader
    	// (leader of the department) can see departments.
        return ($user->owner() || $user->admin() || $isLeaderOfThisDepartment);

    }

    /**
     * Determine whether the user can create departments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
		if($user->hasPermission('department')){
			return true;
		}
    	// The user with Owner or Admin permission can create departments
        return ($user->owner() || $user->admin());
    }

    /**
     * Determine whether the user can update the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function update(User $user, Department $department)
    {
		if($user->hasPermission('department')){
			return true;
		}
		$isLeaderOfThisDepartment=$user->leaderInDepartments()->where('department_id','=',$department->id)->first();
    	// The user with Owner or Admin permission or if user is its leader
    	// (leader of the department) can update departments.
        return ($user->owner() || $user->admin() || $isLeaderOfThisDepartment);
    }

    /**
     * Determine whether the user can delete the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function delete(User $user, Department $department)
    {
		if($user->hasPermission('department')){
			return true;
		}
    	// The user with Owner or Admin permission can delete departments
        return ($user->owner() || $user->admin());
    }
}
