<?php
//
//
//
//
//-------------------------------- Provider for learning purposes ----------------------------------
//
//
//
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider;

class Rap2hpoutreLogProvider extends ServiceProvider
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
       $this->app->register('Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider', function () {
            
            return new LaravelLogViewerServiceProvider();
        
        });
    }
}
