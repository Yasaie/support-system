<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
	public $table = 'rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
		'rate',
		'rateable_id',
		'rateable_type',
		'user_id',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'rate' => 'integer',
	    'rateable_id' => 'integer',
	    'user_id' => 'integer',
    ];

	public function user(){
		return $this->hasOne('App\User','user_id');
	}

	public function rateable(){
		return $this->morphTo();
	}
}
