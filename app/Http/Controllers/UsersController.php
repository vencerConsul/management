<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'is_admin']);
    }

    public function users(){

        $titles = User::with('informations')->get()->pluck('informations.title')->unique();
        $users = User::with('informations')->get();

        return view('admin.users', compact('titles', 'users'));
    }

}
