<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use App\Traits\QRCodeTrait;

class Authentication extends Controller
{
    // use QRCodeTrait;
    // Google login
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->user();
        if($this->_registerOrLoginUser($user)){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('landing')->with('info', 'Only Employee can access this website.');
        }
    }

    // create user or login 
    protected function _registerOrLoginUser($data){
        if (preg_match("/\btechnodream\b/i", $data->email) || preg_match("/\besilverconnect\b/i", $data->email)) {
            $user = User::where('email', '=', $data->email)->first();
            if($data->email === 'vencer.technodream@gmail.com'){
                $role = 1;
                $position = 'Fullstack Web Developer';
            }else{
                $role = 0;
                $position = 'Employee';
            }
            if(!$user){
                $user = new User();
                $user->name = $data->name;
                $user->email = $data->email;
                $user->provider_id = $data->id;
                $user->avatar_url = $data->avatar;
                $user->role = $role;
                $user->position = $position;
                $user->password = Hash::make($data->email);
                $user->save();
                QrCode::format('png')->merge('td-logo.png', .3, true)->style('round')->eye('circle')->color(41, 79, 179)->size(300)->generate(''.$data->id.'', public_path('images/qrcodes/'.$data->name.'.png'));
            }
            Auth::login($user);
            return true;
        }else{
            return false;
        }
    }
}
