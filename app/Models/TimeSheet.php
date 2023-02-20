<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;
    use Uuid;

    protected $guarded = [];
    protected $fillable = ['user_id', 'date', 'start_time', 'end_time', 'total_time_consume'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
