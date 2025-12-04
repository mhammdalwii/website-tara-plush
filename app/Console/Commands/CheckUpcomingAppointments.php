<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class CheckUpcomingAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-upcoming-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa jadwal pemeriksaan yang akan datang besok dan buat notifikasi untuk semua pengguna.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa jadwal untuk besok...');

        // Ambil tanggal untuk "besok"
        $tomorrow = Carbon::tomorrow()->toDateString();

        // Cari semua jadwal yang akan berlangsung besok
        $appointmentsForTomorrow = Appointment::whereDate('schedule_date', $tomorrow)->get();

        if ($appointmentsForTomorrow->isEmpty()) {
            $this->info('Tidak ada jadwal untuk besok. Tidak ada notifikasi yang dibuat.');
            return;
        }

        // Ambil semua ID pengguna
        $users = User::all();

        foreach ($appointmentsForTomorrow as $appointment) {
            foreach ($users as $user) {
                // Buat notifikasi untuk setiap pengguna
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Jangan Lupa, Jadwal Pemeriksaan Besok!',
                    'message' => 'Ada jadwal "' . $appointment->title . '" di ' . $appointment->location . ' pada tanggal ' . $appointment->schedule_date->format('d M Y, H:i'),
                    'link' => route('jadwal.index'), // Link ke halaman daftar jadwal
                ]);
            }
        }

        $this->info('Notifikasi berhasil dibuat untuk ' . $appointmentsForTomorrow->count() . ' jadwal dan ' . $users->count() . ' pengguna.');
    }
}
