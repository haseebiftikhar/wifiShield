<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

/**
* GuzzleHttp Service Provider
*/
class GuzzleServiceProvider extends ServiceProvider
{
	
	public function boot()
	{
		# code...
	}

	public function register()
	{
		$this->app->singleton('GuzzleHttp\Client', function ($app) {
            
            $guzzle = new Client();
            $guzzle->setDefaultOption('verify', false);
            return $guzzle;
        });
	}
}