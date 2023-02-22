<?php

namespace App\Http\Controllers;

use App\Events\UserOnline;
use App\Models\Informations;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        
    }

    public function index(){
        return view('dashboard');
    }

    public function loadUsersOnline(){
        $users = User::with('informations')->orderBy('updated_at', 'DESC')->where('online', 1)->get();
        $html = '';
        if($users->count() > 0){
            foreach ($users as $row) {
                $html .= '<div class="__online_users_content">
                                <div class="d-flex align-items-center gap-3">
                                    <img class="img-fluid" src="'.$row->avatar_url.'" alt="'.$row->name.'">
                                    <div class="text-left">
                                        <p class="m-0">'.$row->name.'</p>
                                        <small>'.$row->informations->title.'</small>
                                    </div>
                                </div>
                            <div>
                                <i class="ti-pulse text-success"></i>
                            </div>
                        </div>';
            }
        }else{
            $html .= '<img class="w-50 my-4" src="'.asset('images/dashboard/online-users/no-online-users.png').'" alt="">
            <h4>No users online</h4>';
        }

        return response()->json([
            'online_users' => $html,
        ], 200);
    }
}
