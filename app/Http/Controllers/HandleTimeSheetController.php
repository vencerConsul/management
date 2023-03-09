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

    public function loadUsersOnBreak(Request $request, TimeSheet $timesheet){
        $usersOnBreak = TimeSheet::where('toggle', 'Break In')->orderBy('updated_at', 'DESC')->paginate(7);
        
        $totalSeconds = 0;
        if($usersOnBreak->count() > 0){
            $html = '<table class="table">
            <thead>
            <tr class="t-row-head" data-aos="fade-up" data-aos-delay="100">
                <th>Name</th>
                <th>Time Out</th>
                <th>Remaining</th>
                <th></th>
            </tr>
            </thead>
            <tbody>';

            $delay = 1;
            foreach ($usersOnBreak as $usersOnBreakRow) {
                $getTimeSheetData = TimeSheet::where('user_id', $usersOnBreakRow->user->id)->groupBy('user_id')
                ->selectRaw('user_id, sum(total_time_consume) as total_time_consume')
                ->first();

                $delay++;
                $html .= '
                    <tr class="t-row" data-aos="fade-up" data-aos-delay="'.$delay.'00">
                        <td class="d-flex align-items-center gap-3">
                            <img src="'.$usersOnBreakRow->user->avatar_url.'" alt="image"/>
                            <div>
                            <p>'.$usersOnBreakRow->user->name.'</p>
                            <p>'.$usersOnBreakRow->user->informations->title.'</p>
                            </div>
                        </td>
                        <td class="text-uppercase">'.date('h:i a', strtotime($usersOnBreakRow->time_out)).'</td>
                        <td class="text-capitalize">';
                        if($getTimeSheetData->total_time_consume){
                            $calculatedTime = $this->convertSeconds($getTimeSheetData->total_time_consume);
                            // $current_time = date('Y-m-d H:i:s');
                            // $consume = date('H:i:s', $getTimeSheetData->total_time_consume);
                            $html .= '<p class="___remaining_countdown" data-countdown="'.$getTimeSheetData->total_time_consume.'">'.($getTimeSheetData->total_time_consume > 3600 ? 'Overbreak' : $calculatedTime['remaining']).' </p>';
                        }else{
                            $html .= '<p class="___remaining_countdown" data-countdown="3600">1 Hour</p>';
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
                    <p>No users on break</p>
                </div>
            </div>
        </div>';
        }

        // $totalBreak = $this->convertSeconds($totalSeconds);
        // $timeLog = auth()->user()->timesheet()->latest()->first();
        // $toggle = (empty($timeLog->toggle) ? 'Break Out' : $timeLog->toggle);
        return response()->json([
            'table' => $html,
            // 'breakData' => array(
            //     'totalBreak' => $totalBreak['break'],
            //     'timeType' => $totalBreak['type'],
            //     'remaining' => $totalBreak['remaining'],
            //     'obType' => $totalBreak['obType'],
            //     'seconds' => $totalBreak['seconds'],
            //     'toggle' => $this->userCanBreak() ? $toggle : 'Refresh at ' . $start_time->format('h:i A')
            // ),
            'on_break' => $usersOnBreak->count(),
            'pagination' => $usersOnBreak
        ], 200);
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
