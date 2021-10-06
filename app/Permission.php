<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

	public function getNameAttribute($name){
		return trans('permission.'.$name);
	}

	/**
	 * return roles that have this permission
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function Roles(){
		return $this->belongsToMany('App\Permission','roles_permissions','role_id','permission_id');
	}
}
