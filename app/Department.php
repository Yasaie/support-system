<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

	protected $table='departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable=['name','hidden_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['hidden_at'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hidden_at' => 'datetime',
    ];

    /**
     * Determine if a department is hidden.
     *
     * @return bool
     */
	public function hidden(){
		return $this->hidden_at!==null;
	}

    /**
     * Determine if a department is visible.
     *
     * @return bool
     */
	public function visible(){
		return $this->hidden_at===null;
	}

	/**
     * Mark the department as hidden.
	 *
	 * @return $this
	 */
	public function markAsHidden(){
		$this->forceFill(['hidden_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the department as visible.
     *
     * @return $this
     */
	public function markAsVisible(){
		$this->forceFill(['hidden_at' => null])->save();
		return $this;
	}

	/**
	 * Department leaders and staffs
	 */
	public function users(){
		return $this->belongsToMany('App\User','departments_users','department_id','user_id')
	 		 		->withTimestamps()
	 		 		->withPivot('is_leader');
	}

	/**
	 * Department leaders
	 */
	public function leaders(){
		return $this->belongsToMany('App\User','departments_users','department_id','user_id')
					->wherePivot('is_leader','=',true)
	 		 		->withTimestamps()
	 		 		->withPivot('is_leader');
	}

	/**
	 * Department staff
	 */
	public function staffs(){
		return $this->belongsToMany('App\User','departments_users','department_id','user_id')
					->wherePivot('is_leader','=',false)
	 		 		->withTimestamps()
	 		 		->withPivot('is_leader');
	}

	/**
	 * Department's tickets.
	 */
	public function tickets(){
		return $this->hasMany('App\Ticket','department_id');
	}
}
