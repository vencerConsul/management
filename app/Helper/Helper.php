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
            $time_string = sprintf('%d hour'.($hours > 1 ? 's' : '').' %d min'.($minutes > 1 ? 's' : '').' %d sec'.($seconds > 1 ? 's' : '').'', $hours, $minutes, $seconds);
            $type = 'Hour'. ($hours > 1 ? 's' : '');
            $totalConsume = $hours;
        } elseif ($minutes > 0) {
            $time_string = sprintf('%d min'.($minutes > 1 ? 's' : '').' %d sec'.($minutes > 1 ? 's' : '').'', $minutes, $seconds);
            $type = 'minute'. ($minutes > 1 ? 's' : '');
            $totalConsume = $minutes;
        } else {
            $time_string = sprintf('%d sec'.($seconds > 1 ? 's' : '').' ', $seconds);
            $type = 'second'. ($seconds > 1 ? 's' : '');
            $totalConsume = $seconds;
        }

        return array(
            'tableTotalConsume' => $time_string, // table row
            'totalConsume' => $totalConsume, // total consume
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'type' => $type
        );
    }

    public static function calculateRemainingTime($totalSeconds){
        $seconds = $totalSeconds; 

        $remaining_seconds = 3600 - $seconds;
        $hours = (int) floor($remaining_seconds / 3600);
        $remaining_seconds %= 3600;
        $minutes = floor($remaining_seconds / 60);
        $remaining_seconds %= 60;

        if ($remaining_seconds < 0) {
            $totalHours = (int)preg_replace("/-/", "", $hours) - 1;
            // If remaining time is negative, show total time of overbreak
            if ($totalHours > 0) {
                $time_string = sprintf('%d hour %d mins %d sec', abs($hours), abs($minutes), abs($remaining_seconds));
            } else {
                $time_string = sprintf('%d mins %d sec', abs($minutes), abs($remaining_seconds));
            }
        } elseif ($hours > 0) {
            if($hours == 1){
                $time_string = '1 hour';
            }else{
                $time_string = sprintf('%d hour %d mins %d sec', $hours, $minutes, $remaining_seconds);
            }
        } elseif ($minutes > 0) {
            $time_string = sprintf('%d mins %d sec', $minutes, $remaining_seconds);
        } else {
            $time_string = sprintf('%d sec'.($totalSeconds > 1 ? 's' : '').'', $remaining_seconds);
        }

        $overbreak = ($remaining_seconds < 0 ? 'Overbreak' : 'Remaining');

        return [
            'remaining' => $time_string,
            'obType' => $overbreak,
            'is_overbreak' => ($remaining_seconds < 0 ? true : false)
        ];
    }

    public static function userCanBreak(){
        $checkUserShift = Informations::where('user_id', Auth::id())->first();
        $current_time = new DateTime();
        $start_time = new DateTime(date('H:i', strtotime($checkUserShift->shift_start  . '+1 hour')));
        $end_time = new DateTime($checkUserShift->shift_end);
        $userCanBreak = $current_time >= $start_time && $current_time <= $end_time;
        return $userCanBreak;
    }
}