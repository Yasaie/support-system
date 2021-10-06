<?php

namespace App\Http\Controllers\Faq;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    public static function lastFaqs($count=4){
		$faqs=Faq::orderBy('id','DESC')->limit($count)->get();
		return $faqs;
    }
}
