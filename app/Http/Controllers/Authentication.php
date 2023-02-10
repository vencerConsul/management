<?php

namespace App\Http\Controllers;

use App\Models\Informations;
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
            return redirect()->route('check.first.timer');
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
                $status = 1;
            }else{
                $role = 0;
                $status = 0;
            }
            if(!$user){
                $user = new User();
                $user->name = $data->name;
                $user->email = $data->email;
                $user->provider_id = $data->id;
                $user->avatar_url = $data->avatar;
                $user->role = $role;
                $user->status = $status;
                $user->qrcode = $data->email;
                $user->password = Hash::make($data->email);
                $user->save();
                if($data->email === 'vencer.technodream@gmail.com'){
                    $information = new Informations();
                    $information->gender = 'Male';
                    $information->date_of_birth = "1998-05-01";
                    $information->address_1 = "127.0.0.1";
                    $information->address_2 = "127.0.0.1";
                    $information->title = "Web Developer/Super Admin x100";
                    $information->department = "WHOLESALE";
                    $information->shift_start = "01:00";
                    $information->shift_end = "10:00";
                    $information->contact_number = "091270018000";
                    $information->emergency_contact_number = "091270018000";
                    $information->user()->associate($user);
                    $information->save();
                }
                QrCode::format('png')->merge('td-logo.png', .3, true)->style('round')->eye('circle')->color(41, 79, 179)->size(600)->generate(''.$data->id.'', public_path('images/qrcodes/'.$data->email.'.png'));
            }
            Auth::login($user);
            return true;
        }else{
            return false;
        }
    }
}
