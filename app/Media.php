<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
	protected $table='medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'size',
        'extension',
        'mime',
        'real_name',
        'upload_path',
        'user_id',
        'complete_at',
        'resume_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['complete_at','resume_at'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'user_id' => 'integer',
        'complete_at' => 'datetime',
        'resume_at' => 'datetime',
    ];

    /**
     * Determine if a media has been completed.
     *
     * @return bool
     */
	public function completed(){
		return $this->complete_at!==null;
	}

    /**
     * Determine if a media has not been completed.
     *
     * @return bool
     */
	public function uncompleted(){
		return $this->complete_at===null;
	}

    /**
     * Mark the media as completed.
     *
     * @return void
     */
	public function markAsCompleted(){
		$this->forceFill(['complete_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the media as Uncompleted.
     *
     * @return void
     */
	public function markAsUncompleted(){
		$this->forceFill(['complete_at' => null])->save();
		return $this;
	}

    /**
     * Determine if a media has been resumed.
     *
     * @return bool
     */
	public function resumed(){
		return $this->resume_at!==null ;
	}

    /**
     * Determine if a media has not been resumed.
     *
     * @return bool
     */
	public function unresumed(){
		return $this->resume_at===null ;
	}

    /**
     * Mark the media as resumed.
     *
     * @return void
     */
	public function markAsResumed(){
		$this->forceFill(['resume_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the media as UnResumed.
     *
     * @return void
     */
	public function markAsUnresumed(){
		$this->forceFill(['resume_at' => null])->save();
		return $this;
	}

	public function user(){
		return $this->belongsTo('App\User','id','user_id');
	}

	public function getPathAttribute(){
		return str_replace(array('/','\\','\\\\'),DIRECTORY_SEPARATOR,$this->upload_path);
	}

}

