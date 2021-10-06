<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Swift_SwiftException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
	 * @param Exception $exception
	 * @throws Exception
	 */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
 		// When we call pages with wrong methods , it makes showing them as a 404 page
 		if ($exception instanceof MethodNotAllowedHttpException)
    	{
        	return abort(404);
    	}

		// Control CSRF mismatch with redirecting back to the page
        if ($exception instanceof TokenMismatchException)
        {
            // Redirect to a form. Here is an example of how I handle mine
			$errors = ['csrf' => trans('general.csrf_mismatch')];
			if ($request->expectsJson()){
				return response()->json($errors, 400);
			}
            return redirect()->back()->withErrors($errors);
        }

        //Email SMTP configs error
        if($exception instanceof Swift_SwiftException){
            // Redirect to a form. Here is an example of how I handle mine
			$errors = ['email' => trans('general.verification_email_not_sent')];
			if ($request->expectsJson()){
				return response()->json($errors, 500);
			}
            return redirect()->back()->withErrors($errors);
        }

		//Database query error
		if($exception instanceof  QueryException){
			//show an error and shutdown every things
			//die('<h1 style="text-align:center;">'.trans('general.database_connection_error').'</h1>');
		}

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
