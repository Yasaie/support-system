<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\CoreRewrite\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class User extends Authenticatable
{
	use softDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'mobile',
        'is_owner',
        'is_admin',
        'locked_at',
        'email_verified_at',
        'mobile_verified_at',
        'email_token',
        'mobile_token',
        'password',
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
		'locked_at',
		'email_verified_at',
		'mobile_verified_at',
		'deleted_at',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
	    'is_owner' => 'integer',
	    'is_admin' => 'integer',
        'locked_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be append to data arrays.
     *
     * @var array
     */
     protected $appends = [
     	'name',
     	'phone',
     	'gender',
     	'country',
     	'country_name',
     	'country_id',
     	'province',
     	'province_name',
     	'province_id',
     	'city',
     	'city_name',
     	'city_id',
     	'biography',
     	'avatar',
     	'avatar_url',
	 ];

    /**
     * Determine if a user is owner.
     *
     * @return bool
     */
	public function owner(){
		return $this->is_owner!==0;
	}

	/**
     * Mark the user as owner.
	 *
	 * @return $this
	 */
	public function markAsOwner(){
		$this->forceFill(['is_owner' => true])->save();
		return $this;
	}

    /**
     * Mark the user as not owner.
     *
     * @return $this
     */
	public function markAsNotOwner(){
		$this->forceFill(['is_owner' => false])->save();
		return $this;
	}

    /**
     * Determine if a user is admin.
     *
     * @return bool
     */
	public function admin(){
		return $this->is_admin!==0;
	}

	/**
     * Mark the user as admin.
	 *
	 * @return $this
	 */
	public function markAsAdmin(){
		$this->forceFill(['is_admin' => true])->save();
		return $this;
	}

    /**
     * Mark the user as not admin.
     *
     * @return $this
     */
	public function markAsNotAdmin(){
		$this->forceFill(['is_admin' => false])->save();
		return $this;
	}

    /**
     * Determine if a user has been locked.
     *
     * @return bool
     */
	public function locked(){
		return $this->locked_at!==null;
	}

    /**
     * Determine if a user has not been locked.
     *
     * @return bool
     */
	public function unlocked(){
		return $this->locked_at===null;
	}

	/**
     * Mark the user as locked.
	 *
	 * @return $this
	 */
	public function markAsLocked(){
		$this->forceFill(['locked_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the user as Unlocked.
     *
     * @return $this
     */
	public function markAsUnlocked(){
		$this->forceFill(['locked_at' => null])->save();
		return $this;
	}

    /**
     * Determine if a user's email has been verified.
     *
     * @return bool
     */
	public function emailVerified(){
		return $this->email_verified_at!==null;
	}

    /**
     * Determine if a user's email has not been verified.
     *
     * @return bool
     */
	public function emailUnverified(){
		return $this->email_verified_at===null;
	}

	/**
     * Mark the user's email as verified.
	 *
	 * @return $this
	 */
	public function markEmailAsVerified(){
		$this->forceFill(['email_verified_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the user's email as unverified.
     *
     * @return $this
     */
	public function markEmailAsUnverified(){
		$this->forceFill(['email_verified_at' => null])->save();
		return $this;
	}

    /**
     * Determine if a user's mobile has been verified.
     *
     * @return bool
     */
	public function mobileVerified(){
		return $this->mobile_verified_at!==null;
	}

    /**
     * Determine if a user's mobile has not been verified.
     *
     * @return bool
     */
	public function mobileUnverified(){
		return $this->mobile_verified_at===null;
	}

	/**
     * Mark the user's mobile as verified.
	 *
	 * @return $this
	 */
	public function markMobileAsVerified(){
		$this->forceFill(['mobile_verified_at' => $this->freshTimestamp()])->save();
		return $this;
	}

    /**
     * Mark the user's email as unverified.
     *
     * @return $this
     */
	public function markMobileAsUnverified(){
		$this->forceFill(['mobile_verified_at' => null])->save();
		return $this;
	}

	/**
	 * Generate email token
	 * Email's token is used for email confirmation
	 *
	 * @param $length
	 */
   	protected function setEmailTokenAttribute($length){
   		if(empty($length)){
			$this->attributes['email_token']=null;
		}else{
			$this->attributes['email_token']=mb_substr(bin2hex(openssl_random_pseudo_bytes($length)),(-$length));
		}
	}

	/**
	 * Generate mobile token
	 * Mobile's token is used to mobile confirmation
	 *
	 * @param $length
	 */
   	protected function setMobileTokenAttribute($length){
   		if(empty($length)){
			$this->attributes['mobile_token']=null;
		}else{
			$pin=hexdec(bin2hex(openssl_random_pseudo_bytes($length)));
			$this->attributes['mobile_token']=mb_substr(preg_replace('/[a-zA-Z\+\^]/iu','',$pin),(-$length));
		}
   	}

	/**
	 * Hash password
	 *
	 * @param $password
	 */
    public function setPasswordAttribute($password)
    {
    	$this->attributes['password']=bcrypt($password);
    }

	/**
	 * departments that user is working in them
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function departments(){
		return $this->belongsToMany('App\Department','departments_users','user_id','department_id')
	 		 		->withTimestamps()
	 		 		->withPivot('is_leader');
	}

	/**
	 * Determine if a user is leader of any departments.
	 *
	 * @return bool
	 */
	public function leader(){
		$count= $this->belongsToMany('App\Department','departments_users','user_id','department_id')
					->wherePivot('is_leader','=',true)
					->count();
		return $count>0;
	}

	/**
	 * departments that user is leader in them
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function leaderInDepartments(){
		return $this->belongsToMany('App\Department','departments_users','user_id','department_id')
					->wherePivot('is_leader','=',true)
	 		 		->withTimestamps()
	 		 		->withPivot('is_leader');
	}

	/**
	 * Determine if a user is staff of any departments.
	 *
	 * @return bool
	 */
	public function staff(){
		$count= $this->belongsToMany('App\Department','departments_users','user_id','department_id')
					->wherePivot('is_leader','=',false)
					->count();
		return $count>0;
	}

	/**
	 * Departments that user is staff in them.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function staffInDepartments(){
		return $this->belongsToMany('App\Department','departments_users','user_id','department_id')
					->wherePivot('is_leader','=',false)
	 		 		->withTimestamps()
	 		 		->withPivot('is_leader');
	}

	/**
	 * User's meta data.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function meta(){
		return $this->hasOne('App\UserMeta','user_id','id');
	}

	/**
	 * Get user's name from its meta data.
	 *
	 * @return null
	 */
	public function getNameAttribute(){
		return ( ($this->meta) ? ($this->meta->name) : null );
	}

	/**
	 * Set user's name in its meta data.
	 *
	 * @param $name
	 */
	public function setNameAttribute($name){
		$this->meta()->forceFill(['name' => $name])->save();
	}

	/**
	 * Get user's phone from its meta data.
	 *
	 * @return null
	 */
	public function getPhoneAttribute(){
		return ( ($this->meta) ? ($this->meta->phone) : null );
	}

	/**
	 * Set user's phone in its meta data.
	 *
	 * @param $phone
	 */
	public function setPhoneAttribute($phone){
		$this->meta()->forceFill(['phone' => $phone])->save();
	}

	/**
	 * Get user's gender from its meta data.
	 *
	 * @return null
	 */
	public function getGenderAttribute(){
		return ( ($this->meta) ? ($this->meta->gender) : null );
	}

	/**
	 * Set user's gender in its meta data.
	 *
	 * @param $gender
	 */
	public function setGenderAttribute($gender){
		$this->meta()->forceFill(['gender' => $gender])->save();
	}

	/**
	 * Get user's country from its meta data.
	 *
	 * @return null
	 */
	public function getCountryAttribute(){
		return ( ($this->meta) ? ($this->meta->country) : null );
	}

	/**
	 * Get user's country_name from its meta data.
	 *
	 * @return null
	 */
	public function getCountryNameAttribute(){
		return ( ($this->meta && $this->meta->country) ? ($this->meta->country->name) : null );
	}

	/**
	 * Get user's country_id from its meta data.
	 *
	 * @return null
	 */
	public function getCountryIdAttribute(){
		return ( ($this->meta) ? ($this->meta->country_id) : null );
	}

	/**
	 * Set user's country_id in its meta data.
	 *
	 * @param $country_id
	 */
	public function setCountryIdAttribute($country_id){
		$this->meta()->forceFill(['country_id' => $country_id])->save();
	}

	/**
	 * Get user's province from its meta data.
	 *
	 * @return null
	 */
	public function getProvinceAttribute(){
		return ( ($this->meta) ? ($this->meta->province) : null );
	}

	/**
	 * Get user's province_name from its meta data.
	 *
	 * @return null
	 */
	public function getProvinceNameAttribute(){
		return ( ($this->meta && $this->meta->province) ? ($this->meta->province->name) : null );
	}

	/**
	 * Get user's province_id from its meta data.
	 *
	 * @return null
	 */
	public function getProvinceIdAttribute(){
		return ( ($this->meta) ? ($this->meta->province_id) : null );
	}

	/**
	 * Set user's province_id in its meta data.
	 *
	 * @param $province_id
	 */
	public function setProvinceIdAttribute($province_id){
		$this->meta()->forceFill(['province_id' => $province_id])->save();
	}

	/**
	 * Get user's city from its meta data.
	 *
	 * @return null
	 */
	public function getCityAttribute(){
		return ( ($this->meta) ? ($this->meta->city) : null );
	}

	/**
	 * Get user's city_name from its meta data.
	 *
	 * @return null
	 */
	public function getCityNameAttribute(){
		return ( ($this->meta && $this->meta->city) ? ($this->meta->city->name) : null );
	}

	/**
	 * Get user's city_id from its meta data.
	 *
	 * @return null
	 */
	public function getCityIdAttribute(){
		return ( ($this->meta) ? ($this->meta->city_id) : null );
	}

	/**
	 * Set user's city_id in its meta data.
	 *
	 * @param $city_id
	 */
	public function setCityIdAttribute($city_id){
		$this->meta()->forceFill(['city_id' => $city_id])->save();
	}

	/**
	 * Get user's biography from its meta data.
	 *
	 * @return null
	 */
	public function getBiographyAttribute(){
		return ( ($this->meta) ? ($this->meta->biography) : null );
	}

	/**
	 * Set user's biography in its meta data.
	 *
	 * @param $biography
	 */
	public function setBiographyAttribute($biography){
		$this->meta()->forceFill(['biography' => $biography])->save();
	}

	/**
	 * Get user's avatar from its meta data.
	 *
	 * @return null
	 */
	public function getAvatarAttribute(){
		return ( ($this->meta) ? $this->meta->avatar : null );
	}

	/**
	 * get user's avatar URL from meta data
	 *
	 * @return string
	 */
	public function getAvatarUrlAttribute(){
		if($this->avatar){
			return route('media.resize',$this->avatar);
		}
		//gravatar URL
		if($this->email){
			return Gravatar::src($this->email);
		}
		//default
		if($this->gender=='female'){
			return asset('images/female_avatar.png');
		}else{
			return asset('images/male_avatar.png');
		}
	}

	/**
	 * Set user's avatar in its meta data.
	 *
	 * @param $avatar
	 */
	public function setAvatarAttribute($avatar){
		$this->meta()->forceFill(['avatar' => $avatar])->save();
	}

	/**
	 * user's news
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function news(){
		return $this->hasMany('App\News','user_id');
	}

	/**
	 * user's medias
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function medias(){
		return $this->hasMany('App\Media','user_id');
	}

	/**
	 * User's master tickets.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function rootTickets(){
		return $this->hasMany('App\Ticket','user_id')
			 		->whereNull('ticket_id');
	}

	/**
	 * All of user's tickets.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tickets(){
		return $this->hasMany('App\Ticket','user_id');
	}

	/**
	 * User's reply tickets.
	 *
	 * @return \Illuminate\Database\Query\Builder|static
	 */
	public function replyTickets(){
		return $this->hasMany('App\Ticket','user_id')
			 		->whereNotNull('ticket_id');
	}

	/**
	 * The not root tickets that user has replied them.
	 *
	 * @return mixed
	 */
	public function repliedTickets(){
		return DB::table('tickets as a')
			->join('tickets as b',function ($join) {
    	        $join->on('a.id', '=', 'b.ticket_id')
                 ->where('b.user_id', '=', $this->id)
                 ->whereNotNull('b.ticket_id');
	        })
	        ->select('a.*')
	        ->distinct('a.id');
	}

	/**
	 * Count not root tickets that user has replied them.
	 *
	 * @return mixed
	 */
	public function repliedTicketsCount(){
		return $this->repliedTickets()->count('a.id');
	}

	/**
	 * Notifications that user has created.
	 */
	public function sentNotifications(){
		return $this->belongsTo('App\Notification','id','creator_id')->withTrashed();
	}

	/**
	 * Notification that user is its recipient.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function receivedNotifications(){
		return $this->belongsToMany('App\Notification','notification_recipient','recipient_id','notification_id')
	 		 		->withTimestamps()
	 		 		->withPivot('read_at');
	}

	public function rates(){
		return $this->morphMany('App\Rate','rateale','rateable_type','rateable_id');
	}

	public function ratesAverage(){
		return $this->rates()->avg('rate');
	}

	/**
	 * returns user's roles.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles(){
		return $this->belongsToMany('App\Role','users_roles');
	}

	/**
	 * determine user has role.
	 *
	 * @param $name
	 * @return bool
	 */
	public function hasRole($name){
		if(($this->roles()->where('name','=',$name)->count())>0){
			return true;
		}
		return false;
	}

	/**
	 * determine user has a permissions.
	 *
	 * @param $name
	 * @return bool
	 */
	public function hasPermission($name){
		$roles=$this->roles()
			 		->whereHas('permissions',function($query) use ($name){
			 			$query->where('name','=',$name);
			 		})->count();
		if($roles>0){
			return true;
		}
		return false;
	}

}
//change hasRoles into has permission in policies


