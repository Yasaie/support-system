<?php

namespace App\Http\Controllers\News;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    public static function lastNews($count=4){
		$news=News::orderBy('id','DESC')
				  ->whereNotNull('published_at')
				  ->limit($count)
				  ->get();

		return $news;
    }
}
