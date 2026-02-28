<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('consultation.{consultationId}', function ($user, $consultationId) {
    $consultation = \App\Models\Consultation::find($consultationId);

    return $consultation &&
        ($user->id === $consultation->user_id || $user->is_admin);
});
