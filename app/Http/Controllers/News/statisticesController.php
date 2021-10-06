<?php
namespace App\Http\Controllers\News;

use App\News;
use Illuminate\Support\Facades\Auth;

class statisticesController {
	public static function count(){
    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//owners and admins can see all news
			return News::count();
		}elseif(Auth::user()->leader()){
			//leader can see his/her news
			return Auth::user()->news()->count();
		}
	}
}