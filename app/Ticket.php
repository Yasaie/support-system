<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Ticket\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Mews\Purifier\Facades\Purifier;

class Ticket extends Model
{
	use softDeletes;
    use Notifiable;

	protected $table='tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ticket_id',
        'subject',
        'department_id',
        'status',
        'priority',
        'content',
        'read_at',
        'replied_at',
        'access_key',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['read_at','replied_at','deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'user_id' => 'integer',
	    'ticket_id' => 'integer',
	    'department_id' => 'integer',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
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
     * Determine if a ticket has been readed.
     *
     * @return bool
     */
	public function readed(){
		return $this->read_at!==null;
	}

    /**
     * Determine if a ticket has not been readed.
     *
     * @return bool
     */
	public function unreaded(){
		return $this->read_at===null;
	}

	/**
     * Mark the media as readed.
	 *
	 * @return $this
	 */
	public function markAsReaded(){
		$this->forceFill(['read_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the ticket as Unreaded.
     *
     * @return $this
     */
	public function markAsUnreaded(){
		$this->forceFill(['read_at' => null])->save();
		return $this;
	}

    /**
     * Determine if a ticket has been replied.
     *
     * @return bool
     */
	public function replied(){
		return $this->replied_at!==null ;
	}

    /**
     * Determine if a ticket has not been replied.
     *
     * @return bool
     */
	public function unreplied(){
		return $this->replied_at===null ;
	}

    /**
     * Mark ticket as replied.
     *
     * @return $this
     */
	public function markAsReplied(){
		$this->forceFill(['replied_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the ticket as unReplied.
     *
     * @return $this
     */
	public function markAsUnreplied(){
		$this->forceFill(['replied_at' => null])->save();
		return $this;
	}

    /**
     * Determine if a ticket has been opened.
     *
     * @return bool
     */
	public function opended(){
		return $this->status==TicketStatus::STATUS_OPENED;
	}

    /**
     * Mark the ticket as opened.
     *
     * @return $this
     */
	public function markAsOpened(){
		$this->forceFill(['status' => TicketStatus::STATUS_OPENED])->save();
		return $this;
	}

    /**
     * Determine if a ticket has been closed.
     *
     * @return bool
     */
	public function closed(){
		return $this->status==TicketStatus::STATUS_CLOSED;
	}

    /**
     * Mark the ticket as closed.
     *
     * @return $this
     */
	public function markAsClosed(){
		$this->forceFill(['status' => TicketStatus::STATUS_CLOSED])->save();
		return $this;
	}

    /**
     * Determine if a ticket department has been changed.
     *
     * @return bool
     */
	public function referral(){
		return $this->status==TicketStatus::STATUS_DEPARTMENT_CHANGED;
	}

    /**
     * Mark the ticket as its department has been changed.
     *
     * @return $this
     */
	public function markAsReferral(){
		$this->forceFill(['status' => TicketStatus::STATUS_DEPARTMENT_CHANGED])->save();
		return $this;
	}

    /**
     * Determine if a ticket's problem has been resolved.
     *
     * @return bool
     */
	public function resolved(){
		return $this->status==TicketStatus::STATUS_PROBLEM_RESOLVED;
	}

    /**
     * Mark the ticket's problem as resolved.
     *
     * @return $this
     */
	public function markAsResolved(){
		$this->forceFill(['status' => TicketStatus::STATUS_PROBLEM_RESOLVED])->save();
		return $this;
	}

	public function user(){
		return $this->belongsTo('App\User','user_id','id')->withTrashed();
	}

	/**
	 * Get ticket child nodes (replies)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function children(){
		return $this->hasMany('App\Ticket','ticket_id','id');
	}

	/**
	 * Get ticket parent node
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function parent(){
		return $this->belongsTo('App\Ticket','ticket_id','id');
	}

	/**
	 * Get root ticket
	 *
	 * @return Ticket|\Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function getRootAttribute(){
		return $this->root();
	}

	/**
	 * Get the root ticket
	 *
	 * @return Ticket|\Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function root(){
		if ($this->parent){
		  return $this->parent->root();
		}
		return $this;
	}

	/**
	 * Get ticket parent node if exists (even it is soft deleted).
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function garbageParent(){
		return $this->belongsTo('App\Ticket','ticket_id','id')
					->withTrashed();
	}

	/**
	 * Get root ticket if exists (even it is soft deleted).
	 *
	 * @return Ticket|\Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function getGarbageRootAttribute(){
		return $this->garbageRoot();
	}

	/**
	 * Get the root ticket if exists (even it is soft deleted).
	 *
	 * @return Ticket|\Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function garbageRoot(){
		if ($this->garbageParent){
		  return $this->garbageParent->garbageRoot();
		}
		return $this;
	}

	/**
     * Determine if a ticket is root.
	 *
	 * @return bool
	 */
	public function isRoot(){
		return $this->ticket_id===null;
	}

	/**
	 * get ticket department
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function department(){
		return $this->belongsTo('App\Department','department_id');
	}

	/**
	 * ticket attachments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function attachments(){
    	return $this->morphToMany('App\Media','pivot','medias_pivot','pivot_id','media_id')
    				->withTimestamps();
	}

	/**
	 * generate access_key
	 *
	 * @param $access_key_length
	 */
	public function setAccessKeyAttribute($access_key_length){
		$key=bin2hex(openssl_random_pseudo_bytes($access_key_length));
		$key=md5($key);
		$key=mb_substr($key,0,$access_key_length);
		$this->attributes['access_key']=$key;
	}

	public function rates(){
		return $this->morphMany('App\Rate','rateale','rateable_type','rateable_id');
	}

	public function ratesAverage(){
		return $this->rates()->avg('rate');
	}

}
