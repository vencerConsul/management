<?php

namespace App\Http\Controllers;

use App\Models\TimeSheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSheetController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('timesheet');
    }

    public function loadTimeSheetData(){
        $timesheetsLoop = TimeSheet::where('user_id', Auth::id())->where('date', date('Y-m-d'))->orderBy('updated_at', 'DESC')->paginate(7);
        
        $totalBreak = 0;
        $toggle = '';
        if($timesheetsLoop->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row-head" data-aos="fade-up" data-aos-delay="100">
                <th>Time Out</th>
                <th>Time In</th>
                <th>Total Time</th>
                <th></th>
            </tr>
            </thead>
            <tbody>';

            $delay = 1;
            foreach ($timesheetsLoop as $timesheetRow) {
                $totalBreak = (int)$totalBreak + (int)$timesheetRow->total_time_consume;
                $toggle = $timesheetRow->toggle;
                $delay++;
                $html .= '
                    <tr class="t-row" data-aos="fade-up" data-aos-delay="'.$delay.'00">
                        <td class="text-uppercase">'.date('h:i a', strtotime($timesheetRow->time_out)).'</td>
                        <td class="text-uppercase">'.(empty($timesheetRow->time_in) ? '--:--' : date('h:i a', strtotime($timesheetRow->time_in))).'</td>
                        <td class="text-capitalize">';
                        if($timesheetRow->total_time_consume){
                $html .= '<p>'.($timesheetRow->total_time_consume < 60 ? $timesheetRow->total_time_consume . 'sec' : $timesheetRow->total_time_consume . 'min').'</p>';
                        }
                $html .= '</td>
                        <td>
                    </tr>';
            }
            $html .= '</tbody>
            </table>';
        }else{
            $html = '<div class="v-100 text-center" data-aos="fade-up" data-aos-delay="400">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" src="'.asset('/images/timesheet/no-timesheet.jpg').'" alt="No time sheet">
                    <h3 class="font-weight-normal mt-4">Start a break</h3>
                    <p>Give yourself permission to rest, it\'s okay to take a break.</p>
                    <p>Recharge your batteries, and come back stronger</p>
                </div>
            </div>
        </div>';
        }

        if($totalBreak >= 60){
            $timeType = 'Minute'. ($totalBreak >= 120 ? 's' : '');
        }elseif($totalBreak >= 3600){
            $timeType = 'Hour'. ($totalBreak >= 7200 ? 's' : '');
        }else{
            $timeType = 'Sec'. ($totalBreak >= 2 ? 's' : '');
        }

        return response()->json([
            'table' => $html,
            'breakData' => array(
                'totalBreak' => $totalBreak,
                'timeType' => $timeType,
                'toggle' => $toggle
            ),
            'pagination' => $timesheetsLoop
        ], 200);
    }


    public function toggleTimeSheet(Request $request){
        $user = User::findOrFail(Auth::id());
        $regex = '/^\d{4}-\d{1,2}-\d{1,2}\s\d{1,2}:\d{1,2}:\d{1,2}$/';
        $dateTime = $request->dateTime;

        if (!preg_match($regex, $dateTime)) {
            return response()->json([
                'message' => 'Time In'
            ], 422);
        } 
        
        $timeSheetQuery = TimeSheet::where('user_id', $user->id)
                                    ->whereDate('date', '=', date('Y-m-d'))
                                    ->where('time_out', '!=', '')
                                    ->first();
        // dif the user has no time out and time in {insert to database with time_out data}
        if (!$timeSheetQuery) {
            $newTimeSheet = new TimeSheet();
            $newTimeSheet->user_id = $user->id;
            $newTimeSheet->date = date('Y-m-d');
            $newTimeSheet->toggle = 'Break In';
            $newTimeSheet->time_out = $dateTime;
            $newTimeSheet->save();
            return response()->json([
                'message' => 'Time Out'
            ], 200);
        } else { // else update the current user who time out and set the time in

            if(!$timeSheetQuery->time_in){
                $timeIn = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($dateTime)));
                $timeOut = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($timeSheetQuery->time_out)));

                $totalTimeConsumeInSeconds = $timeOut->diffInSeconds($timeIn);
                $timeSheetQuery->update([
                    'time_in' => $dateTime,
                    'toggle' => 'Break Out',
                    'total_time_consume' => $totalTimeConsumeInSeconds
                ]);
                return response()->json([
                    'message' => 'Time In'
                ], 200);
            }
            
        }
    }
}
