<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
	protected $table='provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable=['country_id','name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'country_id' => 'integer',
    ];

	public function country(){
		return $this->belongsTo('App\Country','country_id','id');
	}

	public function cities(){
		return $this->hasMany('App\City','province_id','id');
	}

}
