<?php

namespace App\Http\Controllers;

use App\Models\Informations;
use App\Models\TimeSheet;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSheetController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }

    public function index(){
        return view('timesheet');
    }
    
    public function loadTimeSheetData(){
        $checkUserShift = Informations::where('user_id', Auth::id())->first();
        $start_time = new DateTime(date('H:i', strtotime($checkUserShift->shift_start  . '+1 hour')));
        $timesheetsLoop = TimeSheet::where('user_id', Auth::id())->where('date', date('Y-m-d'))->orderBy('updated_at', 'DESC')->paginate(7);
        
        $totalSeconds = 0;
        if($timesheetsLoop->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row-head" data-aos="fade-up" data-aos-delay="100">
                <th>Time Out</th>
                <th>Time In</th>
                <th>Time Consume</th>
                <th></th>
            </tr>
            </thead>
            <tbody>';

            $delay = 1;
            foreach ($timesheetsLoop as $timesheetRow) {
                $totalSeconds = (int)$totalSeconds + (int)$timesheetRow->total_time_consume;
                $delay++;
                $html .= '
                    <tr class="t-row" data-aos="fade-up" data-aos-delay="'.$delay.'00">
                        <td class="text-uppercase">'.date('h:i a', strtotime($timesheetRow->time_out)).'</td>
                        <td class="text-uppercase">'.(empty($timesheetRow->time_in) ? '--:--' : date('h:i a', strtotime($timesheetRow->time_in))).'</td>
                        <td class="text-capitalize">';
                        if($timesheetRow->total_time_consume){
                            $calculatedTime = $this->convertSeconds($timesheetRow->total_time_consume);
                $html .= '<p>'.$calculatedTime['overBreakTime'].' </p>';
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

        $totalBreak = $this->convertSeconds($totalSeconds);
        $timeLog = auth()->user()->timesheet()->latest()->first();
        $toggle = (empty($timeLog->toggle) ? 'Break Out' : $timeLog->toggle);
        return response()->json([
            'table' => $html,
            'breakData' => array(
                'totalBreak' => $totalBreak['break'],
                'timeType' => $totalBreak['type'],
                'remaining' => $totalBreak['remaining'],
                'obType' => $totalBreak['obType'],
                'seconds' => $totalBreak['seconds'],
                'toggle' => $this->userCanBreak() ? $toggle : 'Refresh at ' . $start_time->format('h:i A')
            ),
            'pagination' => $timesheetsLoop
        ], 200);
    }

    public function toggleTimeSheet(Request $request){
        $user = User::findOrFail(Auth::id());
        $dateTime = date('Y-n-j H:i:s');

        if (!$request->_token == csrf_token() || !$this->userCanBreak()) {
            return response()->json([
                'message' => 'Unable to perform any actions.'
            ], 422);
        } 
        $timeLog = auth()->user()->timesheet()->latest()->first();

        if (!$timeLog) {
            $newTimeSheet = new TimeSheet();
            $newTimeSheet->user_id = $user->id;
            $newTimeSheet->date = date('Y-m-d');
            $newTimeSheet->toggle = 'Break In';
            $newTimeSheet->time_out = $dateTime;
            $newTimeSheet->save();
            return response()->json([
                'message' => 'Time Out'
            ], 200);
        } else { 

            $latestTimeIn = auth()->user()->timesheet()->latest()->first();
            if ($latestTimeIn && !$latestTimeIn->time_in) {
                $timeOut = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($latestTimeIn->time_out)));
                $timeIn = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($dateTime)));

                $totalTimeConsumeInSeconds = $timeOut->diffInSeconds($timeIn);
                $latestTimeIn->update([
                    'time_in' => $dateTime,
                    'toggle' => 'Break Out',
                    'total_time_consume' => $totalTimeConsumeInSeconds
                ]);
                return response()->json([
                    'message' => 'Time In'
                ], 200);
            }else{
                $newTimeSheet = new TimeSheet();
                $newTimeSheet->user_id = $user->id;
                $newTimeSheet->date = date('Y-m-d');
                $newTimeSheet->toggle = 'Break In';
                $newTimeSheet->time_out = $dateTime;
                $newTimeSheet->save();
                return response()->json([
                    'message' => 'Time Out'
                ], 200);
            }
        }
    }

    public function userCanBreak(){
        $checkUserShift = Informations::where('user_id', Auth::id())->first();
        $current_time = new DateTime;
        $start_time = new DateTime(date('H:i', strtotime($checkUserShift->shift_start  . '+1 hour')));
        $end_time = new DateTime($checkUserShift->shift_end);
        $userCanBreak = $current_time >= $start_time && $current_time <= $end_time;

        return $userCanBreak;
    }

    public function convertSeconds($totalSeconds){
        $remainingTimeInSeconds = intval(abs($totalSeconds) - 3600); // subtract one hour (3600 seconds)
        $remainingMinutes = intval(abs($remainingTimeInSeconds) / 60); // calculate remaining minutes
        $overBreak = 0;
        if($totalSeconds >= 60){
            $timeType = 'Minute'. ($totalSeconds >= 120 ? 's' : '');
            $toMinute = $totalSeconds / 60;
            $totalBreak = intval($toMinute);
        }
        if($totalSeconds >= 3600){
            $timeType = 'Hour'. ($totalSeconds >= 7200 ? 's' : '');
            $toHour = $totalSeconds / 3600;
            $totalBreak = intval($toHour);
        }
        if($totalSeconds < 60){
            $timeType = 'Sec'. ($totalSeconds >= 2 ? 's' : '');
            $totalBreak = intval($totalSeconds);
        }

        $remaining = ($remainingMinutes >= 60 ? 1 .' Hour' : $remainingMinutes . ' ' . 'Minute'. ($totalBreak >= 120 ? '' : 's'));
        $obType = ($totalSeconds > 3600 ? 'Overbreak' : 'Remaining');

        $overBreak = ($totalSeconds > 3600 ? $totalBreak . ' Hour ' . $remaining : $totalBreak . ' ' . $timeType );
        
        return array(
            'break' => $totalBreak, 
            'type' => $timeType, 
            'remaining' => $remaining, 
            'obType'=>$obType, 
            'seconds' => $totalSeconds,
            'overBreakTime' => $overBreak
        );
    }
}
