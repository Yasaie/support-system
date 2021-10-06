<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use softDeletes;

	public $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
		'name',
		'email',
		'comment',
		'comment_id',
		'user_id',
		'published_at',
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
	    'user_id' => 'integer',
	    'comment_id' => 'integer',
        'published_at' => 'datetime',
    ];

}
