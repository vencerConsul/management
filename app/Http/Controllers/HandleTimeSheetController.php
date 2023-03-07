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

    public function loadTimeSheet(Request $request, TimeSheet $timesheet){
        $usersOnBreak = TimeSheet::where('')
        
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
