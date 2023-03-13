<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeAdjustment extends Model
{
    use HasFactory;

    use Uuid;

    protected $guarded = [];
    protected $fillable = ['time_sheet_id', 'time_out', 'time_in', 'total_time_consume', 'reason'];

    public function timesheet()
    {
        return $this->belongsTo(TimeSheet::class, 'time_sheet_id');
    }
}
