<?php

namespace App\Providers;

use Dotenv\Validator;
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
//        \View::share('channels', \App\Channel::all());

        \View::composer('*', function ($view) {
            $channels = \Cache::remember('channel', 5, function () {
                return \App\Channel::all();
            });
            $view->with('channels', $channels);
//            $view->with('channels', \App\Channel::all());
        });

//        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
