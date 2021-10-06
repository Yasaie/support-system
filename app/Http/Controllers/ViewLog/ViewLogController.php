<?php

namespace App\Http\Controllers\ViewLog;

use App\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ViewLogController extends Controller
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
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function index(Request $request)
    {
    	// Check policy
		$this->authorize('index',View::class);

    	$search=$request->input('search');

    	$logs=View::where('ip','like','%'.$search.'%')
					->orWhere('referrer','like','%'.$search.'%')
					->orWhere('url','like','%'.$search.'%')
					->orWhere('continent','like','%'.$search.'%')
					->orWhere('country','like','%'.$search.'%')
					->orderByDesc('created_at');

        if($request->expectsJson()){
        	return response()->json($logs->paginate(),200);
        }

        return view('log.view.index')->with('logs',$logs->simplePaginate());
    }

	/**
	 * creates map js data.
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function map(){
    	// Check policy
		$this->authorize('map',View::class);

		$logs=DB::select('
			SELECT COUNT(id) as visits,country,country_shortname
			From views WHERE DATE(created_at) >= CURDATE()
			GROUP BY `country`
		');

		$output='var country_pin = Array();'.PHP_EOL;
		$sample_data=null;
		$country_pin=null;
		if(!empty($logs)){
			$sample_data = implode(',', array_map(
				function ($v) use (&$country_pin) {
					if(!empty($v->country)){
						$country_pin.='country_pin["'.strtolower($v->country_shortname).'"] = "'.$v->country.' ['.$v->visits.']";'.PHP_EOL;
						return '"'.strtolower($v->country_shortname).'":'.'"'.$v->visits.'"';
					}
				},
				$logs
			));
		}

		$output.='var simple_data={'.$sample_data.'};'.PHP_EOL;
		$output.=$country_pin;
		return response()->make($output,200,['content-type:text/javascript;charset=utf-8']);
    }
}
