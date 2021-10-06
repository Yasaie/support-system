<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
		'name',
	];

}
