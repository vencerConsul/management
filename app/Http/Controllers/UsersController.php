<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function users()
    {
        return view('admin.users');
    }

    public function showUsers(){
        $users = User::with('informations')->get();

        $html = '<table class="table">
        <thead>
        <tr class="t-row">
            <th>User</th>
            <th>First name</th>
            <th>Progress
            </th>
            <th>Amount</th>
            <th>Deadline</th>
        </tr>
        </thead>
        <tbody>';
        
        foreach ($users as $user) {
            $html .= '
                <tr class="t-row">
                    <td class="d-flex align-items-center gap-2">
                        <img src="'.$user->avatar_url.'" alt="image"/>
                        <div>
                        <p>'.$user->name.'</p>
                        <p>'.$user->email.'</p>
                        </div>
                    </td>
                    <td>'.$user->name.'</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td>$ 77.99</td>
                    <td>May 15, 2015</td>
                </tr>';
        }
        $html .= '</tbody>
        </table>';

        return response()->json([
            'data' => $html,
        ], 200);
    }
}
