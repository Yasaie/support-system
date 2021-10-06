<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

	/**
	 * User email verification
	 *
	 * @var bool
	 */
	protected $isEmailVerificationNeeded=true;

	/**
	 * User mobile verification.
	 *
	 * @var bool
	 */
	protected $isMobileVerificationNeeded=true;

	/**
	 * Length for email confirmation token.
	 *
	 * @var int
	 */
	protected $emailTokenLength=64;

	/**
	 * Length for mobile confirmation token.
	 *
	 * @var int
	 */
	protected $mobileTokenLength=6;

	/**
	 * mobile format for register new users.
	 *
	 * @var string
	 */
	protected $mobileFormat='(09(?:[0-9]){9})';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

	/**
	 * user password
	 *
	 * @var string
	 */
     protected $password;

    public function __construct()
    {
        $this->middleware('guest');

        // set some configs:
        $this->mobileFormat=config('app.mobile_format');
		$this->isEmailVerificationNeeded=config('email.verification.status');
		$this->isMobileVerificationNeeded=config('mobile.verification.status');

    }

	/**
     * Where to redirect users after registration.
	 *
	 * @return string
	 */
    public function redirectTo()
	{
		return route('panel');
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
        	'name' =>[
        		'bail',
        		'required',
        		'min:3',
			],
        	'email' => [
				'bail',
				(config('email.verification.status')?'required':'required_without:mobile'),
				'nullable',
				'email',
				'unique:users,email'
			],
        	'mobile' => [
				'bail',
				(config('mobile.verification.status')?'required':'required_without:email'),
				'nullable',
				'numeric',
				'regex:/'.$this->mobileFormat.'/',
				'unique:users,mobile'
			],
			'password' =>[
				'required',
				'confirmed',
				'min:6',
			],
			'captcha' =>[
				'required',
				'captcha',
			],
			'rules' =>[
				'required',
			],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
			'email' 				=> $data['email'],
			'mobile' 				=> $data['mobile'],
            'email_verified_at'		=> (($this->isEmailVerificationNeeded == false && !empty($data['email'])) ? (new Carbon) : null),
            'mobile_verified_at'	=> (($this->isMobileVerificationNeeded == false && !empty($data['mobile'])) ? (new Carbon) : null),
            'email_token'			=> $this->emailTokenLength,
            'mobile_token'			=> $this->mobileTokenLength,
            'password' 				=> $this->password,
        ]);
    }

	/**
     * Handle a registration request for the application.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function register(Request $request)
    {
		if(!config('app.registration.status')){ //registration is not active
			$errors=['site_registration_status'=>trans('auth.site_registration_not_active')];
			if($request->expectsJson()){
				return response()->json([
					'errors'=>$errors
				],422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($errors);
		}

        $validator = $this->validator($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$this->password=$request->input('password');

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user);
    }

	/**
	 * The user has been registered.
	 *
	 * @param Request $request
	 * @param $user
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    protected function registered(Request $request, $user)
    {
		//create user meta:
		UserMeta::create([
			'name' => $request->input('name'),
			'user_id' => $user->id,
		]);

		//prepare a json:
    	$returnedJson=[
    		'name'=>$user->name,
    		'email'=>$user->email,
			'mobile'=>$user->mobile,
			'email_verified'=>$user->emailVerified(),
			'mobile_verified'=>$user->mobileVerified(),
		];

		//user need verification step:
        if ($request->expectsJson()){
            return response()->json($returnedJson,200);
        }

		//verify with mobile:
		if($user->mobile && $user->mobileUnverified())
			return redirect()->route('verify.pin')->with('user',$user);
		//verify with email:
		if($user->email && $user->emailUnverified()){
			$status=trans('password.verify_token');
			//show notice page , that means email has been sent
			return view('auth.verify.verify-token-notice')->with('status',$status);
		}

		return redirect()->route('login');
    }
}
