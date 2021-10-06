<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table='views';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip',
        'referrer',
        'url',
        'agent',
        'browser',
        'os',
        'continent',
        'country',
        'country_shortname',
        'city',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'user_id' => 'integer',
	    'latitude' => 'float',
	    'longitude' => 'float',
    ];

}
