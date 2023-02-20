<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Informations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
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
        $user = Auth::user();

        if ($user->informations) {
            $information = $user->informations;
        }else{
            $information = NULL;
        }
        return view('information.information', compact('information'));
    }

    public function storeInformation(Request $request)
    {
        
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

        $user = Auth::user();

        $information = new Informations($validatedData);

        if (!$user->informations()->save($information)) {
            return back()->with('error', 'Something went wrong. Information not save, please try again later.');
        }
        return redirect(route('dashboard'))->with('success', 'Your Information saved.');
    }

    public function updateInformation(Request $request)
    {
        $validatedData = $request->validate([
            'gender' => 'required|in:Male,Female,other',
            'date_of_birth' => 'required|date',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i',
            'contact_number' => 'required|numeric|digits_between:10,15',
            'emergency_contact_number' => 'required|numeric|digits_between:10,15',
        ]);

        $user = Auth::user();
        $information = $user->informations;
        if($user->role == 1){
            if (!$information->update($validatedData)) {
                return back()->with('error', 'Something went wrong. Information not update, please try again later.');
            }
            return back()->with('success', 'Your Information updated.');
        }else{
            return back()->with('warning', 'To update your information, please approach an administrator as only they have the authority to make changes.');
        }
    }
}
