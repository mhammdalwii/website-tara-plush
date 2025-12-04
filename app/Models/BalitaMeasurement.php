<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalitaMeasurement extends Model
{
    use HasFactory;
    protected $fillable = ['balita_id', 'measurement_date', 'height', 'weight', 'arm_circumference', 'head_circumference'];
    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }
}
