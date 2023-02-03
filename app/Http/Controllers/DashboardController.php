<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        
    }

    public function checkFirstTime(Request $request){
        $user = Auth::user();

        if (!$user->informations) {
            return redirect()->route('information.create');
        }

        return redirect()->route('dashboard');
    }

    public function index(){
        return view('dashboard');
    }
}
