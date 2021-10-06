<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main page
Route::get('/','MainController@index')->name('main');

// Authentication Routes...
## login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
## logout
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout','Auth\LoginController@logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//shows a form for requesting both token and pin in order to reset password
Route::get('password/request','Auth\ForgotPasswordController@showRequestForm')->name('password.request');

// Password Reset with PIN number
## send reset password's PIN (sends by SMS message)
Route::get('password/request/pin', 'Auth\ForgotPasswordController@showPinRequestForm')->name('password.request.pin');
Route::post('password/request/pin', 'Auth\ForgotPasswordController@sendResetPin');
## reset password using PIN
Route::get('password/reset/pin', 'Auth\ResetPasswordController@showResetFormPin')->name('password.reset.pin');
Route::post('password/reset/pin', 'Auth\ResetPasswordController@resetWithPin');

// Password Reset with Token string
## send reset password's Token (sends by E-mail message)
Route::get('password/request/token', 'Auth\ForgotPasswordController@showTokenRequestForm')->name('password.request.token');
Route::post('password/request/token', 'Auth\ForgotPasswordController@sendResetToken');
## reset password using Token
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetFormToken')->name('password.reset.token');
Route::post('password/reset', 'Auth\ResetPasswordController@resetWithToken')->name('password.reset');

// Auth verification with PIN number
## send mobile PIN verification message (by SMS)
Route::get('verify/request/pin','Auth\VerifyController@showRequestPinForm')->name('verify.request.pin');
Route::post('verify/request/pin','Auth\VerifyController@sendPin');
## verifying mobile number
Route::get('verify/pin','Auth\VerifyController@showVerifyPinForm')->name('verify.pin');
Route::post('verify/pin','Auth\VerifyController@verifyWithPin');

// Auth verification with Token string
## send email Token verification message (by E-Mail)
Route::get('verify/request/token','Auth\VerifyController@showRequestTokenForm')->name('verify.request.token');
Route::post('verify/request/token','Auth\VerifyController@sendToken');
## verifying E-Mail address
Route::get('verify/{token}','Auth\VerifyController@showVerifyTokenForm')->name('verify.token');
Route::post('verify','Auth\VerifyController@verifyWithToken')->name('verify');

// Media
Route::any('media/show/{id}/{name?}','Media\MediaController@showAsInline')->name('media.inline');
Route::any('media/download/{id}/{name?}','Media\MediaController@showAsAttachment')->name('media.attachment');
Route::any('media/resize/{id}/{width?}/{height?}','Media\MediaController@resizeOnAir')->name('media.resize');

// Faq
Route::get('faq','Faq\FaqController@landing')->name('faq.landing');

// News
Route::get('news','News\NewsController@landing')->name('news.landing');

// ticket
##guest ticket
Route::any('ticket/guest/redirect','Ticket\TicketController@redirectGuest')->name('ticket.guest.redirect');
Route::get('ticket/guest/{access_key}','Ticket\TicketController@showGuest')->name('ticket.guest.show');
Route::post('ticket/guest','Ticket\TicketController@storeGuest')->name('ticket.guest.store');
Route::post('ticket/guest/{access_key}/reply','Ticket\TicketController@replyGuest')->name('ticket.guest.reply');
Route::get('ticket/{access_key}/close','Ticket\TicketController@closeGuest')->name('ticket.guest.close');

//country
Route::any('country/list','Country\CountryController@getList')->name('country.list');

// province
Route::any('province/list','Province\ProvinceController@getList')->name('province.list');

// city
Route::any('city/list','City\CityController@getList')->name('city.list');

//department
Route::any('department/list','Department\DepartmentController@getList')->name('department.list');

//user
Route::any('user/list','User\UserController@getList')->name('user.list');

//rating
Route::any('rate/store','Rate\RateController@store')->name('rate.store');

