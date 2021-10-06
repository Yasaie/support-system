<?php
namespace App\Helper\Captcha\Providers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Helper\Captcha\Core\Captcha;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerValidator();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('captcha', function (Application $app) {
            $config = $app['config']['captcha'];
            $storage   = $app->make($config['storage']);
            $generator = $app->make($config['generator']);
            $code      = $app->make($config['code']);
            return new Captcha($code, $storage, $generator, $config);
        });
    }

    /**
     * Register captcha routes.
     */
    protected function registerRoutes()
    {
        $this->app['router']->group([
            'middleware' => config('captcha.middleware', 'web'),
            'namespace'  => '\App\Helper\Captcha',
            'as'         => 'captcha'
        ], function ($router) {
            $router->get(config('captcha.routes.image'), 'CaptchaController@image');
        });
    }

    /**
     * Register captcha validator.
     */
    protected function registerValidator()
    {
        Validator::extend(config('captcha.validator'), function ($attribute, $value, $parameters, $validator) {
            return $this->app['captcha']->validate($value);
        }, trans('general.captcha_incorrect'));
    }
}