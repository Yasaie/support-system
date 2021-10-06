<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Facades\Purifier;

class Notification extends Model
{
	use softDeletes;

	protected $table='notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator_id',
        'subject',
        'message',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'creator_id' => 'integer',
    ];

	/**
	 * clean message before saving.
	 *
	 * @param $message
	 */
    public function setMessageAttribute($message){
		$this->attributes['message'] = Purifier::clean($message);
    }

	/**
	 * Creator of this notification
	 *
	 * @return mixed
	 */
	public function creator(){
		return $this->belongsTo('App\User','creator_id','id')->withTrashed();
	}

	/**
	 * The recipients that should see this notification.
	 *
	 * @return mixed
	 */
	public function recipients(){
		return $this->belongsToMany('App\User','notification_recipient','notification_id','recipient_id')
					->withTrashed()
	 		 		->withTimestamps()
	 		 		->withPivot('read_at');
	}
}
