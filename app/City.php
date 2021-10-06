<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	protected $table='cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable=['province_id','name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'province_id' => 'integer',
    ];

	public function province(){
		return $this->belongsTo('App\Province','province_id','id');
	}
}
