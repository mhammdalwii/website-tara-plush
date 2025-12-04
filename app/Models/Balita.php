<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balita extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date_of_birth',
        'gender',
        'address',
        'measurement_date',
        'height',
        'weight',
        'arm_circumference',
        'head_circumference',
    ];

    /**
     * Data balita ini dimiliki oleh seorang User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function measurements()
    {
        return $this->hasMany(BalitaMeasurement::class)->orderBy('measurement_date', 'desc');
    }
}
