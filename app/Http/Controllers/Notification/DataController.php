<?php
namespace App\Http\Controllers\Notification;

use Illuminate\Support\Facades\Auth;

class DataController {
	public static function newNotifications(){
		return Auth::user()->receivedNotifications()
						   ->wherePivot('read_at','=',null)
						   ->limit(5)
						   ->get();
	}

	public static function newNotificationsCount(){
		return Auth::user()->receivedNotifications()
						   ->wherePivot('read_at','=',null)
						   ->count();
	}

}