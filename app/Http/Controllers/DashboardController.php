<?php

namespace App\Http\Controllers;

use App\Events\UserOnline;
use App\Models\Informations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        
    }

    public function index(){
        $usersByDepartment = User::with('informations')
                                ->selectRaw('informations.department, count(*) as count')
                                ->join('informations', 'users.id', '=', 'informations.user_id')
                                ->groupBy('informations.department')
                                ->paginate(7);

        return view('dashboard', compact(['usersByDepartment']));
    }

    public function loadUsersOnline(){
        $users = User::with('informations')->orderBy('online', 'DESC')->get();
        
        $html = '';
        if($users->count() > 0){
            foreach ($users as $row) {
                $html .= '<div class="__online_users_content">
                                <div class="d-flex align-items-center gap-3">
                                    <a '.(Auth::user()->role == 1 ? 'href="'.route('users.manage', $row->id).'"' : '').'><img class="'.($row->online ? 'online' : '').'" src="'.$row->avatar_url.'" alt="'.$row->name.'"></a>
                                    <div class="text-left">
                                        <p class="m-0">'.$row->name.'</p>
                                        <small>'.$row->informations->title.'</small>
                                    </div>
                                </div>
                            <div class="d-flex align-items-center gap-2">';
                                if($row->online){
                                    $html .= '<small>Alive</small>
                                    <i class="ti-pulse text-success"></i>';
                                }else{
                                    $html .= '<small>Dead</small>
                                    <i class="ti-pulse text-secondary"></i>';
                                }
                    $html .='</div>
                        </div>';
            }
        }else{
            $html .= '<img class="w-50 my-4" src="'.asset('images/dashboard/online-users/no-online-users.png').'" alt="">
            <h4>No users online</h4>';
        }

        return response()->json([
            'online_users' => $html,
            'all_users' => $users->count()
        ], 200);
    }
}
