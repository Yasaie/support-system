<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
	protected $table='users_meta';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'gender',
        'country_id',
        'province_id',
        'city_id',
        'biography',
        'avatar',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'country_id' => 'integer',
	    'province_id' => 'integer',
	    'city_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(){
    	return $this->belongsTo('App\User','id','user_id');
    }

    public function country(){
		return $this->belongsTo('App\Country','country_id');
    }

    public function province(){
		return $this->belongsTo('App\Province','province_id');
    }

    public function city(){
		return $this->belongsTo('App\City','city_id');
    }

}
