<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BalitaMeasurementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'measurement_date' => $this->measurement_date,
            'height_cm' => $this->height,
            'weight_kg' => $this->weight,
            'arm_circumference_cm' => $this->arm_circumference,
            'head_circumference_cm' => $this->head_circumference,
        ];
    }
}
