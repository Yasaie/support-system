<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\View as ViewModel;
use Illuminate\Support\Facades\Auth;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use WhichBrowser\Parser;

class View
{

	/**
	 * save request's logs.
	 *
	 * @param Request $request
	 */
	protected function saveLog(Request $request){
		if(function_exists('getallheaders')){
			$identifier=new Parser(getallheaders());
		}else{
			$identifier=new Parser($_SERVER['HTTP_USER_AGENT']);
		}
	    $geoip = new GeoIPLocation();

		$data=[
			'user_id'				=> ( (Auth::guard()->check()) ? Auth::id() : null ),
			'ip'					=> $request->ip(),
			'referrer'				=> ( empty($request->headers->get('referer')) ? null : $request->headers->get('referer') ),
			'url'					=> $request->fullUrl(),
			'agent'					=> $request->userAgent(),
			'browser'				=> $identifier->browser->name,
			'os'					=> $identifier->os->name,
			'continent'				=> $geoip->getContinent(),
			'country'				=> $geoip->getCountry(),
			'country_shortname'		=> $geoip->getCountryCode(),
			'city'					=> $geoip->getCity(),
			'latitude'				=> $geoip->getLatitude(),
			'longitude'				=> $geoip->getLongitude(),
		];

		ViewModel::create($data);
	}

	public function exceptions(Request $request){
		$exceptions=config('viewlog.exceptions',['captcha']);
		$uri=$request->getRequestUri();

    	foreach($exceptions as $exception){
    		$exception='/'.($exception).'/iu';
    		if(preg_match($exception,$uri)){
    			return false;
    		}
		}

		return true;
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if($this->exceptions($request)){
			$this->saveLog($request);
		}

        return $next($request);
    }
}
