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

    public function showUsers($search){
        if($search == '' || $search == 'undefined'){
            $users = User::with('informations')->where('email', '!=', 'vencer.technodream@gmail.com')->get();
        }else{
            $users = User::with('informations')->where('email', '!=', 'vencer.technodream@gmail.com')->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->get();
        }

        if($users->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row">
                <th>User</th>
                <th>Title</th>
                <th>Department</th>
                <th>Shift Start</th>
                <th>Shift Start</th>
                <th></th>
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
                        <td class="text-capitalize">'.($user->informations ? $user->informations->title : 'No title').'</td>
                        <td class="text-capitalize">'.($user->informations ? $user->informations->department : 'No Department').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_start)) : '--:--').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_end)) : '--:--').'</td>
                        <td>
                        <div class="dropup">
                            <i class="ti-align-right show-options"  data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <li><small><a href="'.route('users.manage', $user->id).'" class="dropdown-item" href="#">Manage User</a></small></li>
                                <li><small><a href="'.route('users.manage', $user->id).'" class="dropdown-item" href="#">Delete User</a></small></li>
                            </ul>
                        </div>
                        </td>
                    </tr>';
            }
            $html .= '</tbody>
            </table>';
        }else{
            $html = 'No Users Found';
        }
        

        return response()->json([
            'data' => $html,
        ], 200);
    }

    public function manageUsers($userID){
        $user = User::with('informations')->findOrFail($userID);

        return view('admin.manage-users', compact('user'));
    }

    public function approveUsers($userID){
        $user = User::findOrFail($userID);
        if(!$user->update(['status' => 1])){
            return back()->with('error', 'Somthing went wrong. Please try agin later');
        }
        return back()->with('success', $user->name . ' approved!');
    }

    public function updateUsers(Request $request, $userID){
        $user = User::findOrFail($userID);
        $validatedData = $request->validate([
            'gender' => 'required|in:Male,Female,other',
            'date_of_birth' => 'required|date',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'title' => 'required|string|max:255|in:Web Developer,Project Manager,Sales,Call Center,Human Resources,SMM,SEO,PULS,WIX',
            'department' => 'required|string|max:255',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i',
            'contact_number' => 'required|numeric|digits_between:10,15',
            'emergency_contact_number' => 'required|numeric|digits_between:10,15',
        ]);

        $information = $user->informations;

        if (!$information->update($validatedData)) {
            return back()->with('error', 'Something went wrong. Information not update, please try again later.');
        }
        return back()->with('success', $user->name . ' Updated!');
    }
}
