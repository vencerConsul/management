<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Informations;
use App\Models\TimeAdjustment;
use App\Models\TimeSheet;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
                $timeAdjustment = TimeAdjustment::where('time_sheet_id', $timesheetRow->id)->first();
                $delay++;

                $html .= '
                    <tr class="t-row" data-aos="fade-up" data-aos-delay="'.$delay.'00">
                        <td class="text-uppercase">'.date('h:i a', strtotime($timesheetRow->time_out)).'</td>
                        <td class="text-uppercase">'.(empty($timesheetRow->time_in) ? '--:--' : date('h:i a', strtotime($timesheetRow->time_in))).'</td>
                        <td class="text-capitalize">';
                        if($timesheetRow->total_time_consume){
                            $calculatedTime = Helper::calculateTotalConsume($timesheetRow->total_time_consume);
                $html .= '<p>'.$calculatedTime['tableTotalConsume'].' </p>';
                        }
                $html .= '</td>
                            <td class="request-adjustment">';
                        if($timesheetRow->total_time_consume){
                $html .= ' '.($timeAdjustment ? '' : '<i class="ti-comments" onclick="showTimeAdjustmentModal(`'.$timesheetRow->id.'`)"></i>').'';
                        }
                $html .= '</td>
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

        $totalTimeSeconds = TimeSheet::where('user_id', Auth::id())
                        ->where('date', date('Y-m-d'))
                        ->selectRaw('SUM(total_time_consume) as total_time')
                        ->get();

        $totalBreak = Helper::calculateTotalConsume($totalTimeSeconds->sum('total_time'));
        $remainingTime = Helper::calculateRemainingTime($totalTimeSeconds->sum('total_time'));
        $timeLog = auth()->user()->timesheet()->latest()->first();
        $toggle = (empty($timeLog->toggle) ? 'Break Out' : $timeLog->toggle);
        return response()->json([
            'table' => $html,
            'breakData' => array(
                'totalBreak' => $totalBreak['totalConsume'],
                'timeType' => $totalBreak['type'],
                'remaining' => $remainingTime['remaining'],
                'obType' => $remainingTime['obType'],
                'seconds' => $totalBreak['seconds'],
                'is_overbreak' => $remainingTime['is_overbreak'],
                'toggle' => Helper::userCanBreak() ? $toggle : 'Refresh at ' . $start_time->format('h:i A')
            ),
            'pagination' => $timesheetsLoop
        ], 200);
    }

    public function toggleTimeSheet(Request $request){
        $user = User::findOrFail(Auth::id());
        $dateTime = date('Y-n-j H:i:s');

        if (!$request->_token == csrf_token() || !Helper::userCanBreak()) {
            return response()->json([
                'message' => 'Unable to perform any actions.'
            ], 422);
        }
        if(!preg_match('/^\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{2}:\d{2}$/', $dateTime)){
            return response()->json([
                'message' => 'Invalid time format'
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
                sleep(1);
                $timeOut = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($latestTimeIn->time_out)));
                $timeIn = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($dateTime)));

                $latestTimeIn->update([
                    'total_time_consume' => $timeOut->diffInSeconds($timeIn),
                    'time_in' => $dateTime,
                    'toggle' => 'Break Out',
                    
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

    public function showTimesheetAdjustment(Request $request){
        $timesheet = TimeSheet::where('id', $request->ID)->first();
        if (!$request->_token == csrf_token() || !$timesheet) {
            return response()->json([
                'message' => 'Unable to perform any actions.'
            ], 422);
        } 

        $html = '<h4 class="text-center mb-4">Request Time Adjustment</h4>
        <div class="row">
                <div class="col-lg-6">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="timesheet_id" value="'.$timesheet->id.'">
                    <div class="form-group">
                        <label for="timeOut">Time Out</label>
                        <input type="time" class="form-control" name="timeOut" id="timeOut" value="'.date('H:i', strtotime($timesheet->time_out)).'">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="timeIn">Time In</label>
                        <input type="time" class="form-control" name="timeIn" id="timeIn" value="'.date('H:i', strtotime($timesheet->time_in)).'">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <textarea name="reason" rows="3" class="form-control" placeholder="Reason"></textarea>
                    </div>
                </div>
            </div>
        <button type="submit" class="btn btn-info mt-2">Submit</button>';

        return response()->json([
            'adjustment_form' => $html
        ], 200);
    }

    public function submitAdjustmentRequest(Request $request){
        $request->validate([
            'timesheet_id' => 'required|string',
            'timeOut' => 'required|date_format:H:i',
            'timeIn' => 'required|date_format:H:i',
            'reason' => 'required|max:255',
        ]);
        $timesheet = TimeSheet::where('id', $request->timesheet_id)->first();
        if(!$timesheet){
            return back()->with('error', 'Something went wrong.');
        }
        
        $timeOut = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($request->timeOut)));
        $timeIn = Carbon::createFromFormat('H:i:s', date('H:i:s', strtotime($request->timeIn)));
        $timsheetAdjustment = TimeAdjustment::create([
            'time_sheet_id' => $request->timesheet_id,
            'time_out' => $request->timeOut,
            'time_in' => $request->timeIn,
            'reason' => $request->reason,
            'total_time_consume' => $timeOut->diffInSeconds($timeIn),
        ]);
        if(!$timsheetAdjustment){
            return back()->with('error', 'Something went wrong, Check your internet connection');
        }
        return back()->with('success', 'Request submited');
    }

    public function loadAdjustmentRequest()
    {
        $timeSheets = TimeSheet::where('user_id', Auth::id())->get();
        $timeSheetsID = [];
        foreach($timeSheets as $timeSheet){
            array_push($timeSheetsID, $timeSheet->id);
        }

        $html = '';
        $delay = 3;
        foreach ($timeSheetsID as $thID) {
            $delay++;
            $adjustmentRequests = TimeAdjustment::where('time_sheet_id', $thID)->first();
            if($adjustmentRequests){
                $html = '<div class="__time_adjustment_request_list d-flex align-items-center justify-content-between mb-2 gap-4" data-aos="fade-up" data-aos-delay="'.$delay.'00">
                <div>
                    <p class="m-0 font-weight-bold">'.date('H:i A', strtotime($adjustmentRequests->time_out)).'</p>
                    <small class="badge bg-warning text-dark">'.$adjustmentRequests->adjustment_status.'</small>
                </div>
                <div>';
                    $paragraph = $adjustmentRequests->reason;

                    if(strlen($paragraph) > 50){
                        $html .= ''.substr($paragraph, 0, 50).'';
                    }else{
                        $html .= ''.$paragraph.'';
                    }
                    $html .= '</div>
                <button class="btn btn-sm btn-info">Edit</button>
            </div>';
            }
        }
        return response()->json([
            'adjustment_request' => $html
        ], 200);

        
    }
}
