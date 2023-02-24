<?php

namespace App\Providers;

use App\Events\UserOnline;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Broadcast;

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
