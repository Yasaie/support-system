<?php
namespace App\Http\Controllers\Auth;

use App\Events\Auth\RequestVerifyPin;
use App\Events\Auth\RequestVerifyToken;
use App\Events\Auth\VerifyPin;
use App\Events\Auth\VerifyToken;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | User Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling user verification with PIN number
    | and Token string , includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

	/**
	 * Length for email confirmation token
	 *
	 * @var int
	 */
	protected $emailTokenLength=64;

	/**
	 * Length for mobile confirmation token
	 *
	 * @var int
	 */
	protected $mobileTokenLength=6;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	//nothing
    }

	/**
	 * Find user by the given credentials
	 *
	 * @param $credentials
	 * @return mixed
	 */
    protected function getUser($credentials){
		$user=User::where($credentials)->get();
		if(!$user->isEmpty()){
    		return $user->first();
    	}
    }


	/**
	 * Show a form for requesting a new PIN number
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showRequestPinForm(){
		return view('auth.verify.request-pin');
	}

	/**
	 * Generate and Send a PIN number to user
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function sendPin(Request $request){
		// validate request
		$validator=$this->validateMobile($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->only('mobile'))
				->withErrors($validator->errors());
		}

		//find user
		$user=$this->getUser($request->only('mobile'));

		//if user has been founded
		if($user){
			if(!$user->mobile_token){
				$this->refreshPin($user);
			}

			event(new RequestVerifyPin($user));

			$status=trans('passwords.verify_pin');

			//json response for ajax calls
			if($request->expectsJson()){
				return response()->json(['status'=>$status],200);
			}

			return redirect()->route('verify.pin')->with('status',$status);
		}

		//if user not found show an error
		return $this->userNotFound(['mobile'=>trans('passwords.user_mobile')]);
	}

	/**
	 * Validates mobile phone number
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function validateMobile(Request $request){
        return Validator::make($request->all(), [
            'mobile' 	=> 'required|numeric',
            'captcha' 	=> 'required|captcha',
        ]);
	}

	/**
	 * validate PIN number
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function validatePin(Request $request){
        return Validator::make($request->all(), [
            'pin' 		=> 'required|string',
            'captcha' 	=> 'required|captcha',
        ]);
	}

	/**
	 * Shows a form to verify mobile number by the given PIN number
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showVerifyPinForm(){
		return view('auth.verify.verify-pin');
	}

	/**
	 * Verifies the mobile number using the given PIN number
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function verifyWithPin(Request $request){
		// validate request
		$validator=$this->validatePin($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->only('pin'))
				->withErrors($validator->errors());
		}

		//find user
		$user=$this->getUser(['mobile_token'=>$request->input('pin')]);

		//if user has been founded
		if($user){
			$user->markMobileAsVerified();

			event(new VerifyPin($user));

			$status=trans('passwords.verification_done');

			//json response for ajax calls
			if(request()->expectsJson()){
				return response()->json(['status'=>$status],200);
			}

			return redirect()->route('login')->with('status',$status);
		}

		//if user not found show an error
		return $this->pinNotFound(['pin'=>trans('passwords.pin')]);
	}

	/**
	 * Updates the user in order to verify her/him
	 *
	 * @param $user
	 * @param $verifications
	 * @return mixed
	 */
	protected function verify($user,$verifications){
		return $user->update($verifications);
	}

	/**
	 * Generates a new PIN number
	 *
	 * @param $user
	 */
	protected function refreshPin($user){
		$user->update(['mobile_token'=>$this->mobileTokenLength]);
	}


	/**
	 * Gives the user not found response
	 *
	 * @param $errors
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
	protected function userNotFound($errors){
		//json response for ajax calls
		if(request()->expectsJson()){
			return response()->json($errors,422);
		}
		return redirect()->back()->withErrors($errors);
	}


	/**
	 * Gives the PIN number not found response
	 *
	 * @param $errors
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
	protected function pinNotFound($errors){
		//json response for ajax calls
		if(request()->expectsJson()){
			return response()->json($errors,422);
		}

		return redirect()->back()->withErrors($errors);
	}

	/**
	 * shows a form for requesting Token in order to verifying the E-mail address
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showRequestTokenForm(){
		return view('auth.verify.request-token');
	}

	/**
	 * Sends a Token for user
	 *
	 * @param Request $request
	 * @return $this|VerifyController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function sendToken(Request $request){

		// validate request
		$validator=$this->validateEmail($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->only('email'))
				->withErrors($validator->errors());
		}

		//find user
		$user=$this->getUser($request->only('email'));

		//if user has been founded
		if($user){
			if(!$user->email_token){
				$this->refreshToken($user);
			}

			event(new RequestVerifyToken($user));

			$status=trans('password.verify_token');

			//json response for ajax calls
			if(request()->expectsJson()){
				return response()->json(['status'=>$status],200);
			}

			//show notice page , that means email has been sent
			return view('auth.verify.verify-token-notice')->with('status',$status);
		}

		//if user not found show an error
		return $this->userNotFound(['email'=>trans('passwords.user')]);

	}

	/**
	 * Shows a from in order to verifying E-mail address using given token
	 *
	 * @param $token
	 * @return $this
	 */
	public function showVerifyTokenForm($token = null){
		return view('auth.verify.verify-token')->with('token',$token);
	}

	/**
	 * Verifies user E-mail address using the given Token string
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function verifyWithToken(Request $request){
		// validate request
		$validator=$this->validateToken($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->only('token'))
				->withErrors($validator->errors());
		}

		//find user
		$user=$this->getUser(['email_token'=>$request->input('token')]);
		if($user){
			$user->markEmailAsVerified();

			event(new VerifyToken($user));

			$status=trans('passwords.verification_done');

			//json response for ajax calls
			if(request()->expectsJson()){
				return response()->json(['status'=>$status],200);
			}

			return redirect()->route('login')->with('status',$status);
		}

		//if user not found show an error
		return $this->pinNotFound(['token'=>trans('passwords.token_not_valid')]);
	}

	/**
	 * Validates E-mail address
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function validateEmail(Request $request){
        return Validator::make($request->all(), [
            'email' 	=> 'required|email',
            'captcha' 	=> 'required|captcha',
        ]);
	}

	/**
	 * Validates token string
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function validateToken(Request $request){
        return Validator::make($request->all(), [
            'token'  => 'required|string',
        ]);
	}

	/**
	 * Generates a new token
	 *
	 * @param $user
	 */
	protected function refreshToken($user){
		$user->update(['email_token'=>$this->emailTokenLength]);
	}
}