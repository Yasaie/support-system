<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class News extends Model
{
	protected $table='news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable=['user_id','title','content','published_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'user_id' => 'integer',
        'published_at' => 'datetime',
    ];

	/**
	 * clean content (html) before saving.
	 *
	 * @param $content
	 */
    public function setContentAttribute($content){
		$this->attributes['content'] = Purifier::clean($content);
    }

    /**
     * Determine if a news has been published.
     *
     * @return bool
     */
	public function published(){
		return $this->published_at!==null;
	}

    /**
     * Determine if a news has not been published.
     *
     * @return bool
     */
	public function unpublished(){
		return $this->published_at===null;
	}

	/**
     * Mark the media as published.
	 *
	 * @return $this
	 */
	public function markAsPublished(){
		$this->forceFill(['published_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the news as Unpublished.
     *
     * @return $this
     */
	public function markAsUnpublished(){
		$this->forceFill(['published_at' => null])->save();
		return $this;
	}

	/**
	 * returns news' related departments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function departments(){
		return $this->belongsToMany('App\Department','news_departments','news_id','department_id')
					->withTimestamps();
	}

	public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}

}
