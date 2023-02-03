<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informations extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'department',
        'schedule',
        'address',
        'birth_date',
        'birth_place'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
