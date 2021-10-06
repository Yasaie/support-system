<?php

namespace App\Http\Controllers\SmsLog;

use App\SmsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsLogController extends Controller
{
	/**
	 * CountryController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Display a listing of the resource.
     *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function index(Request $request)
    {
    	// Check policy
		$this->authorize('index',SmsLog::class);

    	$search=$request->input('search');

    	$logs=SmsLog::where('subject','like','%'.$search.'%')
					->orWhere('content','like','%'.$search.'%')
					->orWhere('to','like','%'.$search.'%');

        if($request->expectsJson()){
        	return response()->json($logs->paginate(),200);
        }

        return view('log.sms.index')->with('logs',$logs->simplePaginate());
    }
}
