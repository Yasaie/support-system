<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

		/**
		 *
		 * user Auth events
		 *
		 */

		'Illuminate\Auth\Events\Registered' => [
			'App\Listeners\EventListener\Auth\Registered',
		],

		'Illuminate\Auth\Events\Attempting' => [
			'App\Listeners\EventListener\Auth\Attempting',
		],

		'Illuminate\Auth\Events\Authenticated' => [
			'App\Listeners\EventListener\Auth\Authenticated',
		],

		'Illuminate\Auth\Events\Login' => [
			'App\Listeners\EventListener\Auth\SuccessfulLogin',
		],

		'Illuminate\Auth\Events\Failed' => [
			'App\Listeners\EventListener\Auth\FailedLogin',
		],

		'Illuminate\Auth\Events\Logout' => [
			'App\Listeners\EventListener\Auth\Logout',
		],

		'Illuminate\Auth\Events\Lockout' => [
			'App\Listeners\EventListener\Auth\Lockout',
		],

        'App\Events\Auth\ForgotPasswordPin' => [
            'App\Listeners\EventListener\Auth\ForgotPasswordPin',
        ],

        'App\Events\Auth\ForgotPasswordToken' => [
            'App\Listeners\EventListener\Auth\ForgotPasswordToken',
        ],

        'App\Events\Auth\ResetPasswordPin' => [
            'App\Listeners\EventListener\Auth\ResetPasswordPin',
        ],

        'App\Events\Auth\ResetPasswordToken' => [
            'App\Listeners\EventListener\Auth\ResetPasswordToken',
        ],

        'App\Events\Auth\RequestVerifyPin' => [
            'App\Listeners\EventListener\Auth\RequestVerifyPin',
        ],

        'App\Events\Auth\RequestVerifyToken' => [
            'App\Listeners\EventListener\Auth\RequestVerifyToken',
        ],

        'App\Events\Auth\VerifyPin' => [
            'App\Listeners\EventListener\Auth\VerifyPin',
        ],

        'App\Events\Auth\VerifyToken' => [
            'App\Listeners\EventListener\Auth\VerifyToken',
        ],

		/**
		 *
		 * Ticket Events
		 *
		 */
        'App\Events\Ticket\Created' => [
            'App\Listeners\EventListener\Ticket\Created',
        ],

        'App\Events\Ticket\Replied' => [
            'App\Listeners\EventListener\Ticket\Replied',
        ],

        /**
		 * Sms log event
		 */
        'App\Events\Log\Sms' => [
            'App\Listeners\EventListener\Log\Sms',
        ],

    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
    	//
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
