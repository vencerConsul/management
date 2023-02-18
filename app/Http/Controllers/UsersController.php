<?php

namespace App\Http\Controllers;

use App\Models\Informations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'is_admin']);
    }

    public function unlinkNotExistFiles(){
        $like = scandir('images/qrcodes');
        foreach ($like as $thisFile) {
            $rs = User::where('qrcode', $thisFile)->first();
            if (!$rs) {
                if($thisFile != "." && $thisFile != ".."){
                    unlink('images/qrcodes/'.$thisFile);
                }
            }
        }
    }

    // MANAGE USER CONTROLLERS 
    public function users(){
        return view('admin.users');
    }

    public function showUsers(Request $request, User $usersResult){
        $input = $request->search_input;
        $search = $usersResult->newQuery();
        $search->where(function($query) use($input) {
            $query->with('informations')->where('name', 'like', "%{$input}%")->orWhere('email', 'like', "%{$input}%");
        });
        $users = $search->where('email', '!=', 'vencer.technodream@gmail.com')->where('status', '!=', 'archived')->orderBy('updated_at', 'DESC')->paginate(7);
        // dd($users);
        if($users->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row-head" data-aos="fade-up" data-aos-delay="100">
                <th>Name / Email</th>
                <th>Title</th>
                <th>Department</th>
                <th>Shift Start</th>
                <th>Shift Start</th>
                <th>Status</th>
                <th>Last Modified</th>
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
                            <div>
                            <p>'.$user->name.'</p>
                            <p style="color: #1376da;">'.$user->email.'</p>
                            </div>
                        </td>
                        <td class="text-capitalize">'.($user->informations ? $user->informations->title : 'No title').'</td>
                        <td class="text-capitalize">'.($user->informations ? $user->informations->department : 'No Department').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_start)) : '--:--').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_end)) : '--:--').'</td>
                        <td class="text-capitalize">';
                        if($user->status == 'pending'){
                            $html .= '<span class="badge bg-warning">'.$user->status.'</span>';
                        }elseif ($user->status == 'approved') {
                            $html .= '<span class="badge bg-success">'.$user->status.'</span>';
                        }
                        $html .= '</td>
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

    public function manageUsers($userID){
        $user = User::where('status', '!=', 'archived')->with('informations')->findOrFail($userID);

        return view('admin.manage-users', compact('user'));
    }

    public function assignUserRoles(Request $request, $userID){
        $user = User::findOrFail($userID);
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        switch ($request->role) {
            case 'user':
                $role = 0;
            break;
            case 'admin':
                $role = 1;
            break;
        }

        $update = $user->update(['role' => $role]);
        if(!$update){
            return back()->with('error', 'Somthing went wrong. Please try agin later');
        }
        return back()->with('success', $user->name . ' Set to ' . $request->role);
    }

    public function updateUserStatus(Request $request, $userID){
        $user = User::findOrFail($userID);
        if($user->status == 'pending'){
            $update = $user->update(['status' => 'approved']);
            if(!$update){
                return back()->with('error', 'Somthing went wrong. Please try agin later');
            }
            return back()->with('success', $user->name . ' approved!!');
        }else{
            $update = $user->update(['status' => 'pending']);
            if(!$update){
                return back()->with('error', 'Somthing went wrong. Please try agin later');
            }
            return back()->with('success', $user->name . ' Set to pending..');
        }
        
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

        if($user->informations){
            $information = $user->informations;

            if (!$information->update($validatedData)) {
                return back()->with('error', 'Something went wrong. Information not update, please try again later.');
            }
            return back()->with('success', $user->name . ' Updated!');
        }else{
            $userInformation = new Informations($validatedData);

            if (!$user->informations()->save($userInformation)) {
                return back()->with('error', 'Something went wrong. Information not save, please try again later.');
            }
            return back()->with('success', 'Your Information saved.');
        }
        
    }
    // ARCHIVE CONTROLLERS
    public function archive(){
        return view('admin.archive-users');
    }

    public function showUsersArchive(Request $request, User $usersResult){
        $input = $request->search_input;
        $search = $usersResult->newQuery();
        $search->where(function($query) use($input) {
            $query->with('informations')->where('name', 'like', "%{$input}%")->orWhere('email', 'like', "%{$input}%");
        });
        $users = $search->where('status', 'archived')->orderBy('updated_at', 'DESC')->paginate(7);
        // dd($users);
        if($users->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row-head" data-aos="fade-up" data-aos-delay="100">
                <th>Name / Email</th>
                <th>Title</th>
                <th>Department</th>
                <th>Shift Start</th>
                <th>Shift Start</th>
                <th>Status</th>
                <th>Last Modified</th>
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
                            <div>
                            <p>'.$user->name.'</p>
                            <p style="color: #1376da;">'.$user->email.'</p>
                            </div>
                        </td>
                        <td class="text-capitalize">'.($user->informations ? $user->informations->title : 'No title').'</td>
                        <td class="text-capitalize">'.($user->informations ? $user->informations->department : 'No Department').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_start)) : '--:--').'</td>
                        <td class="text-uppercase">'.($user->informations ? date('h:i a', strtotime($user->informations->shift_end)) : '--:--').'</td>
                        <td class="text-capitalize"><span class="badge bg-info">'.$user->status.'</span></td>
                        <td class="text-capitalize">
                            <p>'.($user->informations ? date('F j, Y', strtotime($user->updated_at)) : '--:--').'</p>
                            <small class="text-capitalize">'.($user->informations ? $user->updated_at->diffForHumans() : '--:--').'</small>
                        </td>
                        <td>
                        <div>
                            <form action="'.route('users.unarchive', $user->id).'" method="POST">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <button type="submit" class="btn btn-sm btn-success"><i class="ti-back-left"></i> Unarchive</button>
                            </form>
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

    public function unarchiveUsers(Request $request, $userID){
        $user = User::where('id', $userID)->first();
        if(!$user){
            return back()->with('error', 'No record found.');
        }
        $user->update(['status' => 'approved']);
        return redirect(route('users'))->with('success', $user->name .' has successfully restored from its archived state.');
    }
    // DANGER CONTROLLERS
    public function archiveUsers(Request $request, $userID){
        $user = User::where('email', $request->email_confirmation)->where('id', $userID)->first();
        if(!$user){
            return back()->with('error', 'No record found with this email.');
        }
        $user->update(['status' => 'archived']);
        return redirect(route('users'))->with('success', $request->email_confirmation .' moved to archived.');
    }

    public function deleteUsers(Request $request, $userID){
        $user = User::where('email', $request->email_confirmation)->where('id', $userID)->first();
        if(!$user){
            return back()->with('error', 'No record found with this email.');
        }
        $user->delete();
        $this->unlinkNotExistFiles();
        return redirect(route('users'))->with('success', $request->email_confirmation .' is no longer available or has been permanently removed.');
    }
}