// Panel routes
Route::prefix('panel')->group(function () {

	// Panel's main page
	Route::get('/', 'PanelController@index')->name('panel');

	// Logout (alias)
	Route::post('logout', 'Auth\LoginController@logout');
	Route::get('logout','Auth\LoginController@logout');

	// Configs:
	## general configs
	Route::get('config/general','Config\ConfigController@generalConfigs')->name('config.general');
	Route::patch('config/general','Config\ConfigController@updateGeneralConfigs')->name('config.general.update');
	## email configs
	Route::get('config/email','Config\ConfigController@emailConfigs')->name('config.email');
	Route::patch('config/email','Config\ConfigController@updateEmailConfigs')->name('config.email.update');
	## ticket configs
	Route::get('config/ticket','Config\ConfigController@ticketConfigs')->name('config.ticket');
	Route::patch('config/ticket','Config\ConfigController@updateTicketConfigs')->name('config.ticket.update');
	## sms configs
	Route::get('config/sms','Config\ConfigController@smsConfigs')->name('config.sms');
	Route::patch('config/sms','Config\ConfigController@updateSmsConfigs')->name('config.sms.update');
	## template configs
	Route::get('config/template','Config\ConfigController@templateConfigs')->name('config.template');
	Route::patch('config/template','Config\ConfigController@updateTemplateConfigs')->name('config.template.update');

	// Faq
	Route::resource('faq','Faq\FaqController');

	// News
	Route::resource('news','News\NewsController');

	// User
	Route::get('user/garbage','User\UserController@garbage')->name('user.garbage');
	Route::get('user/garbage/recycle/{id}','User\UserController@recycle')->name('user.recycle');
	Route::delete('user/garbage/{id}','User\UserController@permanentDestroy')->name('user.permanentDestroy');

	Route::resource('user','User\UserController');

	// Country
	Route::resource('country','Country\CountryController');

	//province
	Route::resource('province','Province\ProvinceController');

	//city
	Route::resource('city','City\CityController');

	//notification system
	Route::get('notification/garbage','Notification\NotificationController@garbage')->name('notification.garbage');
	Route::get('notification/garbage/recycle/{id}','Notification\NotificationController@recycle')->name('notification.recycle');
	Route::delete('notification/garbage/{id}','Notification\NotificationController@permanentDestroy')->name('notification.permanentDestroy');

	Route::get('notification/inbox','Notification\NotificationController@inbox')->name('notification.inbox');
	Route::resource('notification','Notification\NotificationController');

	//ticket system
	Route::get('ticket/garbage','Ticket\TicketController@garbage')->name('ticket.garbage');
	Route::get('ticket/garbage/recycle/{id}','Ticket\TicketController@recycle')->name('ticket.recycle');
	Route::delete('ticket/garbage/{id}','Ticket\TicketController@permanentDestroy')->name('ticket.permanentDestroy');

	Route::resource('ticket','Ticket\TicketController');
	Route::post('ticket/{id}/reply','Ticket\TicketController@reply')->name('ticket.reply');
	Route::get('ticket/{id}/close','Ticket\TicketController@close')->name('ticket.close');
	Route::any('ticket/{id}/department/update','Ticket\TicketController@departmentUpdate')->name('ticket.department.update');

	//department's staff
	Route::get('department/staff/garbage','Department\StaffController@garbage')->name('staff.garbage');
	Route::get('department/staff/garbage/recycle/{id}','Department\StaffController@recycle')->name('staff.recycle');
	Route::delete('department/staff/garbage/{id}','Department\StaffController@permanentDestroy')->name('staff.permanentDestroy');

	Route::resource('department/staff','Department\StaffController');

	//ticket's department
	Route::resource('department','Department\DepartmentController');

	//media
	Route::post('media/storeChunk','Media\MediaController@storeChunk')->name('media.storeChunk');
	Route::resource('media','Media\MediaController');

	//post
	Route::resource('post','Post\PostController');

	//permission
	Route::resource('permission','Permission\PermissionController');

	//role
	Route::resource('role','Role\RoleController');

	//sms log
	Route::get('log/sms','SmsLog\SmsLogController@index')->name('log.sms.index');

	//view log
	Route::get('log/view','ViewLog\ViewLogController@index')->name('log.view.index');
	Route::get('log/view/map','ViewLog\ViewLogController@map')->name('log.view.map');

});