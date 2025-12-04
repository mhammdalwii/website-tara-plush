<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(15);
        return NotificationResource::collection($notifications);
    }

    public function markAsRead()
    {
        Auth::user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        return response()->json(['message' => 'Semua notifikasi ditandai telah dibaca.']);
    }

    public function destroy(Notification $notification)
    {
        if (auth()->id() !== $notification->user_id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }
        $notification->delete();
        return response()->json(null, 204); //
    }
}
