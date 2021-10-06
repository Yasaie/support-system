<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

	/**
	 * shows a request (pin/token) form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function showRequestForm(){
		return view('auth.passwords.request');
    }

	/**
	 * Shows reset PIN form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showPinRequestForm(){
		return view('auth.passwords.request-pin');
	}

	/**
	 * Shows reset Token form
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showTokenRequestForm(){
		return view('auth.passwords.request-token');
	}

	/**
	 * Sends a PIN number in order to reset password
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function sendResetPin(Request $request){
		// validate request
		$validator=$this->validateMobile($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
 							 ->withInput($request->all('mobile'))
							 ->withErrors($validator->errors());
		}

        // We will send the password reset PIN to this user. Once we have attempted
        // to send the PIN, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetPin($request->only('mobile'));

		// succeed
		if($response == Password::RESET_LINK_SENT){
			$response='passwords.sent_mobile';
			return $this->sendResetPinResponse($response);
		}

		//failed
		$response='passwords.user_mobile';
		return $this->sendResetPinFailedResponse($request, $response);
	}


	/**
	 * Sends a token in order to resetting password
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function sendResetToken(Request $request){
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

        // We will send the password reset PIN to this user. Once we have attempted
        // to send the PIN, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetToken($request->only('email'));

		// succeed
		if($response == Password::RESET_LINK_SENT){
			return $this->sendResetTokenResponse($response);
		}

		// failed
		return $this->sendResetPinFailedResponse($request, $response);
	}

	/**
	 * Validate mobile number
	 *
	 * @param Request $request
	 * @return mixed
	 */
	protected function validateMobile(Request $request){
        return Validator::make($request->all(), [
            'mobile' 	=> 'required|numeric|exists:users,mobile',
            'captcha' 	=> 'required|captcha',
        ]);
	}

	/**
	 * Validate E-mail address
	 *
	 * @param Request $request
	 * @return mixed
	 */
    protected function validateEmail(Request $request)
	{
        return Validator::make($request->all(), [
            'email' 	=> 'required|email|exists:users,email',
            'captcha' 	=> 'required|captcha',
        ]);
	}

	/**
     * Get the response for a successful password reset Token.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetTokenResponse($response)
    {
    	$status=trans($response);

		//for AJAX request
		if(request()->expectsJson()){
			return response()->json(['status'=>$status],200);
		}

        return redirect()->back()->with('status', $status);
    }


	/**
	 * Get the response for a successful password reset PIN.
	 *
	 * @param $response
	 * @return \Illuminate\Http\RedirectResponse
	 */
    protected function sendResetPinResponse($response){
    	$status=trans($response);

		//for AJAX request
		if(request()->expectsJson()){
			return response()->json(['status'=>$status],200);
		}

        return redirect()->route('password.reset.pin')
        				 ->with('status', $status)
						 ->withInput(request()->only('mobile'));
    }

    /**
     * Get the response for a failed password reset Token.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetTokenFailedResponse(Request $request, $response)
    {
    	$errors=trans($response);

		//for AJAX request
		if($request->expectsJson()){
			return response()->json(['errors'=>$errors],422);
		}

        return redirect()->back()->withErrors(
            ['email'=> $errors]
        );
    }

    /**
     * Get the response for a failed password reset PIN.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetPinFailedResponse(Request $request, $response)
    {
    	$errors=trans($response);

		//for AJAX request
		if($request->expectsJson()){
			return response()->json(['errors'=>$errors],422);
		}

        return redirect()->back()->withErrors(
            ['mobile'=> $errors]
        );
    }
}
