<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informations extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender', 'date_of_birth', 'address_1', 'address_2', 'title',
        'department', 'shift_start', 'shift_end', 'contact_number',
        'emergency_contact_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
