<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\ResetPasswordPin;
use App\Events\Auth\ResetPasswordToken;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function redirectPath()
	{
		return route('panel');
	}

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
	 *
	 * @param Request $request
	 * @param null $token
	 * @return $this
	 */
    public function showResetFormToken(Request $request, $token = null)
    {
        return view('auth.passwords.reset-token')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

	/**
     * Display the password reset view for the given PIN.
	 *
	 * @param Request $request
	 * @return $this
	 */
    public function showResetFormPin(Request $request)
    {
        return view('auth.passwords.reset-pin')->with(
            ['pin' => $request->pin, 'mobile' => $request->mobile]
        );
    }


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetWithToken(Request $request)
    {
		// validate inputs
		$validator=$this->validateResetWithTokenRequest($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
        	return redirect()->back()
                    		 ->withInput($request->all())
							 ->withErrors($validator->errors());
		}

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentialsTokenReset($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    public function resetWithPin(Request $request){
		// validate inputs
		$validator=$this->validateResetWithPinRequest($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
        return redirect()->back()
                    ->withInput($request->only(['mobile','pin']))
					->withErrors($validator->errors());
		}

        // Here we will attempt to reset the user's password. If it is successful we
        // will login user. Otherwise we will parse the error and return the response.
        $response = $this->broker()->check(
            $this->credentialsPinReset($request), function ($user) {
            	event(new ResetPasswordPin($user));
                $this->login($user);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse('passwords.login_pin')
                    : $this->sendResetFailedResponse($request, 'passwords.user_mobile');
    }

	/**
     * Get the password reset validation rules.
	 *
	 * @param Request $request
	 * @return mixed
	 */
    protected function validateResetWithTokenRequest(Request $request)
    {
    	return Validator::make($request->all(),[
			'token' 	=> 'required',
			'email' 	=> 'required|email|exists:users,email',
			'password' 	=> 'required|confirmed|min:6',
            'captcha' 	=> 'required|captcha',
		]);
    }

	/**
     * Get the password reset validation rules.
	 *
	 * @param Request $request
	 * @return mixed
	 */
    protected function validateResetWithPinRequest(Request $request)
    {
    	return Validator::make($request->all(),[
            'mobile' 	=> 'required|numeric|exists:users,mobile',
            'pin' 		=> 'required|min:4',
            'captcha' 	=> 'required|captcha',
		]);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentialsTokenReset(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentialsPinReset(Request $request)
    {
        return $request->only(
            'mobile', 'pin'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();

		event(new ResetPasswordToken($user,$password));

        if(request()->expectsJson()){
        	$user=(array)$user;
        	return response()->json($user);
        }

		$this->login($user);
    }

	/**
	 * Login user
	 *
	 * @param $user
	 */
    protected function login($user){
        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($response)
    {
    	$status=trans($response);

		if(request()->expectsJson()){
			return response()->json(['status' => $status],200);
		}

        return redirect($this->redirectPath())
							 ->with('status', $status);
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
    	$status=trans($response);

		if($request->expectsJson()){
			return response()->json(['status' => $status],422);
		}

        return redirect()->back()
                    ->withInput($request->only('email','mobile'))
                    ->withErrors(['status' => $status]);
    }
}
