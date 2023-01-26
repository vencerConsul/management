<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!App::environment(['local', 'staging'])) {
            $this->app['request']->server->set('HTTPS', true);
            URL::forceScheme('https');
        }
        
        if (!app()->environment(['local', 'staging'])) {
            $this->app['request']->server->set('HTTPS', true);
            URL::forceScheme('https');
        }
    }
}
