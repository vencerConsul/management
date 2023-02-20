<?php

namespace App\Http\Controllers;

use App\Models\Informations;
use App\Models\User;
use Illuminate\Http\Request;

class HandleTimeSheetController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        return view('admin.timesheet-log');
    }

    public function loadTimeSheet(Request $request, User $usersResult){
        $input = $request->search_input;
        $search = $usersResult->newQuery();
        $search->where(function($query) use($input) {
            $query->with('timesheets')->where('name', 'like', "%{$input}%")->orWhere('email', 'like', "%{$input}%");
        });
        $users = $search->where('email', '!=', 'vencer.technodream@gmail.com')->where('status', '!=', 'archived')->orderBy('updated_at', 'DESC')->paginate(7);
        if($users->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row-head" data-aos="fade-up" data-aos-delay="100">
                <th>Name / Email</th>
                <th>Time In</th>
                <th>Time out</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>';

            $delay = 1;
            foreach ($users as $user) {
                $delay++;
                $html .= '
                    <tr class="t-row" data-aos="fade-up" data-aos-delay="'.$delay.'00">
                        <td class="d-flex align-items-center gap-3">
                            <img src="'.$user->avatar_url.'" alt="image"/>
                            <p>'.$user->name.'</p>
                        </td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_start)) : '--:--').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_end)) : '--:--').'</td>
                        <td class="text-capitalize">
                            <p>'.($user->informations ? date('F j, Y', strtotime($user->updated_at)) : '--:--').'</p>
                            <small class="text-capitalize">'.($user->informations ? $user->updated_at->diffForHumans() : '--:--').'</small>
                        </td>
                        <td>
                        <div class="dropup">
                            <a href="'.route('users.manage', $user->id).'"><i class="ti-angle-double-right show-options"></i></a>
                        </div>
                        </td>
                    </tr>';
            }
            $html .= '</tbody>
            </table>';
        }else{
            $html = '<div class="v-100 text-center">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" src="'.asset('/images/logo.png').'" alt="logo">
                    <h3 class="font-weight-normal mt-4">No User found</h3>
                    <p>I\'m sorry, but the specified user could not be found.</p>
                    <p>Please provide additional details or clarify your request for further assistance.</p>
                </div>
            </div>
        </div>';
        }

        return response()->json([
            'table' => $html,
            'pagination' => $users
        ], 200);
    }
}
