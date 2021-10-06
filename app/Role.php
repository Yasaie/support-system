<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table="roles";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'permission_id',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'permission_id' => 'integer',
    ];

	/**
	 * return permissions of the current role.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions(){
		return $this->belongsToMany('App\Permission','roles_permissions');
	}

	/**
	 * return users that use this role.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users(){
		return $this->belongsToMany('App\User','users_roles');
	}

}
