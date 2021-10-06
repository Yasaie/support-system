<?php

namespace App\Providers;

use App\Http\Controllers\Config\setAppConfig;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('Asia/Tehran');

        //set Configs
		setAppConfig::setAll();

        //blade for user's info:
		Blade::directive('user',function($expression){
			$expression=trim($expression,'\'\"');
			return '<?php echo htmlentities( Auth::user()->'.$expression.' ); ?>';
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
