<?php

namespace App\Http\Controllers;

use App\Models\Informations;
use App\Models\TimeSheet;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleTimeSheetController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        return view('admin.timesheet-log');
    }

    


}
