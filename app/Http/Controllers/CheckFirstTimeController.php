<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFirstTimeController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function checkFirstTime(Request $request){
        $user = Auth::user();

        if (!$user->informations) {
            return redirect()->route('information.create');
        }

        return redirect()->route('dashboard');
    }

    public function createinformation(){
        return view('information.create');
    }
}
