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
    protected $fillable = ['date', 'time_out', 'time_in', 'total_time_consume', 'toggle'];

    public function timesheet()
    {
        return $this->belongsTo(TimeSheet::class);
    }
}
