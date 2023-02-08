<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLogs extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'log_in',
        'log_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
