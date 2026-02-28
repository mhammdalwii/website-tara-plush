<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal yang akan datang, urutkan dari yang paling dekat
        $appointments = Appointment::where('schedule_date', '>=', now())
            ->orderBy('schedule_date', 'asc')
            ->paginate(10);

        return AppointmentResource::collection($appointments);
    }


    /**
     * ==========================================================
     * TAMBAHKAN FUNGSI BARU DI BAWAH INI
     * ==========================================================
     *
     * Menampilkan riwayat jadwal yang sudah lewat.
     */

    public function history()
    {
        // Ambil semua jadwal yang tanggalnya sudah lewat
        $appointments = Appointment::where('schedule_date', '<', now())
            // Urutkan dari yang paling baru selesai (descending)
            ->orderBy('schedule_date', 'desc')
            ->paginate(10);

        // Kembalikan data menggunakan resource yang sama
        return AppointmentResource::collection($appointments);
    }
}
