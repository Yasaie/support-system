<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
	public $table = 'posts_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
		'name',
		'value',
		'post_id',
	];
}
