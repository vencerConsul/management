<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class Authentication extends Controller
{
    // Google login
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);
        if(Auth::user()->role == 1){
            return redirect()->route('dashboard');
        }elseif(Auth::user()->role == 0){
            return redirect()->route('home');
        }
    }

    // create user or login 
    protected function _registerOrLoginUser($data){
        $user = User::where('email', '=', $data->email)->first();
        if($data->email === 'o.lermovenz@gmail.com' || $data->email === 'val418848@gmail.com'){
            $role = 1;
            $position = 'Developer';
        }elseif($data->email === 'vencer1.technodream@gmail.com'){
            $role = 1;
            $position = 'Project Manager';
        }else{
            $role = 0;
            $position = 'Customer';
        }
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar_url = $data->avatar;
            $user->role = $role;
            $user->position = $position;
            $user->save();
        }
        Auth::login($user);
    }
}
