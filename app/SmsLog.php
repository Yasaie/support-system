<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SmsLog extends Model
{
    protected $table="sms_logs";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'subject',
    	'content',
    	'to',
    	'status',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'status' => 'integer',
    ];

	/**
	 * encrypt content
	 *
	 * @param $content
	 */
	public function setContentAttribute($content){
		$this->attributes['content']=Crypt::encryptString($content);
	}

	/**
	 * decrypt content
	 *
	 * @param $content
	 * @return mixed
	 */
	public function getContentAttribute($content){
		return Crypt::decryptString($content);
	}

}
