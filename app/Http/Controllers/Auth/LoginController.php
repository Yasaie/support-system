<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	/**
     * Where to redirect users after login.
	 *
	 * @return string
	 */
    public function redirectTo()
	{
		return route('panel');
	}

	/**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
    	// validate inputs
        $validator=$this->validateLogin($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->only($this->username(), 'remember'))
				->withErrors($validator->errors());
		}

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

		//check credentials:
		$credentials=$this->credentials($request)[$this->username()];
		$user=User::where($credentials)->get();
		if($user->isEmpty()){
			return $this->sendFailedLoginResponse($request);
		}

		if($this->checkIfAccountIsLocked($user)){
			return $this->accountIsLockedResponse($request);
		}

        // Check if user account is verified?
        // each user must account must be verified to login into it
		if($this->checkIfAccountIsVerified($credentials,$user)){
			if ($this->attemptLogin($request)){
				return $this->sendLoginResponse($request);
			}
		}else{
			// If the user account wasn't verified we run a callback
			return $this->sendNeedVerificationResponse($request);
		}

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

	/**
     * Validates the user login request.
	 *
	 * @param Request $request
	 * @return mixed
	 */
    protected function validateLogin(Request $request)
    {
        return Validator::make($request->all(), [
            $this->username() 	=> 'required|string',
            'password'			=> 'required|string',
            'captcha'			=> 'required|captcha',
        ]);
    }

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
    public function username()
    {
		return 'username';
    }

	/**
	 * Checks if user account is verified or not
	 * user must verify his E-mail/Mobile in order to verify his/her account
	 *
	 * @param $user
	 * @return bool
	 */
	protected function checkIfAccountIsVerified($credentials,$user){
		if((!empty($credentials['mobile']) && $user->first()->mobileUnverified())){
			return false;
		}
		if(!empty($credentials['email']) && $user->first()->emailUnverified()){
			return false; // user account is not verified
		}
		return true; // user account is verified
	}

	/**
	 * check if user's account is blocked.
	 *
	 * @param $user
	 * @return mixed
	 */
	protected function checkIfAccountIsLocked($user){
		return $user->first()->locked();
	}

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
    	$username=$this->credentials($request)[$this->username()];
    	$password=$this->credentials($request)['password'];

    	//create credentials:
    	$credentials=array_merge($username,['password'=>$password]);

        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }

	/**
     * Get the needed authorization credentials from the request.
	 *
	 * @param Request $request
	 * @return mixed
	 */
    protected function credentials(Request $request)
    {
    	$username=$request->input($this->username());
		$password=$request->only('password');

		if(is_numeric($username)){
			$username=['mobile'=>$username];
		}else{
			$username=['email'=>$username];
		}

		return array_merge(
			[$this->username() => $username],
			$password
		);
    }

	/**
     * Send the response after the user was authenticated.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user());
    }

	/**
     * The user has been authenticated.
	 *
	 * @param Request $request
	 * @param $user
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
    protected function authenticated(Request $request, $user)
    {
		if($request->expectsJson()){
			return response()->json(['status'=>'logined','user'=>$user],200);
		}
		return redirect()->intended($this->redirectPath());
    }

	/**
     * Get the failed login response instance.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

	/**
	 * Send response that shows user needs to verify his/her account.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    protected function sendNeedVerificationResponse(Request $request)
    {
	    $credentials=$this->credentials($request)[$this->username()];
        if(!empty($credentials['email'])){
			$errors = ['need_verification' => trans('auth.email_verification')];
		}else{
			$errors = ['need_verification' => trans('auth.mobile_verification')];
		}

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

	/**
	 * Send response that shows user account is locked.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    protected function accountIsLockedResponse(Request $request){
		$errors = ['locked' => trans('auth.locked')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

	/**
     * Log the user out of the application.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

}
