<?php 

namespace App\Helper;

use App\Models\Informations;
use DateTime;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function calculateTotalConsume($totalSeconds){
        $seconds = $totalSeconds;

        $hours = floor($seconds / 3600);
        $seconds %= 3600;
        $minutes = floor($seconds / 60);
        $seconds %= 60;

        if ($hours > 0) {
            $time_string = sprintf('%d hour'.($hours > 0 ? 's' : '').' %d min'.($minutes > 0 ? 's' : '').' %d sec'.($seconds > 0 ? 's' : '').'', $hours, $minutes, $seconds);
            $type = 'Hour'. ($hours > 1 ? 's' : '');
        } elseif ($minutes > 0) {
            $time_string = sprintf('%d min'.($minutes > 0 ? 's' : '').' %d sec'.($seconds > 0 ? 's' : '').'', $minutes, $seconds);
            $type = 'minute'. ($minutes > 1 ? 's' : '');
        } else {
            $time_string = sprintf('%d sec'.($seconds > 0 ? 's' : '').' ', $seconds);
            $type = 'second'. ($seconds > 1 ? 's' : '');
        }

        return array(
            'tableTotalConsume' => $time_string, // table row
            'totalConsume' => $time_string, // total consume
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'type' => $type
        );
    }

    public static function calculateRemainingTime($totalSeconds){
        $seconds = $totalSeconds; // Replace this with the number of seconds you want to convert

        $remaining_seconds = 3600 - $seconds;
        $hours = floor($remaining_seconds / 3600);
        $remaining_seconds %= 3600;
        $minutes = floor($remaining_seconds / 60);
        $remaining_seconds %= 60;

        if ($hours > 0) {
            $time_string = sprintf('%d hour %d mins %d sec', $hours, $minutes, $remaining_seconds);
        } elseif ($minutes > 0) {
            $time_string = sprintf('%d mins %d sec', $minutes, $remaining_seconds);
        } else {
            $time_string = sprintf('%d sec', $remaining_seconds);
        }

        return [
            'remaining' => $time_string
        ];
    }

    public static function userCanBreak(){
        $checkUserShift = Informations::where('user_id', Auth::id())->first();
        $current_time = new DateTime();
        $start_time = new DateTime(date('H:i', strtotime($checkUserShift->shift_start  . '+1 hour')));
        $end_time = new DateTime($checkUserShift->shift_end);
        $userCanBreak = $current_time >= $start_time && $current_time <= $end_time;
        if(!$userCanBreak){
            return false;
        }
        return true;
    }
}