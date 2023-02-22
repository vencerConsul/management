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


        
        // if (Auth::check()) {
        //     $userId = Auth::id();
            
        //     dd($userId);
        //     // Check if the user is currently subscribed to the channel
        //     if (Broadcast::hasChannel('user.'.$userId)) {
        //         // Log::info('User '.$userId.' is subscribed to the channel.');
        //         // event(new UserOnline($userData));
        //         dd($userId);

        //         // Listen for the "unsubscribe" event
        //         Broadcast::channel('user.'.$userId, function ($user, $socket) use ($userId) {
        //             if ($user->id == $userId) {
        //                 $userData = User::find($userId);
        //                 dd($userData);
        //                 event(new UserOnline($userData));
        //             }
        //         });
        //     } else {
        //         // event(new UserOnline($userData));
        //         dd($userId);
        //         // Listen for the "subscribe" event
        //         Broadcast::channel('user.'.$userId, function ($user, $socket) use ($userId) {
        //             if ($user->id == $userId) {
        //                 $userData = User::find($userId);
        //                 event(new UserOnline($userData));
        //                 dd($userData);
        //             }
        //         });
        //     }
        // }
        
    }
}
