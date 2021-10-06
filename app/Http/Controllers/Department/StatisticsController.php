<?php
namespace App\Http\Controllers\Department;

use App\Department;
use App\User;
use Illuminate\Support\Facades\Auth;

class StatisticsController {

	/**
	 * count all departments
	 *
	 * @return int
	 */
	public static function countAll(){
    	if(Auth::user()->owner() || Auth::user()->admin()){
			return Department::count();
		}elseif(Auth::user()->leader()){
			return Auth::user()
					   ->leaderInDepartments()
					   ->count();
		}
	}

	public static function staffCount(){
    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//see all of staffs and leaders
			return User::has('departments')->count();
		}elseif(Auth::user()->leader()){
			//leader can see the staff's of his departments that is leader of them.
			return User::whereHas('staffInDepartments',function($query){
							  $departments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
							  $query->whereIn('departments_users.department_id',$departments);
						  })->count();
		}
	}
}