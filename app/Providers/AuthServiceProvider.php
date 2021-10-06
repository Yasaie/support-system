<?php

namespace App\Providers;

use App\City;
use App\Config;
use App\Country;
use App\Department;
use App\Faq;
use App\Media;
use App\News;
use App\Notification;
use App\Permission;
use App\Policies\CityPolicy;
use App\Policies\ConfigPolicy;
use App\Policies\CountryPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\FaqPolicy;
use App\Policies\MediaPolicy;
use App\Policies\NewsPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\RolePolicy;
use App\Policies\SmsLogPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use App\Policies\ViewLogPolicy;
use App\Province;
use App\Role;
use App\SmsLog;
use App\Ticket;
use App\User;
use App\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' 		=> 'App\Policies\ModelPolicy',
		City::class 		=> CityPolicy::class,
		Config::class 		=> ConfigPolicy::class,
		Country::class 		=> CountryPolicy::class,
		Department::class 	=> DepartmentPolicy::class,
		Faq::class 			=> FaqPolicy::class,
		Media::class 		=> MediaPolicy::class,
		News::class 		=> NewsPolicy::class,
		Notification::class => NotificationPolicy::class,
		Permission::class 	=> PermissionPolicy::class,
		Province::class 	=> ProvincePolicy::class,
		Role::class 		=> RolePolicy::class,
		SmsLog::class 		=> SmsLogPolicy::class,
		Ticket::class 		=> TicketPolicy::class,
		User::class 		=> UserPolicy::class,
		View::class 		=> ViewLogPolicy::class,

	];
}
