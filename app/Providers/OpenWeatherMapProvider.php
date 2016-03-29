<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cmfcmf\OpenWeatherMap;

/**
* Open Weather Map Service Provider
*/
class OpenWeatherMapProvider extends ServiceProvider
{
	 /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
    
	/**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {   
       $this->app->register('Cmfcmf\OpenWeatherMap', function () {
            
            return new OpenWeatherMap();
        
        });
    }
}