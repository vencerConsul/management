<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandleAttendanceController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        return view('admin.attendance-log');
    }
}
