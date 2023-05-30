<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Schema;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     */

    public function boot()
    {
   //     Schema::defaultStringLength(191);
       // \URL::forceScheme('https');

        RateLimiter::for('email', function ($job) {
            return Limit::perDay(30);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
      //  header('Access-Control-Allow-Origin: *');
//
//        if($this->app->isLocal()) {
//            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
//            $this->app->register(\GuzzleHttp\Profiling\Debugbar\Support\Laravel\ServiceProvider::class);
//        }
    }



}
