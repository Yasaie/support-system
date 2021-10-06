<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use softDeletes;

	public $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
		'title',
		'content',
		'excerpt',
		'published_at',
		'author_id',
		'post_id',
		'order',
		'type',
		'cover',
		'slug',
	];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
		'published_at',
		'deleted_at',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'author_id' => 'integer',
	    'post_id' => 'integer',
	    'order' => 'integer',
	    'cover' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * The attributes that should be append to data arrays.
     *
     * @var array
     */
     protected $appends = [];

}
