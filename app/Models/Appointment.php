<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'schedule_date',
        'target_audience',
    ];

    protected $casts = [
        'schedule_date' => 'datetime',
    ];
}
